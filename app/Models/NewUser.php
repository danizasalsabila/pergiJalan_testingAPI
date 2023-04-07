<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewUser extends Model
{
    use HasFactory;
    protected $table = 'new_user';

    protected $hidden = [
        'password',
    ];

    protected $fillable = ['name', 'email', 'password', 'phone_number', 'id_card_number','created_at'];


}
