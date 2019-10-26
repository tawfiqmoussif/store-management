<?php

namespace App\Http\Controllers\MagasinControllers;
use App\Magasin;
use App\Http\Resources\Magasin as MagasinResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;

class MagasinController extends Controller
{
    //
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $magasins = Magasin::orderBy('created_at', 'desc')->paginate(5);
        return MagasinResource::collection($magasins);
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
        $user = JWTAuth::parseToken()->toUser();
        $magasin=new Magasin();
        $magasin->user_id=$user->id;
        //$magasin->id=$request->input('id');
        $magasin->nom=$request->input('nom');
        //$employe->sommesalaires=0;
        $magasin->numero_de_patente=$request->input('numero_de_patente');
        $magasin->rc=$request->input('rc');
        $magasin->numero_compte_bancaire=$request->input('numero_compte_bancaire');
        if($magasin->save()) {
            return new MagasinResource($magasin);
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
        $magasin = Magasin::findOrFail($id);
        return new MagasinResource($magasin);
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
        $magasin=Magasin::findOrFail($id);
        $magasin->user_id=$request->input('user_id');
        $magasin->nom=$request->input('nom');
        $magasin->numero_de_patente=$request->input('numero_de_patente');
        $magasin->rc=$request->input('rc');
        $magasin->numero_compte_bancaire=$request->input('numero_compte_bancaire');
       // $magasin->save();
        if($magasin->save()) {
            return new MagasinResource($magasin);
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
        $magasin=Magasin::findOrFail($id);
        if($magasin->delete()) {
            return new MagasinResource($magasin);
        }
    }
}
