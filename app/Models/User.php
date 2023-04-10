<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthenticatableUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends AuthenticatableUser implements Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $table = 'user';
    protected $fillable = ['name', 'email', 'phone_number', 'id_card_number', 'password'];
    protected $hidden = ['password'];


}
