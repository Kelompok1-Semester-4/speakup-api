<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\DetailUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $role_id = $request->input('role_id');
        $user = DetailUser::with('user')->get();
        if ($id) {
            return $user->where('user_id', $id)->first();
        }
        if ($role_id) {
            return $user->where('role_id', $role_id)->with('user')->get();
        }
        return $user;
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'gender' => 'required',
                'birth' => 'required',
                'phone' => 'required|string',
                'address' => 'required',
                'email' => 'required|email:rfc,dns|unique:users',
                'password' => 'required|string|min:6',
                'role_id' => 'required',
            ]);

            User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
            ]);

            $user = User::with('detailUser')->where('email', $request->email)->first();
            $token_result = $user->createToken('Personal Access Token')->plainTextToken;

            DetailUser::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'gender' => $request->gender,
                'birth' => $request->birth,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            // show json api register success
            return ResponseFormatter::success([
                'token' => $token_result,
                'user' => $user,
                'token_type' => 'Bearer',
            ], 'Register Success');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Register Failed');
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);

            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error('Unauthorized', 'Login Failed');
            }
            $user = User::where('email', $request->email)->first();
            $detailUser = DetailUser::where('user_id', $user->id)->first();
            if (!Hash::check($request->password, $user->password)) {
                return ResponseFormatter::error('Unauthorized', 'Login Failed');
            }

            return ResponseFormatter::success([
                'token' => $user->createToken('Personal Access Token')->plainTextToken,
                'user' => $user,
                'detailUser' => $detailUser,
                'token_type' => 'Bearer',
            ], 'Login Success');
        } catch (Exception $th) {
            return ResponseFormatter::error($th->getMessage(), 'Login Failed');
        }
    }

    public function fetch(Request $request)
    {
        $detailUser = DetailUser::where('user_id', Auth::user()->id)->first();
        return ResponseFormatter::success(
            [
                'user' => $request->user(),
                'detailUser' => $detailUser,
            ],
            'Fetch Success'
        );
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return ResponseFormatter::success('Logout Success');
    }
}
