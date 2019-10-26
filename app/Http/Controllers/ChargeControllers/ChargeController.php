<?php

namespace App\Http\Controllers\ChargeControllers;

use Illuminate\Http\Request;
use App\Charge;
use App\TypeCharge;
use App\Magasin;
use App\Http\Resources\Charge as ChargeResource;
use App\Http\Controllers\Controller;
use JWTAuth;

class ChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function electricite()
    {
        $type = TypeCharge::where([['user_id', JWTAuth::parseToken()->toUser()->id],['libele', 'الكهرباء']])->get();
        if(sizeof($type)!=0)
       { $electricite = Charge::where('type_charge_id', $type[0]['id'])->latest()->take(12)->orderBy('date', 'DESC')->get();
        return ChargeResource::collection($electricite);}
    }
    public function eau()
    {
        $type = TypeCharge::where([['user_id', JWTAuth::parseToken()->toUser()->id],['libele', 'الماء']])->get();
        if(sizeof($type)!=0)
      {  $eau = Charge::where('type_charge_id', $type[0]['id'])->latest()->take(12)->orderBy('date', 'DESC')->get();
        return ChargeResource::collection($eau);}
    }
    public function index()
    {
       // $charges = Charge::all();
       //$magasin = Magasin::where('user_id', JWTAuth::parseToken()->toUser()->id)->get();
       //$charges = Magasin::find($magasin[0]['id'])->charges->sortByDesc('created_at');
       $charges = JWTAuth::parseToken()->toUser()->charges->sortByDesc('created_at');
       return ChargeResource::collection($charges);
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
        $magasin = Magasin::where('user_id', JWTAuth::parseToken()->toUser()->id)->get();
        $charge=new Charge();
        $charge->user_id=JWTAuth::parseToken()->toUser()->id;
        $charge->magasin_id=$magasin[0]['id'];
        $charge->type_charge_id=$request->input('type_charge_id');
        $charge->montant_total=$request->input('montant_total');
        $charge->date=$request->input('date');
        $charge->save();
        if($charge->save()) {
            return new ChargeResource($charge);
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
        $charge = Charge::findOrFail($id);
        return new ChargeResource($charge);
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
        $charge=Charge::findOrFail($id);
        $charge->type_charge_id=$request->input('type_charge_id');
        $charge->montant_total=$request->input('montant_total');
        $charge->date=$request->input('date');
        $charge->save();
        if($charge->save()) {
            return new ChargeResource($charge);
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
        $charge=Charge::findOrFail($id);
        if($charge->delete()) {
            return new ChargeResource($charge);
        }
    }
}
