<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Commande as CommandeResource;
use App\Commande;
use JWTAuth;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commandes = Commande::where('client', JWTAuth::parseToken()->toUser()->id)->get();
        return CommandeResource::collection($commandes);
    }
    public function commandes_en_attente()
    {
        $commandes = Commande::where([['fournisseur', JWTAuth::parseToken()->toUser()->id],['etat', 'en attente']])->get();
        return CommandeResource::collection($commandes);
    }
    public function commandes_acceptees()
    {
        $commandes = Commande::where([['client', JWTAuth::parseToken()->toUser()->id],['etat', 'acceptee']])->get();
        return CommandeResource::collection($commandes);
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
        $commande=new Commande();
        $commande->fournisseur=$request->input('fournisseur');
        $commande->date=$request->input('date');
        $commande->client=JWTAuth::parseToken()->toUser()->id;
        $commande->etat='en attente';
        $commande->serie_id=$request->input('serie_id');
        $commande->prix=0;
        if($commande->save()) {
            return new CommandeResource($commande);
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
        //
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
        //
    }
    public function accepte(Request $request, $id)
    {
        $commande=Commande::findOrFail($id);
        $commande->etat = 'acceptee';
        $commande->prix = $request->input('prix');
        if($commande->save()) {
            return new CommandeResource($commande);
        }
    }
    public function refuse($id)
    {
        $commande=Commande::findOrFail($id);
        $commande->etat = 'refusee';
        if($commande->save()) {
            return new CommandeResource($commande);
        }
    }
    public function non_recu($id)
    {
        $commande=Commande::findOrFail($id);
        $commande->etat = 'non recu';
        if($commande->save()) {
            return new CommandeResource($commande);
        }
    }
    public function recu(Request $request, $id)
    {
        $commande=Commande::findOrFail($id);
        $commande->prix = $request->input('prix');
        $commande->etat = 'recu';
        if($commande->save()) {
            return new CommandeResource($commande);
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
        //
    }
}
