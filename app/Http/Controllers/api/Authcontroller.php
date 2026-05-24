<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginAccountRequest;
use App\Http\Requests\RegisterAccountRequest;
use App\Http\Requests\sendotprequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\AuthServiceApi;
use Illuminate\Http\Request;

class Authcontroller extends Controller
{
    protected $authserviceapi;
    public function __construct(AuthServiceApi $authServiceApi)
    {
      $this->authserviceapi =$authServiceApi ;

    }

    public function register(RegisterAccountRequest $request)
    {
        $result = $this->authserviceapi->register($request->validated());

        if ($result === 'too_many_requests') {
            return response()->json([
                'status' => false,
                'message' => 'Too many requests'
            ], 429);
        }

        return response()->json([
            'status' => true,
            'message' => 'OTP sent'
        ]);
    }

    public function verifyOtp(sendotprequest $request)
    {
        $result = $this->authserviceapi->verifyOtp($request->validated());

        if (is_string($result)) {
            return response()->json([
                'status' => false,
                'message' => $result
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Account created',
            'data' => $result
        ]);
    }
    /////////////////////////
    public function login(LoginAccountRequest $loginAccountRequest)
    {
      $login =  $this->authserviceapi->login($loginAccountRequest->validated());
       if (!$login) {
           return response()->json([
               'status' => false,
               'message' => 'Invalid credentials'
           ], 401);
       }

       return response()->json([
           'status' => true,
           'data' => $login
       ]);
   }
   public function logout(Request $request)
    {
        $this->authserviceapi->logout($request->user());

        return response()->json([
            'status' => true,
            'message' => __('messages.logout')
        ]);
    }






    //updateuser
    public function sendUpdateOtp(UpdateUserRequest $request)
{
    $user = $request->user();

    $this->authserviceapi->sendUpdateOtp($user, $request->validated());

    return response()->json([
        'status' => true,
        'message' => 'OTP sent to new phone'
    ]);
}

public function verifyUpdateOtp(Request $request)
{
    $result = $this->authserviceapi->verifyUpdateOtp($request->all());

    if (is_string($result)) {
        return response()->json([
            'status' => false,
            'message' => $result
        ], 422);
    }

    return response()->json($result);
}
    }