<?php

namespace App\Http\Controllers\ChargeControllers;

use Illuminate\Http\Request;
use App\TypeCharge;
use App\Http\Resources\TypeCharge as TypeChargeResource;
use App\Http\Controllers\Controller;
use JWTAuth;

class TypeChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $typeCharges = JWTAuth::parseToken()->toUser()->typeCharges;
       // $typeCharges = TypeCharge::all();
        return TypeChargeResource::collection($typeCharges);
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
        $type_charge=new TypeCharge();
        $type_charge->libele=$request->input('libele');
        $type_charge->user_id=JWTAuth::parseToken()->toUser()->id;
        $type_charge->save();
        if($type_charge->save()) {
            return new TypeChargeResource($type_charge);
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
        $type_charge = TypeCharge::findOrFail($id);
        $type_charge->libele = $request->input('libele');
         if($type_charge->save()) {
            return new TypeChargeResource($type_charge);
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
        $type_charge = TypeCharge::findOrFail($id);
        if($type_charge->delete()) {
            return new TypeChargeResource($type_charge);
        }
    }
}
