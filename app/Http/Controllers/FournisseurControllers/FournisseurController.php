<?php

namespace App\Http\Controllers;
use App\Fournisseur;
use App\User;
use App\Http\Resources\Fournisseur as FournisseurResource;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;
use JWTAuth;

class FournisseurController extends Controller
{
    //
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$fournisseurs = Fournisseur::orderBy('created_at', 'desc')->paginate(5);
        $fournisseurs = JWTAuth::parseToken()->toUser()->fournisseurs->sortByDesc('created_at');
        return FournisseurResource::collection($fournisseurs);
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
    public function returnMarques()
    {
        $marques = Fournisseur::pluck('nom_marque');
        return $marques;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fournisseur=new Fournisseur();
        $fournisseur->user_id=JWTAuth::parseToken()->toUser()->id;
        $fournisseur->personne_id=$request->input('personne_id');
        $fournisseur->id_fiscale=$request->input('identification_fiscale');
        //$employe->sommesalaires=0;
        $fournisseur->nom_marque=$request->input('nom_marque');
        if($fournisseur->save()) {
            return new FournisseurResource($fournisseur);
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
        $fournisseur = Fournisseur::findOrFail($id);
        return new FournisseurResource($fournisseur);
    }
    public function returnFournisseur($id)
    {
        $user =  User::findOrFail($id);
        $fournisseur = Fournisseur::where([['personne_id', $user->personne_id]])->get();
        return $fournisseur;
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
        $fournisseur=Fournisseur::findOrFail($id);
        $fournisseur->personne_id=$request->input('personne_id');
        $fournisseur->id_fiscale=$request->input('id_fiscale');
        $fournisseur->nom_marque=$request->input('nom_marque');
        if($fournisseur->save()) {
            return new FournisseurResource($fournisseur);
        }
    }
    /*public function addSalaire(Request $request) {
        $fournisseur=Employe::findOrFail($request->input('id'));
        //$fournisseur->sommesalaires = $employe->sommesalaires + $employe->salaire;
        if($employe->save()) {
            return new EmployeResource($employe);
        }
    }*/
    /*public function removeSalaire(Request $request) {
        $employe=Employe::findOrFail($request->input('id'));
        $employe->sommesalaires = $employe->sommesalaires - $employe->salaire;
        if($employe->save()) {
            return new EmployeResource($employe);
        }
    }*/
    /*public function updateSalaire(Request $request) {
        $employe=Employe::findOrFail($request->input('id'));
        $employe->sommesalaires = $employe->sommesalaires - $request->input('sommesalaires');
        if($employe->save()) {
            return new EmployeResource($employe);
        }
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fournisseur=Fournisseur::findOrFail($id);
        if($fournisseur->delete()) {
            return new FournisseurResource($fournisseur);
        }
    }
}
