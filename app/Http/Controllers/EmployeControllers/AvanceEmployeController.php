<?php

namespace App\Http\Controllers\EmployeControllers;

use Illuminate\Http\Request;
use App\AvanceEmploye;
use App\Http\Resources\AvanceEmploye as AvanceEmployeResource;
use App\Http\Controllers\Controller;
use JWTAuth;

class AvanceEmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $listeAvances = AvanceEmploye::where('employe_id', $id)->orderBy('created_at', 'desc')->paginate(5);
        return AvanceEmployeResource::collection($listeAvances);
    }
    public function getByDate(Request $request) {
        $date = $request->input('date');
        $id = $request->input('id');
        $avance = AvanceEmploye::where([['employe_id','=',$id],['date','=', $date]])->paginate(3);
        return new AvanceEmployeResource($avance);
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
        $AvanceEmploye = new AvanceEmploye();
        $AvanceEmploye->employe_id = $request->input('employe_id');
        $AvanceEmploye->montant = $request->input('montant');
        $AvanceEmploye->user_id=JWTAuth::parseToken()->toUser()->id;
        $AvanceEmploye->date = $request->input('date');
        if($AvanceEmploye->save()) {
            return new AvanceEmployeResource($AvanceEmploye);
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
        //
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
