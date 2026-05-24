<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\App;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  protected $authservice ;
  public function __construct(AuthService $authService)
  {
    $this->authservice = $authService;
  }

  public function showloginpage()
  {
      return view('admin.login');
  }
  public function login(LoginRequest $loginRequest)
  {

        $user= $this->authservice->login($loginRequest->validated());
        if(!$user)
        {
          return redirect()->back()->with('errore' , 'invalid cardentials')->withInput();
        }

          Auth::guard('web')->login($user->user);

        return redirect()->route('admin.home');

  }

  public function logout(Request $request)
  {
    $this->authservice->logout($request);

    return redirect()->route('admin.login')->with('success','logged out successfully');

  }



}