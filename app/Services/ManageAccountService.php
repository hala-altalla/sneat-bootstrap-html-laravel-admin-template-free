<?php

namespace App\Services ;
use App\Models\Admin;
use App\Models\NormalUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;



class ManageAccountService
{
  public function store(array $data)
  {
    $user= User::create([
      'name' => $data['name'] ,
      'type' => 'admin'

    ] );
    $admin = Admin::create([
      'user_id'=>$user->id ,
      'email' => $data['email'] ,
      'password' => Hash::make($data['password'])
    ]);
  }

  public function addusers(array $data)
  {
    $user=User::create([
      'name'=>$data['name'] ,
      'type'=>'normal_user'
    ]);
    $normaluser=NormalUser::create([
          'user_id'=>$user->id,
          'phone'=>$data['phone'],
          'password'=>Hash::make($data['password'])
    ]) ;
    return $normaluser;

  }
  public function search($search)
    {
        $users = NormalUser::with('user')
            ->where(function ($query) use ($search) {

                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                })
                ->orWhere('phone', 'like', "%$search%");})->get();

        return $users->map(function ($u) {
            return [
                'name' => $u->user->name ?? '',
                'phone' => $u->phone,
                'type' => $u->user->type ?? '',
            ];
        });
    }

    // جلب كل المستخدمين
    public function getAll()
    {
        return NormalUser::with('user')->get();
    }

    public function updateadmin(array $data , $idadmin)
    {
      $admin=Admin::findorfail($idadmin);
      $admin->user->update([
        'name'=>$data['name']
      ]);
      $admin->update([
        'email' => $data['email'] ,
        'password'=>Hash::make($data['password'])
      ]);
      $admin->save();
      return $admin;
    }
    public function deleteadmin(Admin $admin)
    {
      $admin->user->delete();

      $admin->delete();


    }
    public function updatenormaluser( array $data ,$id )
    {
      $normaluser=NormalUser::findorfail($id);
      $normaluser->user->update(
        [
          'name' =>  $data['name']
        ]
        );
      $normaluser->update(
        [
          'phone' =>$data['phone'] ,
          'password'=> Hash::make($data['password'])
        ]
        );
        $normaluser->save();
        return $normaluser;
    }
    public function deleteuser($id)
    {
      $user=NormalUser::findorfail($id);
      if($user->businessaccounts()->exists())
      {
        return 'business';
      }

      $user->user->delete();
      $user->delete();
      return 'delete';



    }
}

?>
