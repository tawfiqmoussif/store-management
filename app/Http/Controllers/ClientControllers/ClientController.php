<?php

namespace App\Http\Controllers\ClientControllers;

use Illuminate\Http\Request;
use App\Client;
use App\Http\Resources\Client as ClientResource;
use App\Http\Controllers\Controller;
use JWTAuth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$clients = Client::orderBy('created_at', 'desc')->paginate(5);
        $clients = JWTAuth::parseToken()->toUser()->clients->sortByDesc('created_at');
        return ClientResource::collection($clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client=new Client();
        $client->personne_id=$request->input('personne_id');
        $client->user_id=JWTAuth::parseToken()->toUser()->id;
        $client->identification_fiscale=$request->input('identification_fiscale');
        if($client->save()) {
            return new ClientResource($client);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::findOrFail($id);
        return new ClientResource($client);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client=Client::findOrFail($id);
        $client->personne_id=$request->input('personne_id');
        $client->identification_fiscale=$request->input('identification_fiscale');
        if($client->save()) {
            return new ClientResource($client);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client=Client::findOrFail($id);
        if($client->delete()) {
            return new ClientResource($client);
        }
    }
}
