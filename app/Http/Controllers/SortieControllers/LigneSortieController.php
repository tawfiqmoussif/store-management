<?php


namespace App\Http\Controllers\SortieControllers;

use Illuminate\Http\Request;
use App\LigneSortie;
use App\Sortie;
use App\Serie;
use App\Http\Resources\LigneSortie as LigneSortieResource;
use App\Http\Controllers\Controller;
use JWTAuth;

class LigneSortieController extends Controller
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

            $ligneSortie = new LigneSortie();
            $ligneSortie->serie_id = $request->input('idSerie');
            $ligneSortie->user_id=JWTAuth::parseToken()->toUser()->id;
            $ligneSortie->sortie_id = $request->input('idSortie');
            $ligneSortie->qte = $request->input('qte');
            $ligneSortie->prix_unitaire = $request->input('prix_unitaire');
            if($ligneSortie->save()) {
                return new LigneSortieResource($ligneSortie);
            }
    }
    public function ajouterCommande(Request $request)
    {

            $ligneSortie = new LigneSortie();
            $ligneSortie->serie_id = $request->input('idSerie');
            $ligneSortie->user_id=$request->input('user_id');
            $ligneSortie->sortie_id = $request->input('idSortie');
            $ligneSortie->qte = $request->input('qte');
            $ligneSortie->prix_unitaire = $request->input('prix_unitaire');
            if($ligneSortie->save()) {
                return new LigneSortieResource($ligneSortie);
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
        $ligne = LigneSortie::findOrFail($id);
        $prix1 = $ligne->prix_unitaire * $ligne->qte;
        $ligne->prix_unitaire = $request->input('prix_unitaire');
        $ligne->qte = $request->input('qte');
        $prix2 = $ligne->prix_unitaire * $ligne->qte;
        $sortie = Sortie::findOrFail($request->input('sortie')['id']);
        if( $prix2 > $prix1 ) {
            $diff = $prix2 - $prix1;
            $sortie->montant_total = $sortie->montant_total + $diff;
            $sortie->save();
        }
        if( $prix1 > $prix2 ) {
            $diff = $prix1 - $prix2;
            $sortie->montant_total = $sortie->montant_total - $diff;
            $sortie->save();
        }
        $serie = Serie::where([['couleur','=',$request->input('serie')['couleur']],
        ['ref','=', $request->input('serie')['ref']], ['fournisseur_id','=', $request->input('serie')['fournisseur_id']]])->get();
       if(sizeof($serie)!=0) 
       {
           $ligne->serie_id = $serie[0]['id'];
    }
        if($ligne->save()) {
            return new LigneSortieResource($ligne);
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
