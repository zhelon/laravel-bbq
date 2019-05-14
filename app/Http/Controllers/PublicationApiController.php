<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publication;
use App\User;

class PublicationApiController extends Controller
{
    //

    public function getAll(Request $request){
    	$auth_token = $request->auth_token;
    	$user = User::where('auth_token',$auth_token);
    	if($user != null){
    		$publications = Publication::all();
    		return reponse()->json(['data' => $publications.toArray()], 200);
    	}else{
    		//TODO
    	}

    }

    public function getById(Request $request){
    	//TODO: Check if the publicacions is active, user is active
    	$auth_token = $request->auth_token;
    	$publication_id = $request->id:
    	$user = User::where('auth_token',$auth_token);
    	if($user != null){
    		$publications = Publication::find($publication_id);
    		return reponse()->json(['data' => $publications.toArray()], 200);
    	}else{
    		//TODO
    	}
    }	
}
