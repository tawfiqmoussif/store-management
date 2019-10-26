<?php


namespace App\Http\Controllers\EntreeControllers;

use Illuminate\Http\Request;
use App\LigneEntree;
use App\Entree;
use App\Serie;
use App\Http\Resources\LigneEntree as LigneEntreeResource;
use App\Http\Controllers\Controller;
use JWTAuth;

class LigneEntreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            $ligneEntree = new LigneEntree();
            $ligneEntree->serie_id = $request->input('idSerie');
            $ligneEntree->user_id=JWTAuth::parseToken()->toUser()->id;
            $ligneEntree->entree_id = $request->input('idEntree');
            $ligneEntree->qte = $request->input('qte');
            $ligneEntree->prix_unitaire = $request->input('prix_unitaire');
            $ligneEntree->prix_de_vente = $request->input('prix_vente');
            if($ligneEntree->save()) {
                return new LigneEntreeResource($ligneEntree);
            }
    }
    public function returnPrix($id)
    {
        $lignes = LigneEntree::where('serie_id', $id)->get();
        if(sizeof($lignes)!=0){
            $somme = 0;
            $somme2 = 0;
            foreach($lignes as $ligne) {
                $somme=$somme+$ligne->prix_unitaire;
                $somme2= $somme2+$ligne->prix_de_vente;
            }
            $somme = $somme/sizeof($lignes);
        }
        else{
            $somme =0;
            $somme2 =0;
        }
        return response()->json(['prix_de_vente' => $somme2 , 'prix_achat' => $somme]);
    
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
        $ligne = LigneEntree::findOrFail($id);
        $prix1 = $ligne->prix_unitaire * $ligne->qte;
        $ligne->prix_unitaire = $request->input('prix_unitaire');
        $ligne->qte = $request->input('qte');
        $prix2 = $ligne->prix_unitaire * $ligne->qte;
        $ligne->prix_de_vente = $request->input('prix_de_vente');
        $entree = Entree::findOrFail($request->input('entree')['id']);
        if( $prix2 > $prix1 ) {
            $diff = $prix2 - $prix1;
            $entree->montant_total = $entree->montant_total + $diff;
            $entree->save();
        }
        if( $prix1 > $prix2 ) {
            $diff = $prix1 - $prix2;
            $entree->montant_total = $entree->montant_total - $diff;
            $entree->save();
        }
        $serie = Serie::where([['couleur','=',$request->input('serie')['couleur']],
        ['ref','=', $request->input('serie')['ref']], ['fournisseur_id','=', $request->input('serie')['fournisseur_id']]])->get();
       if(sizeof($serie)!=0) 
       {
           $ligne->serie_id = $serie[0]['id'];
    }
        if($ligne->save()) {
            return new LigneEntreeResource($ligne);
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
