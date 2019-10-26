<?php

namespace App\Http\Controllers\EntreeControllers;
use App\Entree;
use App\Http\Resources\Entree as EntreeResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use JWTAuth;
use App\Client;
use App\Fournisseur;
use App\Sortie;
use App\Serie;

class EntreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$entrees = Entree::orderBy('created_at', 'desc')->paginate(5);
        $entrees = JWTAuth::parseToken()->toUser()->entrees->sortByDesc('created_at');
        return EntreeResource::collection($entrees);
    }
    public function returnSommeFournisseur($id){
        $entrees = Entree::where([['user_id','=',JWTAuth::parseToken()->toUser()->id],
        ['fournisseur_id','=', $id]])->get();
        $somme = 0;
        foreach($entrees as $entree){
            $somme=$somme+($entree->montant_total - $entree->montant_paye);
        }
        
        $fournisseur = Fournisseur::findOrFail($id);
        $client = Client::where([['user_id','=',JWTAuth::parseToken()->toUser()->id],
        ['personne_id','=', $fournisseur->personne_id]])->get();
        if(sizeof($client) != 0) {
        $sorties = Sortie::where([['user_id','=',JWTAuth::parseToken()->toUser()->id],
        ['client_id','=', $client[0]['id']]])->get();
        $somme2 = 0;
        foreach($sorties as $sortie){
            $somme2=$somme2+($sortie->montant_total - $sortie->montant);
        }
        }
        else {
            $somme2 =0;
        }
        return response()->json(['sommeClient' => $somme , 'sommeFournisseur' => $somme2]);
    }
    public function printPDF(Request $request)
    {
        $pdf = PDF::loadView('pdf_view', ['request'=>$request]);  
        return $pdf->stream('bonEntree.pdf');
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
            $entree = new Entree();
            $entree->user_id=JWTAuth::parseToken()->toUser()->id;
            $entree->date = $request->input('date');
            $entree->fournisseur_id = $request->input('id_fournisseur');
            $entree->montant_total = 0;
            $entree->montant_paye = 0;
            if($entree->save()) {
                return new EntreeResource($entree);
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
            $entree = Entree::findOrFail($id);
            $entree->date = $request->input('date');
            $entree->montant_total = $request->input('montant_total');
            $entree->montant_paye = $request->input('montant_paye');
            if($entree->save()) {
                return new EntreeResource($entree);
            }
    }
    public function modifier(Request $request)
    {
            $entree = Entree::findOrFail($request->input('id'));
            $entree->date = $request->input('date');
            $entree->fournisseur_id = $request->input('fournisseur')['id'];
            foreach($request->input('lignes') as $ligne) {
                $serie = Serie::findOrFail($ligne['serie_id']);
                $serie->fournisseur_id = $request->input('fournisseur')['id'];
                $serie->save();
            }
            if($entree->save()) {
                return new EntreeResource($entree);
            }
    }
    public function ajouterPartie(Request $request, $id)
    {
            $entree = Entree::findOrFail($id);
            $entree->montant_paye = $entree->montant_paye + $request->input('montant_paye');
            if($entree->save()) {
                return new EntreeResource($entree);
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
