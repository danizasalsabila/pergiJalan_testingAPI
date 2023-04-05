<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use DateTime;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $ticket = Ticket::with('ticket')->get();
        $ticket = Ticket::with('destinasi')->get();

        // return response()->json([
        //     'ticket' => $ticket
        // ]);

        if($ticket != null){
            return response([
                'status' => 'success',
                'message' => 'Tiket Berhasil ditampilkan',
                'data' => $ticket
            ], 200);
        } else {
            return response ([
                'status' => 'failed',
                'message' => 'Tiket gagal ditampilkan'
            ], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dt = new DateTime();
        $tahun = $dt->format('y');
        $bulan = $dt->format('m');
        
        $request->validate([
            'id_destinasi' => 'required|exists:destinasi,id',
            'price' =>'nullable|integer|min:1',
            'stock' =>'nullable|integer|min:0',
            'visit_date' =>'nullable|string',
        ]);
    
        $ticket = new Ticket;
        $ticket->id_destinasi = $request->input('id_destinasi');
        $ticket->price = $request->input('price');
        $ticket->stock = $request->input('stock');
        $ticket->visit_date = $request->input('visit_date');
        $ticket->created_at = $dt;
        $ticket->save();

        if($ticket != null){
            return response([
                'status' => 'success',
                'message' => 'Ticket Berhasil Ditambahkan',
                'data' => $ticket
            ], 200);
        } else {
            return response ([
                'status' => 'failed',
                'message' => 'Ticket gagal Ditambahkan'
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     *  @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        // $ticket = Ticket::where('id_destinasi', $id)->get();
        $ticket = Ticket::where('id_destinasi', $id)->first();
        if($ticket != null) {
            return response ([
                'status' => 'Ticket berhasil ditampilkan',
                'data' => $ticket
            ], 200);
        } else {
            return response ([
                'status' => 'failed',
                'message' => 'Ticket tidak ditemukan'
            ], 404);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *  @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getTicket = Ticket::where('id_destinasi', $id)->first();
        $ticket = Ticket::where('id_destinasi', $id)->delete();
        
        if($ticket){
            return response([
                'status' => 'success',
                'message' => 'Data berhasil dihapus'
            ], 200);
        }else{
            return response([
                'status' => 'failed',
                'message' => 'Data gagal dihapus'
            ], 404);
        }

    }
}
