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
    	$user = User::where('auth_token', $auth_token)->first();
    	//Todo: check if active
    	if($user != null){
    		$publication_id = $request->input('publication_id');
    		$publication = Publication::find($publication_id);
    		//TODO return publication with user, check is active
    		//TODO check if the user is the same than bbq 
    		if($publication != null){
				$service = new Service;
				
				$service->client_id = $user->id;
				$service->bbq_id = $request->input('bbq_id');
				$service->total_price = $request->input('total_price');
				$service->address = $request->input('address');
				$service->date_service = $request->input('date_service');
				$service->publication_id = $publication_id;
				$service->status = 'created';
				$service->client_confirmed = 1;
				$service->bbq_confirmed = 0;
				if($service->save()){
					return response()->json(['data' => $service->toArray()],201);
				}else{
					return response()->json(['data' =>'Service Not Created'],404);
				}
    		}else{
    			return response()->json(['data' =>'Publication Not found'],404);
    		}

    	}else{
    		return response()->json(['data' =>'User Not found'],404);
    	}
    }

    public function confirmService(Request $request){
    	$auth_token = $request->input('auth_token');
    	$user = User::with('types')->where('auth_token', $auth_token)->first();
    	//Todo: check if active
    	if($user != null){
            $type_user = $request->input('type_user');
            $bbq_id = $request->input('bbq_id');
            $bbq_user = User::with('types')->where('id', $bbq_id)->first();

    		if($bbq_user->type_user_id == 1 && $type_user == 'bbq_user'){
                $publication_id = $request->input('publication_id');
                $publication = Publication::find($publication_id);
                if($publication != null){
                    $service_id = $request->input('service_id');
                    $service = Service::find($service_id);
                    if($service != null){
                        if($service->bbq_confirmed == 1 && $service->client_confirmed == 1 && $service->status == 'started'){
                            return response()->json(['data' =>'Service already started'], 403);
                        }else{
                            $service->bbq_confirmed = 1;
                            $service->status = 'started';
                            if($service->save()){
                                return response()->json(['data' => $service->toArray()], 200); 
                            }                           
                        }
 
                    }else{
                        return response()->json(['data' =>'Service Not found'],404);
                    }
                }else{
                    return response()->json(['data' =>'Publication Not found'],404);
                }

    		}else{
                return response()->json(['data' =>'Forbidden', 'details' => 'User is not bbq user'],403);
            }
    		
    	}else{
    		return response()->json(['data' =>'User Not found'],404);
    	}
    }

  	public function getById(Request $request, $auth_token, $service_id){
    	$user = User::where('auth_token', $auth_token)->first();
    	if($user != null){
    		$service = Service::with('users')->where('id', $service_id);
    		return response()->json(['data' => $service->toArray()],200); 
    	}else{
    		return response()->json(['data' =>'User Not found'],404);	
    	}
    }

    public function getAll(Request $request, $auth_token, $type_name){
    	$user = User::where('auth_token', $auth_token)->first();
    	//TODO check if active
    	if($user != null){
    		$services = null;
    		if($type_name == 'client_user'){
    			$services = Service::where('client_id', $user->id);
    		}
    		if($type_name == 'bbq_user'){
				$services = Service::where('bbq_id', $user->id);
    		}
    		return response()->json(['data' => $services->toArray()],200); 
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
