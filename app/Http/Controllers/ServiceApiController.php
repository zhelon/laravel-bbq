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
        $user_logged = User::where('auth_token', $auth_token)->first();
        //Todo: check if active
        if($user_logged != null){
            $publication_id = $request->input('publication_id');
            if($publication_id != null){
                $publication = Publication::find($publication_id);
                //TODO return publication with user_logged, check is active
                //TODO check if the user_logged is the same than bbq 
                if($publication != null){
                    $service = new Service;
                    
                    $service->client_id = $user_logged->id;
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
                //The regular client can create service without publciation bbq
                $service =  new Service;
                $service->client_id = $user_logged->id;
                $service->total_price = $request->input('total_price');
                $service->date_service = $request->input('date_service');
                $service->status = 'created';
                $service->client_confirmed = 0;
                $service->bbq_confirmed = 0;
                $service->address = $request->input('address');
                if($service->save()){
                    return response()->json(['data' => $service->toArray()],201);
                }else{
                    return response()->json(['data' =>'Service Not Created'],404);
                }

            }



        }else{
            return response()->json(['data' =>'User Not found'],404);
        }
    }

    public function confirmService(Request $request){
        $auth_token = $request->input('auth_token');
        $user_logged = User::with('types')->where('auth_token', $auth_token)->first();
        //Todo: check if active
        if($user_logged != null){
            $type_user_logged = $request->input('type_user_logged');
            $bbq_id = $request->input('bbq_id');
            $bbq_user_logged = User::with('types')->where('id', $bbq_id)->first();

            if($bbq_user_logged->type_user_logged_id == 1 && $type_user_logged == 'bbq_user_logged'){
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
                return response()->json(['data' =>'Forbidden', 'details' => 'User is not bbq user_logged'],403);
            }
            
        }else{
            return response()->json(['data' =>'User Not found'],404);
        }
    }

    public function getById(Request $request, $auth_token, $service_id){
        $user_logged = User::where('auth_token', $auth_token)->first();
        if($user_logged != null){
            $service = Service::with('user_loggeds')->where('id', $service_id);
            return response()->json(['data' => $service->toArray()],200); 
        }else{
            return response()->json(['data' =>'User Not found'],404);   
        }
    }

    public function getAll(Request $request, $auth_token, $type_name){
        $user_logged = User::where('auth_token', $auth_token)->first();
        //TODO check if active
        if($user_logged != null){
            $services = null;
            if($type_name == 'client_user_logged'){
                $services = Service::where('client_id', $user_logged->id);
            }
            if($type_name == 'bbq_user_logged'){
                $services = Service::where('bbq_id', $user_logged->id);
            }
            return response()->json(['data' => $services->toArray()],200); 
        }else{
            return response()->json(['data' =>'User Not found'],404);
        }
    }



    public function cancel(Request $request){
        $auth_token = $request->input('auth_token');
        $user_logged = User::with('types')->where('auth_token', $auth_token);
        //TODO: if active
        if($user_logged != null){
            $service_id = $request->input('service_id');
            $service = Service::find('service_id');
            if($service != null){
                if($user_logged->type_name == 'client_user_logged'){
                    $service->client_confirmed = 0;
                }
                if($user_logged->type_name == 'client_user_logged'){
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
