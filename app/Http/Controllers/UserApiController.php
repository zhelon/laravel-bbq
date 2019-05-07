<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use Hash;

class UserApiController extends Controller{


	public function doLogin(Request $request, $email, $password ){
		
	$user = User::with('role')->where('email', $email)->first();	
		if(Hash::check($password, $user->password)){
			$token = Str::random(60);

	        $user->forceFill([
	            'auth_token' => hash('sha256', $token),
	        ])->save();

			return response()->json(['data' => $user->toArray()],200);
		}
	return response()->json(['data' =>'Not found'],404);
	

	}

}




