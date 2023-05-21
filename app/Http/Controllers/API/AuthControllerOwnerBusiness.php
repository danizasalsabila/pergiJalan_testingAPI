<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Models\OwnerBusiness;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthControllerOwnerBusiness extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_owner' => 'required',
            'email' => 'email|required|unique:owner_business,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'address' => 'required|string',
            'contact_number' => 'required|string',
            'id_card_number' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('email')) {
                return response()->json([
                    'status' => false,
                    'error' => $errors->first('email'),
                    'message' => 'Email sudah terdaftar'
                ], 409);
            } else if ($errors->has('password')) {
                return response()->json([
                    'status' => false,
                    'error' => $errors->first('password'),
                    'message' => 'Masukkan password minimal 6 karakter'

                ], 422);
            } else if ($errors->has('confirm_password')) {
                return response()->json([
                    'status' => false,
                    'error' => $errors->first('confirm_password'),
                    'message' => 'Konfirmasi password salah'

                ], 422);
            } else {
                return response()->json([
                    'status' => false,
                    'errors' => $errors
                ], 400);
            }
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $owner = OwnerBusiness::create($input);

        $success['nama_owner'] = $owner->nama_owner;

        return response()->json([
            'status' => true,
            'message' => 'Register sukses',
            'data' => $success
        ]);

    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('owner')->attempt($credentials)) {
            $owner = Auth::guard('owner')->user();
            $token = $owner->createToken('owner-token')->plainTextToken;
            $success['id'] = $owner->id;
            $success['nama_owner'] = $owner->nama_owner;
            $success['email'] = $owner->email;
            $success['token'] = $token;

            return response()->json([
                'success' => true,
                'message' => 'Login sukses',
                'data' => $success,
                // 'token' => $token
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Cek email dan password anda kembali',
            ], 422);
        }

    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful'
        ]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $owner = DB::table('owner_business')->orderBy('id', 'asc')->get();

        if ($owner != null) {
            return response([
                'success' => true,
                'message' => 'Data owner berhasil ditampilkan',
                'data' => $owner
            ], 200);
        } else {
            return response([
                'success' => false,
                'message' => 'Data owner tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
    //  */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $owner = OwnerBusiness::where('id', $id)->first();
        if ($owner != null) {
            return response([
                'status' => true,
                'message' => 'Data diri owner tempat wisata berhasil ditampilkan',
                'data' => $owner
            ], 200);
        } else {
            return response([
                'status' => false,
                'message' => 'owner tempat wisata tidak ditemukan'
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