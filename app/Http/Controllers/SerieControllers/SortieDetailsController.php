<?php

namespace App\Http\Controllers\SerieControllers;

use Illuminate\Http\Request;
use App\SortieDetails;
use App\Article;
use JWTAuth;
use App\Http\Resources\SortieDetails as SortieDetailsResource;
use App\Http\Controllers\Controller;


class SortieDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sortieDetails = SortieDetails::all();

        // Return collection of sortie_details as a resource
        return SortieDetailsResource::collection($sortieDetails);
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
        $sortie_details=new SortieDetails();
        $sortie_details->article_id=$request->input('article_id');
        $sortie_details->prix_de_vente_1=$request->input('prix_de_vente_1');
        $sortie_details->prix_de_vente_2=$request->input('prix_de_vente_2');
        $sortie_details->nombre=$request->input('nombre');
        $sortie_details->date=$request->input('date');
        $sortie_details->user_id=JWTAuth::parseToken()->toUser()->id;
        $article=Article::findOrFail($request->input('article_id'));
        $article->stock=$article->stock-$request->input('nombre');
        
        if($sortie_details->save() && $article->save()) {
            return new SortieDetailsResource($sortie_details);
        }
    }
    public function dailyStatistics(Request $request) {
        $somme1 = SortieDetails::where([['user_id', JWTAuth::parseToken()->toUser()->id],['date', $request->date]])->sum('prix_de_vente_1');
        $somme2 = SortieDetails::where([['user_id', JWTAuth::parseToken()->toUser()->id],['date', $request->date]])->sum('prix_de_vente_2');
        return response()->json(['prix_de_vente_1' => $somme1, 'prix_de_vente_2' => $somme2]);
    }
    public function dailySales(Request $request) {
        $sorties = SortieDetails::where([['user_id', $request->input('user_id')],['date', $request->date]])->get();
        return SortieDetailsResource::collection($sorties);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sortie_details = SortieDetails::findOrFail($id);
        return new SortieDetailsResource($sortie_details);
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
        $sortie_details=SortieDetails::findOrFail($id);
        $sortie_details->article_id=$request->input('article_id');
        $sortie_details->prix_de_vente=$request->input('prix_de_vente');
        $sortie_details->nombre=$request->input('nombre');
        $sortie_details->date=$request->input('date');
        $sortie_details->save();
        if($sortie_details->save()) {
            return new SortieDetailsResource($sortie_details);
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
