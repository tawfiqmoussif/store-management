<?php

namespace App\Http\Controllers\SerieControllers;

use Illuminate\Http\Request;
use App\TypeSerie;
use App\Http\Resources\TypeSerie as TypeSerieResource;
use App\Http\Controllers\Controller;
use JWTAuth;

class TypeSerieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$typeSeries = TypeSerie::all();
        $typeSeries = JWTAuth::parseToken()->toUser()->typeSeries;
        return TypeSerieResource::collection($typeSeries);
    }
    public function returnLibeles()
    {
        $libeles = TypeSerie::pluck('libele');
        return $libeles;
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
        $type_serie=new TypeSerie();
        $type_serie->libele=$request->input('libele');
        $type_serie->user_id=JWTAuth::parseToken()->toUser()->id;
        if($type_serie->save()) {
            return new TypeSerieResource($type_serie);
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
        $type_serie = TypeSerie::findOrFail($id);
        $type_serie->libele = $request->input('libele');
         if($type_serie->save()) {
            return new TypeSerieResource($type_serie);
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
        $type_serie = TypeSerie::findOrFail($id);
        if($type_serie->delete()) {
            return new TypeSerieResource($type_serie);
        }
    }
}
