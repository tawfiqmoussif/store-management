<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ArticleCommande as ArticleCommandeResource;
use App\ArticleCommande;

class ArticleCommandeController extends Controller
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
        $ArticleCommande = new ArticleCommande();
        $ArticleCommande->taille = $request->input('taille');
        $ArticleCommande->qte = $request->input('qte');
        $ArticleCommande->commande_id = $request->input('commande_id');
        if($ArticleCommande->save()) {
            return new ArticleCommandeResource($ArticleCommande);
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
        $ArticleCommande=ArticleCommande::findOrFail($id);
        $ArticleCommande->qte = $request->input('qte');
        if($ArticleCommande->save()) {
            return new ArticleCommandeResource($ArticleCommande);
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
