<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'ticket';




    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class, 'id_destinasi');
    }
     protected $fillable = ['id_destinasi', 'price', 'stock', 'ticket_sold', 'visit_date', 'created_at'];


}
