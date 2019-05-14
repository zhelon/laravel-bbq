<?php

namespace App\Http\Controllers;

use App\Publication;
use Illuminate\Http\Request;
use Auth;
use Storage;

class PublicationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()){
            $data = Publication::where('user_id', Auth::getUser()->id);
            return view('publication.index'); 
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('publication.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()){
            $id = Auth::getUser()->id;
            $uploadedFile = $request->file('image');
            $filename = time().$uploadedFile->getClientOriginalName();
            Storage::disk('local')->putFileAs(
                'files/'.$id,
                $uploadedFile,
                $filename
              );

            $description = $request->input('description');
            $publication = new Publication;
            $publication->description = $description;
            $publication->file_name = $filename;
            $publication->user_id = $id;

            if($publication->save()){
                return View('publication.index');
            }else{
                //TODO
            }


        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function show(Publication $publication)
    {
        return view('publication.index');   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function edit(Publication $publication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publication $publication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publication $publication)
    {
        //
    }
}
