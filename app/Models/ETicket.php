<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ETicket extends Model
{
    use HasFactory;
    protected $table = 'eticket';

    protected $fillable = ['id_user', 'id_owner', 'id_destinasi', 'id_ticket', 'name_visitor', 'contact_visitor', 'date_visit'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket')->select('id', 'price', );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user')->select('id', 'name', 'email');
    }
    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class, 'id_destinasi')->select('id', 'name_destinasi', 'address', 'contact', 'open-hour', 'closed-hour');
    }


    // protected static function boot()
    // {
    //     parent::boot();

    //     static::created(function ($eTicket) {
    //         $ticket = Ticket::findOrFail($eTicket->id_ticket);
    //         $ticket->decrement('stock');
    //     });
    // }

    public function owner()
    {
        return $this->belongsTo(OwnerBusiness::class, 'id_owner')->select('id', 'nama_owner');
    }

}