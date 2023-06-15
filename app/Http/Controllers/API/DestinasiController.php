<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Destinasi;
use App\Models\OwnerBusiness;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DestinasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *  @return \Illuminate\Http\Response
     */
    public function index()
    {
        $destinasi = DB::table('destinasi')->orderBy('id', 'desc')->get();

        if ($destinasi != null) {
            return response([
                'status' => 'Data destinasi berhasil ditampilkan',
                'code' => 200,
                'data' => $destinasi
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'code' => 404,
                'message' => 'Data destinasi tidak ditemukan'
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
        //
        $dt = new DateTime();
        $tahun = $dt->format('y');
        $bulan = $dt->format('m');

        // $destinasi =Destinasi::orderBy('id', 'desc')->get();

        $requestDestinasi = [
            'name_destinasi' => $request->name_destinasi,
            'description' => $request->description,
            'id_owner' => $request->id_owner,
            'address' => $request->address,
            'city' => $request->city,
            'category' => $request->category,
            'destination_picture' => $request->destination_picture,
            'contact' => $request->contact,
            'hobby' => $request->hobby,
            'minutes_spend' => $request->minutes_spend,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'url_map' => $request->url_map,
            'rec_weather' => $request->rec_weather,
            'open-hour' => $request->open_hour,
            'closed-hour' => $request->closed_hour,
            'created_at' => $dt,
            'fasility' => $request->fasility,
            'security' => $request->security,



        ];

        $createDestinasi = DB::table('destinasi')->insertGetId($requestDestinasi);


        // $createDestinasi = DB::table('destinasi')->insert($requestDestinasi);

        if ($createDestinasi != null) {
            return response([
                'status' => 'success',
                'message' => 'Destinasi Berhasil Ditambahkan',
                'id' => $createDestinasi,
                'data' => $requestDestinasi
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'message' => 'Destinasi gagal Ditambahkan'
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $destinasi = Destinasi::where('id', $id)->first();
        if ($destinasi != null) {
            return response([
                'status' => 'Data destinasi berhasil ditampilkan',
                'data' => $destinasi
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'message' => 'destinasi tidak ditemukan'
            ], 404);
        }
    }


    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function showByIdOwner($id)
    {
        //
        $destinasi = Destinasi::where('id_owner', $id)->orderBy('id', 'desc')->get();
        ;
        if ($destinasi->count() > 0) {
            return response([
                'status' => 'Destinasi ID OWNER: $id berhasil ditampilkan',
                'data' => $destinasi
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'message' => 'destinasi tidak ditemukan'
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $getDestinasi = Destinasi::where('id', $id)->first();
        // $getDestinasi = Destinasi::find($id);

        if (!$getDestinasi) {
            return response([
                'status' => 'failed',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
        $dt = new DateTime();
        $tahun = $dt->format('y');
        $bulan = $dt->format('m');

        $requestDestinasi = [
            'name_destinasi' => $request->name_destinasi,
            'description' => $request->description,
            'address' => $request->address,
            'city' => $request->city,
            'category' => $request->category,
            'destination_picture' => $request->destination_picture,
            'contact' => $request->contact,
            'hobby' => $request->hobby,
            'minutes_spend' => $request->minutes_spend,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'url_map' => $request->url_map,
            'rec_weather' => $request->rec_weather,
            'open-hour' => $request->open_hour,
            'closed-hour' => $request->closed_hour,
            'fasility' => $request->fasility,
            'security' => $request->security,
            'updated_at' => $dt
        ];

        $id = $getDestinasi->id;
        $updateDestinasi = DB::table('destinasi')->where('id', $id)->update($requestDestinasi);

        if ($updateDestinasi != null) {
            return response([
                'status' => 'success',
                'message' => 'Destinasi Berhasil Diedit',
                'data' => $requestDestinasi
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'message' => 'Destinasi gagal Diedit'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $getDestinasi = Destinasi::where('id', $id)->first();
        $destinasi = Destinasi::where('id', $id)->delete();

        if ($destinasi) {
            return response([
                'status' => 'success',
                'message' => 'Data berhasil dihapus'
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'message' => 'Data gagal dihapus'
            ], 404);
        }

    }


    public function search(Request $request)
    {
        $searchQuery = $request->q;
        if (empty($searchQuery)) {
            return response([
                'status' => 'failed',
                'message' => 'Parameter pencarian tidak boleh kosong'
            ], 400);
        }
        $destinasi = Destinasi::where('name_destinasi', 'LIKE', "%" . $searchQuery . "%")
            ->orWhere('city', 'LIKE', "%" . $searchQuery . "%")
            ->orWhere('category', 'LIKE', "%" . $searchQuery . "%")
            ->get();

        if ($destinasi->count() > 0) {
            return response([
                'status' => 'success',
                'message' => 'Destinasi yang dicari Berhasil Ditampilkan',
                'data' => $destinasi
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'message' => 'Destinasi yang dicari gagal tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function city(Request $request)
    {
        $searchQuery = $request->q;

        $destinasi = Destinasi::where('city', 'LIKE', "%" . $searchQuery . "%")->get();

        if ($destinasi->count() > 0) {
            return response([
                'status' => 'success',
                'message' => 'Destinasi berdasarkan kota Berhasil Ditampilkan',
                'data' => $destinasi
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'message' => 'Destinasi wisata kota gagal ditemukan!'
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function category(Request $request)
    {
        $searchQuery = $request->q;

        $destinasi = Destinasi::where('category', 'LIKE', "%" . $searchQuery . "%")->get();

        if ($destinasi->count() > 0) {
            return response([
                'status' => 'success',
                'message' => 'Destinasi berdasarkan kategori Berhasil Ditampilkan',
                'data' => $destinasi
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'message' => 'Destinasi wisata kategori gagal ditemukan!'
            ], 404);
        }
    }
}