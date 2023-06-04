<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Destinasi;
use App\Models\Review;
use DateTime;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function getRating($id)
    {
        $idDestinasi = Destinasi::find($id);
        if (!$idDestinasi) {
            return response()->json([
                'message' => 'Destinasi tidak ditemukan'
            ], 404);
        }

        $ratingCount = $idDestinasi->ratings->count();
        if ($ratingCount > 0) {
            $totalRating = $idDestinasi->ratings->sum('rating');
            $avgRating = $totalRating / $ratingCount;
            // $avgRating = number_format($avgRating, 1, '.', '');
        } else {
            $avgRating = 0.0;
        }

        // Cek tipe data avgRating



        if ($ratingCount != null) {
            return response([
                'status' => true,
                'message' => 'Penilaian berhasil ditampilkan',
                'id_destinasi' => $idDestinasi->id,
                'rating' => doubleval($avgRating)
            ], 200);
        } else if ($ratingCount == null) {
            return response([
                'status' => false,
                'message' => 'Belum terdapat penilaian',
                // 'id_destinasi' => $idDestinasi->id,
            ], 202);
        } else {
            return response([
                'status' => false,
                'message' => 'Failed'
            ], 400);
        }
    }

    public function getRatingByIdOwner($id)
    {
        $reviews = Review::whereHas('destinasi', function ($query) use ($id) {
            $query->where('id_owner', $id);
        })->get();
        
        if ($reviews->isEmpty()) {
            return response()->json([
                'message' => 'Belum terdapat penilaian',
            ], 202);
        }
    
        $ratingCount = $reviews->count();
        $totalRating = $reviews->sum('rating');
        $avgRating = $totalRating / $ratingCount;
    
        return response()->json([
            'status' => true,
            'message' => 'Penilaian berhasil ditampilkan',
            'id_owner' => $id,
            'rating' => doubleval($avgRating)
        ], 200);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $review = Review::with('destinasi')->get();
        // $review = Review::with('review')->get();


        if ($review != null) {
            return response([
                'status' => 'success',
                'message' => 'Raview Berhasil ditampilkan',
                'data' => $review
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'message' => 'Raview gagal ditampilkan'
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
     */
    public function store(Request $request)
    {
        $dt = new DateTime();
        $tahun = $dt->format('y');
        $bulan = $dt->format('m');

        $request->validate([
            'id_destinasi' => 'required|exists:destinasi,id',
            'id_user' => 'required|exists:user,id',
            'review' => 'nullable|string',
            'rating' => 'required|min:1|max:5',
        ]);


        $review = new Review;
        $review->id_destinasi = $request->input('id_destinasi');
        $review->id_user = $request->input('id_user');
        $review->review = $request->input('review');
        $review->rating = $request->input('rating');

        $review->created_at = $dt;
        $review->save();

        if ($review != null) {
            return response([
                'status' => 'success',
                'message' => 'Review Berhasil Ditambahkan',
                'data' => $review
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'message' => 'Review gagal Ditambahkan'
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        //
        $review = Review::with('user')->where('id_destinasi', $id)->orderBy('id', 'desc')->get();

        if ($review != null) {
            return response([
                'status' => 'Review berhasil ditampilkan',
                'data' => $review
            ], 200);
        } else {
            return response([
                'status' => 'failed',
                'message' => 'Review tidak ditemukan'
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
     */
    public function destroy(string $id)
    {
        //
    }
}