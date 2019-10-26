<?php

namespace App\Http\Controllers\SortieControllers;
use App\Sortie;
use App\Http\Resources\Sortie as SortieResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use JWTAuth;
use App\Client;
use App\Fournisseur;
use App\Entree;

class SortieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sorties = JWTAuth::parseToken()->toUser()->sorties->sortByDesc('created_at');
        return SortieResource::collection($sorties);
    }
    public function returnSommeClient($id){
        $sorties = Sortie::where([['user_id','=',JWTAuth::parseToken()->toUser()->id],
        ['client_id','=', $id]])->get();
        $somme = 0;
        foreach($sorties as $sortie){
            $somme=$somme+($sortie->montant_total - $sortie->montant);
        }
        $client = Client::findOrFail($id);
        $fournisseur = Fournisseur::where([['user_id','=',JWTAuth::parseToken()->toUser()->id],
        ['personne_id','=', $client->personne_id]])->get();
        if(sizeof($fournisseur) != 0) {
        $entrees = Entree::where([['user_id','=',JWTAuth::parseToken()->toUser()->id],
        ['fournisseur_id','=', $fournisseur[0]['id']]])->get();
        $somme2 = 0;
        foreach($entrees as $entree){
            $somme2=$somme2+($entree->montant_total - $entree->montant_paye);
        }
        }
        else {
            $somme2 =0;
        }
        
        return response()->json(['sommeClient' => $somme , 'sommeFournisseur' => $somme2]);
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
            $Sortie = new Sortie();
            $Sortie->user_id=JWTAuth::parseToken()->toUser()->id;
            $Sortie->date = $request->input('date');
            $Sortie->montant = 0;
            $Sortie->client_id = $request->input('id_client');
            $Sortie->montant_total = 0;
            if($Sortie->save()) {
                return new SortieResource($Sortie);
            }
    }
    public function ajouterCommande(Request $request)
    {
            $Sortie = new Sortie();
            $Sortie->user_id= $request->input('user_id');
            $Sortie->date = $request->input('date');
            $Sortie->montant = 0;
            $Sortie->client_id = $request->input('id_client');
            $Sortie->montant_total = 0;
            if($Sortie->save()) {
                return new SortieResource($Sortie);
            }
    }
    public function ajouterPartie(Request $request, $id)
    {
            $sortie = Sortie::findOrFail($id);
            $sortie->montant = $sortie->montant + $request->input('montant_paye');
            if($sortie->save()) {
                return new SortieResource($sortie);
            }
    }
    public function modifier(Request $request)
    {
            $sortie = Sortie::findOrFail($request->input('id'));
            $sortie->date = $request->input('date');
            $sortie->client_id = $request->input('client')['id'];
            /*foreach($request->input('lignes') as $ligne) {
                $serie = Serie::findOrFail($ligne['serie_id']);
                $serie->fournisseur_id = $request->input('fournisseur')['id'];
                $serie->save();
            }*/
            if($sortie->save()) {
                return new SortieResource($sortie);
            }
    }
    public function printPDF(Request $request)
    {
        $pdf = PDF::loadView('pdf_view_sorties', ['request'=>$request]);  
        return $pdf->stream('bonSortie.pdf');
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
            $Sortie = Sortie::findOrFail($id);
            $Sortie->montant = $request->input('montant');
            $Sortie->montant_total = $request->input('montant_total');
            if($Sortie->save()) {
                return new SortieResource($Sortie);
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
