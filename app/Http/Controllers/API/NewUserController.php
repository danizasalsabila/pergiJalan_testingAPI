<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\NewUser;
use Illuminate\Http\Request;

class NewUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = NewUser::all();
        if($users != null) {
            return response ([
                'status' => 'Success',
                'message'=> 'User PergiJalan berhasil ditampilkan',
                'code' => 200,
                'data' => $users
            ], 200);
        } else {
            return response ([
                'status' => 'failed',
                'code' => 404,
                'message' => 'Data User tidak ditemukan'
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
        $users = NewUser::create($request->all());
        return response()->json([
            'status' => 'User berhasil ditambahkan',
            'code' => 200,
            'data' => $users], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(NewUser $users)
    {
        return response()->json(['data' => $users], 200);
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