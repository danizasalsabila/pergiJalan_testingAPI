<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuthControllerUser extends Controller
{
    // //this works!
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email|required|unique:user',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'phone_number' => 'required|string',
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
        $user = User::create($input);

        // $success['token'] = $user->createToken('auth_token')->plainTextToken;
        $success['name'] = $user->name;

        return response()->json([
            'success' => true,
            'message' => 'Register sukses',
            'data' => $success
        ]);

    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $auth = Auth::user();
            $success['token'] = $auth->createToken('auth_token')->plainTextToken;
            $success['name'] = $auth->name;
            $success['email'] = $auth->email;
            $success['id'] = $auth->id;

            return response()->json([
                'success' => true,
                'message' => 'Login sukses',
                'data' => $success
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
        $user = DB::table('user')->orderBy('id', 'asc')->get();

        if ($user != null) {
            return response([
                'success' => true,
                'code' => 200,
                'message' => 'Data user berhasil ditampilkan',
                'data' => $user
            ], 200);
        } else {
            return response([
                'success' => false,
                'code' => 404,
                'message' => 'Data user tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function email(Request $request)
    {
        $userEmail = $request->q;

        if (empty($userEmail)) {
            return response([
                'success' => false,
                'message' => 'Email harus diberikan'
            ], 400);
        }


        $user = User::where('email', 'LIKE', "%" . $userEmail . "%")->get();

        if ($user->isEmpty()) {
            return response([
                'success' => false,
                'message' => 'Tidak ada user yang ditemukan berdasarkan email yang diberikan'
            ], 404);
        }
        return response([
            'success' => true,
            'message' => 'User berhasil ditemukan',
            'data' => $user
        ], 200);
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
     */
    public function show(string $id)
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