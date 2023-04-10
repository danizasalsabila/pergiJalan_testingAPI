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
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'phone_number' => 'required|string',
            'id_card_number' => 'required|string',

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('email')) {
                return response()->json(['error' => $errors->first('email')], 409);
            } else if ($errors->has('password')) {
                return response()->json(['error' => $errors->first('password')], 422);
            } else {
                return response()->json(['errors' => $errors], 422);
            }
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        // $success['token'] = $user->createToken('auth_token')->plainTextToken;
        $success['name'] = $user->name;

        return response()->json([
            'success' => true,
            'message' => 'Sukses register',
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
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Cek email dan password lagi',
                'data' => null
            ]);
        }
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful!!'
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = DB::table('user')->orderBy('id','desc')->get();

        if($user != null) {
            return response ([
                'status' => 'Data user berhasil ditampilkan',
                'code' => 200,
                'data' => $user
            ], 200);
        } else {
            return response ([
                'status' => 'failed',
                'code' => 404,
                'message' => 'Data user tidak ditemukan'
            ], 404);
        }
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