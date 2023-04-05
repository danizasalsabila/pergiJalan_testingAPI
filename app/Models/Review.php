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
        return $this->belongsTo(Destinasi::class, 'id_destinasi');
    }

    protected $fillable = ['id_destinasi', 'review', 'rating', 'created_at'];
}