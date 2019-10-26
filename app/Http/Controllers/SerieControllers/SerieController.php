<?php

namespace App\Http\Controllers\SerieControllers;

use Illuminate\Http\Request;
use App\Serie;
use App\Article;
use App\Http\Resources\Serie as SerieResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use JWTAuth;
use App\Magasin;
class SerieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $series = JWTAuth::parseToken()->toUser()->series;
        return SerieResource::collection($series);
    }
    public function existe(Request $request) {
    $serie = Serie::where([['user_id','=',JWTAuth::parseToken()->toUser()->id],['ref','=',$request->input('ref')],['couleur','=', $request->input('couleur')],['fournisseur_id','=', $request->input('fournisseur_id')]])->first();
        
      if($serie){
          return new SerieResource($serie);
        } 
        else return 0; 
    }
    public function returnRefs()
    {
        $refs = Serie::pluck('ref');
        return $refs;
    }
    /////////////////////
    public function femmesU($id)
    {
        $series = Serie::where([['genre', 'نساء'],['user_id',$id]])->get();
        return SerieResource::collection($series);
    }
    public function hommesU($id)
    {
        $series = Serie::where([['genre', 'رجال'],['user_id',$id]])->get();
        return SerieResource::collection($series);
    }
    public function enfantsU($id)
    {
        $series = Serie::where([['genre', 'أطفال'],['user_id',$id]])->get();
        return SerieResource::collection($series);
    }
    ////////////////
    public function femmes()
    {
        //$magasin = Magasin::where('user_id', JWTAuth::parseToken()->toUser()->id)->get();
        //$series = Magasin::find($magasin[0]['id'])->series->where('genre', 'نساء')->sortByDesc('created_at');
        //$series = Serie::where('genre', 'نساء')->get();
        $series = JWTAuth::parseToken()->toUser()->series->where('genre', 'نساء')->sortByDesc('created_at');
        return SerieResource::collection($series);
    }
    public function hommes()
    {
        //$magasin = Magasin::where('user_id', JWTAuth::parseToken()->toUser()->id)->get();
        //$series = Magasin::find($magasin[0]['id'])->series->where('genre', 'رجال')->sortByDesc('created_at');
        //$series = Serie::where('genre', 'رجال')->get();
        $series = JWTAuth::parseToken()->toUser()->series->where('genre', 'رجال')->sortByDesc('created_at');
        return SerieResource::collection($series);
    }
    public function enfants()
    {
        //$magasin = Magasin::where('user_id', JWTAuth::parseToken()->toUser()->id)->get();
        //$series = Magasin::find($magasin[0]['id'])->series->where('genre', 'أطفال')->sortByDesc('created_at');
       // $series = Serie::where('genre', 'اطفال')->get();
       $series = JWTAuth::parseToken()->toUser()->series->where('genre', 'أطفال')->sortByDesc('created_at');
        return SerieResource::collection($series);
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
        $serie=new Serie();
        if($request->photo)
        {
            $theImageName1 = time() . '.' .$request->photo->getClientOriginalExtension();
            $request->photo->move(public_path('photoSerie'), $theImageName1);
            $serie->photo = $theImageName1;
        }
        $magasin = Magasin::where('user_id', JWTAuth::parseToken()->toUser()->id)->get();
        $serie->magasin_id=$magasin[0]['id'];
        $serie->user_id=JWTAuth::parseToken()->toUser()->id;
        $serie->fournisseur_id=$request->input('fournisseur_id');
        $serie->ref=$request->input('ref');
        $serie->couleur=$request->input('couleur');
        $serie->genre=$request->input('genre');
        $serie->type_serie_id=$request->input('type_serie_id');
        if($serie->save()) {
            return new SerieResource($serie);
        }
    }
    public function serieCommande(Request $request)
    {
        $serie=new Serie();
        $serie->photo = $request->input('photo');
        $magasin = Magasin::where('user_id', JWTAuth::parseToken()->toUser()->id)->get();
        $serie->magasin_id=$magasin[0]['id'];
        $serie->user_id=JWTAuth::parseToken()->toUser()->id;
        $serie->fournisseur_id=$request->input('fournisseur_id');
        $serie->ref=$request->input('ref');
        $serie->couleur=$request->input('couleur');
        $serie->genre=$request->input('genre');
        $serie->type_serie_id=$request->input('type_serie_id');
        $serie->save();
        $i = 0;
        for($i=0;$i<sizeof($request->input('articles'));$i++ )
        {
            $art = new Article();
            $art->serie_id = $serie->id;
            $art->taille =  $request->input('articles')[$i]['taille'];
            $art->stock =  $request->input('articlesCommande')[$i]['qte'];
            $art->save();
        }
        return new SerieResource($serie);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $serie = Serie::findOrFail($id);
        return new SerieResource($serie);
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
        $serie=Serie::findOrFail($id);
        $serie->magasin_id=$request->input('magasin_id');
        $serie->ref=$request->input('ref');
        $serie->couleur=$request->input('couleur');
        $serie->genre=$request->input('genre');
        $serie->save();
        if($serie->save()) {
            return new SerieResource($serie);
        }
    }

    public function modifier(Request $request)
    {
        $serie=Serie::findOrFail($request->input('id'));
        if($request->photo && $request->input('changePH')==1) {
            $theImageName1 = time() . '.' .$request->photo->getClientOriginalExtension();
            $request->photo->move(public_path('photoSerie'), $theImageName1);
            $serie->photo = $theImageName1;
        }
        $serie->ref=$request->input('ref');
        $serie->couleur=$request->input('couleur');
        $serie->genre=$request->input('genre');
        $serie->fournisseur_id=$request->input('fournisseur_id');
        $serie->type_serie_id=$request->input('type_serie_id');
        if($serie->save()) {
            return new SerieResource($serie);
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
        $serie=Serie::findOrFail($id);
        if($serie->delete()) {
            return new SerieResource($serie);
        }
    }
}
