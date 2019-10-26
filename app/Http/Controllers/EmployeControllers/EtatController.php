<?php

namespace App\Http\Controllers\EmployeControllers;

use Illuminate\Http\Request;
use App\Etat;
use App\Http\Resources\Etat as EtatResource;
use App\Http\Controllers\Controller;

class etatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $listeEtats = Etat::where('employe_id', $id)->get();
        return EtatResource::collection($listeEtats);
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
    public function store(Request $request) {
        $etat = Etat::where([['employe_id','=',$request->input('employe_id')],['date','=', $request->input('date')]])->first();
        if($etat) {
            $etat->present = $request->input('present');
            if($etat->save()) {
                return new EtatResource($etat);
            }
        }
        else
        {
            $etatN = new Etat();
            $etatN->employe_id = $request->input('employe_id');
            $etatN->present = $request->input('present');
            $etatN->date = $request->input('date');
            if($etatN->save()) {
                return new EtatResource($etatN);
            }
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
