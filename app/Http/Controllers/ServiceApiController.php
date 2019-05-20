<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Service;
use App\Publication;

class ServiceApiController extends Controller
{
    public function create(Request $request){
    	$auth_token = $request->input('auth_token');
    	$client_user = User::where('auth_token', $auth_token);
    	//Todo: check if active

    	if($client_user != null){
    		$publication_id = $request->input('publication_id');
    		$publication = Publication::find('publication_id');
    		//TODO return publication with user and check is active
    		if($publication != null){
    			$client_id = $request->input('description');

				$service = new Service;
				$service->client_id = $client_user->id;
				$service->bbq_id = $request->input('bbq_id');
				$service->total_price = $request->input('total_price');
				$service->address = $request->input('address');
				$service->date_service = $request->input('date_service');
				$service->publication_id = $publication_id;
				$service->status = 'created';
				$service->client_confirmed = $request->input('client_confirmed');
				$service->bbq_confirmed = $request->input('bbq_confirmed');
				if($service->save()){
					return response()->json(['data' => $service->toArray()],201);
				}else{
					//TODO: Notification user
				}
    		}else{
    			//todo: error
    		}

    	}
    }

    public function getAll(Request $request, $auth_token){
    	$user = User::with('services')->where('auth_token', $auth_token);
    	//TODO check if active
    	if($user != null){
    		return response()->json(['data' => $user->toArray()],200);
    	}else{
    		return response()->json(['data' =>'User Not found'],404);
    	}
    }

    public function cancel(Request $request){
    	$auth_token = $request->input('auth_token');
    	$user = User::with('types')->where('auth_token', $auth_token);
    	//TODO: if active
    	if($user != null){
			$service_id = $request->input('service_id');
    		$service = Service::find('service_id');
    		if($service != null){
    			if($user->type_name == 'client_user'){
					$service->client_confirmed = 0;
    			}
    			if($user->type_name == 'client_user'){
    				$service->bbq_confirmed = 0;
    			}
    			$service->status = 'canceled';
    			if($service->save()){
    				return response()->json(['data' =>'Service canceled'],202); 
    			}

    		}else{
    			return response()->json(['data' =>'Service Not found'],404);
    		}


    	}else{
    		return response()->json(['data' =>'User Not found'],404);
    	}
    	
    	
    }
}
