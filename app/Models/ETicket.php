<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ETicket extends Model
{
    use HasFactory;
    protected $table = 'eticket';
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket')->select('id','id_destinasi', 'price', 'stock');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function owner()
    {
        return $this->belongsTo(OwnerBusiness::class, 'id_owner');
    }
    protected $fillable = ['id_user', 'id_owner','id_ticket', 'name_visitor', 'contact_visitor', 'date_visitor', 'date_book'];
}
