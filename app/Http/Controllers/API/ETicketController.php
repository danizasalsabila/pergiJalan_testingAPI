<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ETicket;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ETicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eticket = ETicket::with('ticket')->get();
        if ($eticket != null) {
            return response([
                'status' => 'success',
                'message' => 'E-Ticket Berhasil ditampilkan',
                'data' => $eticket
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'message' => 'E-Ticket gagal ditampilkan'
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
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function showByIdOwner($id)
    {
        //
        $eticket = ETicket::where('id_owner', $id)->orderBy('id', 'desc')->get();
        ;
        if ($eticket->count() > 0) {
            return response([
                'status' => 'E-Ticket berdasarkan id owner berhasil ditampilkan',
                'data' => $eticket
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'message' => 'eticket tidak ditemukan'
            ], 404);
        }
    }


    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function showByIdUser($id)
    {
        //
        $eticket = ETicket::where('id_user', $id)->orderBy('id', 'desc')->get();
        ;
        if ($eticket->count() > 0) {
            return response([
                'status' => 'E-Ticket berdasarkan id user berhasil ditampilkan',
                'data' => $eticket
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'message' => 'eticket tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function showByIdTicket($id)
    {
        //
        $eticket = ETicket::where('id_ticket', $id)->orderBy('id', 'desc')->get();
        ;
        if ($eticket->count() > 0) {
            return response([
                'status' => 'E-Ticket berdasarkan id ticket berhasil ditampilkan',
                'data' => $eticket
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'message' => 'eticket tidak ditemukan'
            ], 404);
        }
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
            'id_user' => 'required|exists:user,id',
            'id_owner' => 'required|exists:owner_business,id',
            'id_ticket' => 'required|exists:ticket,id',
            'name_visitor' => 'required|string',
            'contact_visitor' => 'required|string',
            'date_visit' => 'required|string',
        ]);

        $eticket = new ETicket;
        $eticket->id_user = $request->input('id_user');
        $eticket->id_owner = $request->input('id_owner');
        $eticket->id_ticket = $request->input('id_ticket');
        $eticket->name_visitor = $request->input('name_visitor');
        $eticket->contact_visitor = $request->input('contact_visitor');
        $eticket->date_visit = $request->input('date_visit');
        $eticket->date_book = $dt;
        $eticket->save();

        if ($eticket != null) {
            return response([
                'status' => 'success',
                'message' => 'E-Ticket Berhasil Ditambahkan',
                'data' => $eticket
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'message' => 'E-Ticket gagal Ditambahkan'
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getETicketByYearOwner(Request $request, $id_owner)
    {
        // $id_owner = $request->id_owner;
        $year = $request->input('year');

        $eticket = ETicket::where('id_owner', $id_owner)->whereYear('date_book', $year)->get();

        if ($eticket->count() > 0) {
            return response([
                'status' => 'success',
                'message' => 'E-Ticket berdasarkan tahun Berhasil Ditampilkan',
                'data' => $eticket
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'message' => 'E-Ticket gagal Ditampilkan'
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getETicketByMonthOwner(Request $request, $id_owner)
    {
        // $id_owner = $request->id_owner;
        $year = $request->input('year');
        $month = $request->input('month');

        $eticket = ETicket::where('id_owner', $id_owner)->whereYear('date_book', $year)->whereMonth('date_book', $month)->get();

        if ($eticket->count() > 0) {
            return response([
                'status' => 'success',
                'message' => 'E-Ticket berdasarkan bulan' . $month . 'Berhasil Ditampilkan',
                'data' => $eticket
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'message' => 'E-Ticket gagal Ditampilkan'
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function getETicketByWeekOwner(Request $request, $id_owner)
    {
        // $id_owner = $request->id_owner;
        // $date = $request->input('date');

        $date = Carbon::parse($request->input('date'))->startOfDay();
        $endDate = $date->copy()->addDays(7)->endOfDay();

        $eticket = ETicket::where('id_owner', $id_owner)->whereBetween('date_book', [$date, $endDate])->get();

        if ($eticket->count() > 0) {
            return response([
                'status' => 'success',
                'message' => 'E-Ticket mulai dari tanggal ' . $date . ' hingga ' . $endDate . ' Berhasil Ditampilkan',
                'data' => $eticket
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'message' => 'E-Ticket berdasarkan minggu gagal Ditampilkan'
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
     */
    public function destroy(string $id)
    {
        //
    }
}