<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'review';

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class, 'id_destinasi')->select('id','id_owner');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user')->select('id', 'name', 'email',);
    }

    protected $fillable = ['id_destinasi', 'id_user', 'review', 'rating', 'created_at'];
}