<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
	{
    	$credentials = $request->only('email', 'password');
    	if ( ! $token = JWTAuth::attempt($credentials)) {
            return response([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], 400);
    	}

    	$user = User::find(Auth::user()->id);
    	$user->active = 1;
    	$user->save();
    	return response()->json([
    		'status' => 'success',
            'token' => $token
    	])
        ->header('Authorization', $token);
	}

	public function login_facebook(Request $r)
	{
        $user = User::where(['email'=> $r->email])->first();

		$token = JWTAuth::fromUser($user);
		if ( ! $token = JWTAuth::fromUser($user)) {
            return response([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], 400);
    	}

    	// $user = User::find(Auth::user()->id);
    	// $user->active = 1;
    	// $user->save();
    	return response()->json([
    		'status' => 'success',
            'token' => $token
    	])
        ->header('Authorization', $token);
	}

	

	public function user(Request $request)
	{
	    $user = User::find(Auth::user()->id);

	    return response([
	            'status' => 'success user',
	            'data' => $user
	        ]);
	}
	public function refresh()
	{
	    return response([
	            'status' => 'success refresh'
	        ]);
	}
	public function logout()
	{
		$user = User::find(Auth::user()->id);
    	$user->active = 0;
    	$user->save();
	    JWTAuth::invalidate();
	    return response([
	            'status' => 'success',
	            'msg' => 'Logged out Successfully.'
	        ], 200);
	}
}
