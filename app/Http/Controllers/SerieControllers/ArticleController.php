<?php

namespace App\Http\Controllers\SerieControllers;

use Illuminate\Http\Request;
use App\Article;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $articles = Article::where('serie_id', $id)->get();
        return ArticleResource::collection($articles);
    }

    public function countTailles($id)
    {
        $articles = Article::where('serie_id', $id)->count();
        return $articles;
    }
    public function returnTailles($id)
    {
        $articles = Article::where('serie_id', $id)->get();
        return ArticleResource::collection($articles);
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
        $article=new Article();
        $article->serie_id=$request->input('serie_id');
        $article->taille=$request->input('taille');
        $article->stock=$request->input('stock');
        if($article->save()) {
            return new ArticleResource($article);
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
        $article=Article::findOrFail($id);
        return new ArticleResource($article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }
    public function addStock(Request $request) {
        $article=Article::findOrFail($request->id);
        $article->stock=$article->stock+$request->stock;
        $article->save();
        return new ArticleResource($article);
    }
    public function removeStock(Request $request) {
        $article=Article::findOrFail($request->id);
        $article->stock=$article->stock-$request->stock;
        $article->save();
        return new ArticleResource($article);
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
        $article=Article::findOrFail($id);
        $article->stock=$request->input('stock');
        if($article->save()) {
            return new ArticleResource($article);
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
