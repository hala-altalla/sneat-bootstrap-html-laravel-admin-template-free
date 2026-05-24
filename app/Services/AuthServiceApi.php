<?php

namespace App\Services ;

use App\Models\NormalUser;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthServiceApi
{

  public function sendOtp(array $data)
  {
      $count = Otp::where('phone', $data['phone'])
          ->where('created_at', '>=', now()->subMinutes(5))
          ->count();

      if ($count >= 3) return 'too_many_requests';

      $otp = random_int(100000, 999999);

      Otp::create([
          'phone' => $data['phone'],
          'code' => Hash::make($otp),
          'expires_at' => now()->addMinutes(5),
          'is_used' => false,
          'attempts' => 0,
          'payload' => json_encode([
              'name' => $data['name'],
              'password' => $data['password']
          ])
      ]);

      Http::post('https://api.ultramsg.com/instance176719/messages/chat', [
          'token' => 'sjmbgym4hggu2pap',
          'to' => $data['phone'],
          'body' => "Your OTP code is: $otp"
      ]);

      return true;
  }

  public function register(array $data)
  {
      return $this->sendOtp($data);
  }

  public function verifyOtp(array $data)
  {
      $otpRecord = Otp::where('phone', $data['phone'])
          ->where('is_used', false)
          ->latest()
          ->first();

      if (!$otpRecord) return 'no_otp';
      if ($otpRecord->expires_at < now()) return 'expired';
      if ($otpRecord->attempts >= 5) return 'blocked';

      if (!Hash::check($data['otp'], $otpRecord->code)) {
          $otpRecord->increment('attempts');
          return 'invalid_otp';
      }

      $otpRecord->update(['is_used' => true]);

      $payload = json_decode($otpRecord->payload, true);

      $user = User::create([
          'name' => $payload['name'],
          'type' => 'normal_user'
      ]);

      NormalUser::create([
          'user_id' => $user->id,
          'phone' => $data['phone'],
          'password' => Hash::make($payload['password'])
      ]);

      $tokenresult = $user->createToken('API Token');
      $token=$tokenresult->accessToken;

    return [
        'user' => $user,
        'token' => $token
    ];
    }
//////////////////////////////
  public function login(array $data)
  {
    $normaluser = NormalUser::with('user')->where('phone', $data['phone'])->first();

    if (!$normaluser || !Hash::check($data['password'], $normaluser->password)) {
        return null;
    }

    $user = $normaluser->user;
    if (!$user) {
        return [
            'status' => false,
            'message' => 'User not found'
        ];
      }
      $tokenresult = $user->createToken('API Token');
      $token=$tokenresult->accessToken;

    return [
        'user' => $user,
        'token' => $token
    ];
  }
  public function logout($user)
  {
    $user->token()->revoke();
    return true;
  }



  //update user
  public function sendUpdateOtp($user, array $data)
{
    $otp = random_int(100000, 999999);

    Otp::create([
        'phone' => $data['phone'],
        'code' => Hash::make($otp),
        'expires_at' => now()->addMinutes(5),
        'is_used' => false,
        'attempts' => 0,
        'payload' => json_encode([
            'user_id' => $user->id,
            'name' => $data['name'],
            'phone' => $data['phone'],
            'password' => $data['password']
        ])
    ]);

    Http::post('https://api.ultramsg.com/instance176719/messages/chat', [
        'token' => 'sjmbgym4hggu2pap',
        'to' => $data['phone'],
        'body' => "Your OTP code is: $otp"
    ]);

    return true;
}
//
public function verifyUpdateOtp($data)
{
    $otpRecord = Otp::where('phone', $data['phone'])
        ->where('is_used', false)
        ->latest()
        ->first();

    if (!$otpRecord) return 'no_otp';
    if ($otpRecord->expires_at < now()) return 'expired';
    if ($otpRecord->attempts >= 5) return 'blocked';

    if (!Hash::check($data['otp'], $otpRecord->code)) {
        $otpRecord->increment('attempts');
        return 'invalid_otp';
    }

    $otpRecord->update(['is_used' => true]);

    $payload = json_decode($otpRecord->payload, true);

    $user = User::find($payload['user_id']);

    if (!$user) return 'user_not_found';

    // تحديث الاسم
    $user->update([
        'name' => $payload['name']
    ]);

    // تحديث الهاتف + password من normalUser
    $user->normalUser->update([
        'phone' => $payload['phone'],
        'password' => $payload['password']
    ]);

    return [
        'status' => true,
        'message' => 'User updated successfully'
    ];
}
}
