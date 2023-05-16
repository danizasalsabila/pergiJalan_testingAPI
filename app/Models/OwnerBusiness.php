<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as AuthenticatableUser;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class OwnerBusiness extends AuthenticatableUser implements Authenticatable
{
    use Notifiable, HasApiTokens;
    protected $table = 'owner_business';
    protected $fillable = [
        'nama_owner',
        'email',
        'password',
        'contact_number',
        'id_card_number',
        'address'
    ];
    protected $hidden = ['password'];

}