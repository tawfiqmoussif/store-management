<?php

namespace App\Http\Controllers\PersonneControllers;

use App\Personne;
use App\Http\Resources\Personne as PersonneResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PersonneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personnes = Personne::orderBy('created_at', 'desc')->paginate(5);

        // Return collection of articles as a resource
        return PersonneResource::collection($personnes);
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
        //\Log::info($request->all());
        $personne = new Personne();
        if($request->photoF)
        {
            $theImageName1 = time() . '.' .$request->photoF->getClientOriginalExtension();
            $request->photoF->move(public_path('photos'), $theImageName1);
            $personne->photo = $theImageName1;
        }
        if($request->photocopie_carte_nationalF) {
            $theImageName2 = time() . '.' .$request->photocopie_carte_nationalF->getClientOriginalExtension();
            $request->photocopie_carte_nationalF->move(public_path('photoCopieCarteNational'), $theImageName2);
            $personne->photocopie_carte_national = $theImageName2;
        }
      $personne->nom = $request->input('nom');
      $personne->prenom = $request->input('prenom');
      $personne->tel = $request->input('tel');
      $personne->adresse = $request->input('adresse');
      if($personne->save()) {
          return new PersonneResource($personne);
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
        $personne = Personne::findOrFail($id);
        return new PersonneResource($personne);
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
    
    public function update(Request $request)
    {
        $personne = Personne::findOrFail($request->input('id'));
       /* if($request->photoF)
        {
            $theImageName1 = time() . '.' .$request->photoF->getClientOriginalExtension();
            $request->photoF->move(public_path('photos'), $theImageName1);
            $personne->photo = $theImageName1;
        }
        if($request->photocopie_carte_nationalF) {
            $theImageName2 = time() . '.' .$request->photocopie_carte_nationalF->getClientOriginalExtension();
            $request->photocopie_carte_nationalF->move(public_path('photoCopieCarteNational'), $theImageName2);
            $personne->photocopie_carte_national = $theImageName2;
        }*/
        $personne->nom = $request->input('nom');
        $personne->prenom = $request->input('prenom');
        $personne->tel = $request->input('tel');
        $personne->adresse = $request->input('adresse');
         if($personne->save()) {
            return new PersonneResource($personne);
        }
    }
    public function personneU(Request $request)
    {
        $personne = Personne::findOrFail($request->input('id'));
        if($request->photoF && $request->input('changePh')==1)
        {
            $theImageName1 = time() . '.' .$request->photoF->getClientOriginalExtension();
            $request->photoF->move(public_path('photos'), $theImageName1);
            $personne->photo = $theImageName1;
        }
        if($request->photocopie_carte_nationalF && $request->input('changePhC')==1) {
            $theImageName2 = time() . '.' .$request->photocopie_carte_nationalF->getClientOriginalExtension();
            $request->photocopie_carte_nationalF->move(public_path('photoCopieCarteNational'), $theImageName2);
            $personne->photocopie_carte_national = $theImageName2;
        }
        $personne->nom = $request->input('nom');
        $personne->prenom = $request->input('prenom');
        $personne->tel = $request->input('tel');
        $personne->adresse = $request->input('adresse');
         if($personne->save()) {
            return new PersonneResource($personne);
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
        $personne = Personne::findOrFail($id);
        if($personne->delete()) {
            return new PersonneResource($personne);
        }
    }
}
