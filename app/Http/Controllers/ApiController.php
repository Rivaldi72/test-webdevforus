<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Member;
use App\Models\User;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $login = Auth::Attempt($request->all());
        if ($login) {
            $user = Auth::user();
            $user->api_token = Str::random(100);
            $user->save();
            $user->makeVisible('api_token');

            return response()->json([
                'response_code' => 200,
                'message' => 'Login Berhasil',
                'conntent' => $user
            ]);
        }else{
            return response()->json([
                'response_code' => 404,
                'message' => 'Email atau Password Tidak Ditemukan!'
            ]);
        }
    }

    public function getMemberById(Request $request)
    {
        $user = User::where('api_token', $request->api_token)->first();
        if ($user) {
            $member = Member::find($request->id);
            if($member) {
                return response()->json([
                    'response_code' => 200,
                    'message' => 'Data Berhasil Diterima',
                    'conntent' => $member
                ]);
            } else {
                return response()->json([
                    'response_code' => 404,
                    'message' => 'Data Tidak Ditemukan!'
                ]);
            }
        }else{
            return response()->json([
                'response_code' => 404,
                'message' => 'Data Tidak Ditemukan!'
            ]);
        }
    }
}