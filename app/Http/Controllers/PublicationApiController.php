<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publication;
use App\User;

class PublicationApiController extends Controller
{

    public function create(Request $request)
    {
        $auth_token = $request->auth_token;
        $user = User::where('auth_token',$auth_token)->first();
        if($user != null){
            if($user->active == 1){
                $description = $request->input('description');
                $publication = new Publication;
                $publication->description = $request->description;
                $publication->user_id = $user->id;
                $publication->date_publication = $request->date_publication;
                $publication->showable = 0;

                if($publication->save()){
                return response()->json(['data' => $publication->toArray()],201);
                }
            }else{
                return response()->json(['data' =>'User Not Active'],401);
            }
        }else{
            return response()->json(['data' =>'User Not found'],404);
        }

    }

    public function getAll(Request $request){
    	$auth_token = $request->auth_token;
    	$user = User::where('auth_token',$auth_token);
    	if($user != null){
    		$publications = Publication::all();
    		return response()->json(['data' => $publications->toArray()], 200);
    	}else{
    		return response()->json(['data' =>'User Not found'],404);
    	}

    }

    public function getById(Request $request){
    	//TODO Check if the publicacions is active, user is active
    	$auth_token = $request->auth_token;
    	$publication_id = $request->id;
    	$user = User::where('auth_token',$auth_token);
    	if($user != null){
    		$publications = Publication::find($publication_id);
    		return response()->json(['data' => $publications->toArray()], 200);
    	}else{
    		return response()->json(['data' =>'User Not found'],404);
    	}
    }	
}
