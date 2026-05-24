<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\Passport;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use  HasRoles , HasApiTokens , Notifiable;

    protected $fillable = ['name','type'];

    public function normalUser()
    {
        return $this->hasOne(NormalUser::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
    public function conversations()
    {
      return $this->hasMany(Conversation::class);
    }



}