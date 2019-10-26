<?php
namespace App\Http\Controllers\SortieControllers;

use Illuminate\Http\Request;
use App\AvanceSortie;
use App\Sortie;
use App\Magasin;
use App\Http\Resources\AvanceSortie as AvanceSortieResource;
use App\Http\Controllers\Controller;
use JWTAuth;


class AvanceSortieController extends Controller
{
    //
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $AvanceSorties = JWTAuth::parseToken()->toUser()->sorties;
        return AvanceSortieResource::collection($AvanceSorties);
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
       $AvanceSortie=new AvanceSortie();
        $AvanceSortie->sortie_id=$request->input('sortie_id');
        $AvanceSortie->type_paiement=$request->input('type_paiement');
        $AvanceSortie->date=$request->input('date');
        $AvanceSortie->numero=$request->input('numero');
        $AvanceSortie->valider='non';
        $AvanceSortie->user_id=JWTAuth::parseToken()->toUser()->id;
        $AvanceSortie->description=$request->input('description');
        $AvanceSortie->montant=$request->input('montant');
        if($AvanceSortie->save()) {
            return new AvanceSortieResource($AvanceSortie);
        }
    }
    public function Avances(Request $request) {
        $date = $request->input('date');
        $id = JWTAuth::parseToken()->toUser()->id;
        $avances = AvanceSortie::where([['user_id','=',$id],
        ['date','=', $date],['type_paiement','=','شيك'],['valider','=','non']])->orWhere([['user_id','=',$id],
        ['date','=', $date],['type_paiement','=','كمبيالة'],['valider','=','non']])->get();
        return AvanceSortieResource::collection($avances);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $AvanceSortie = AvanceSortie::findOrFail($id);
        return new AvanceSortieResource($AvanceSortie);
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
        $AvanceSortie=AvanceSortie::findOrFail($id);
        $AvanceSortie->type_paiement=$request->input('type_paiement');
        $AvanceSortie->date=$request->input('date');
        $AvanceSortie->description=$request->input('description');
        $AvanceSortie->montant=$request->input('montant');
        if($AvanceSortie->save()) {
            return new AvanceSortieResource($AvanceSortie);
        }
    }
    public function modifier(Request $request)
    {
        $AvanceSortie=AvanceSortie::findOrFail($request->input('id'));
        if(($AvanceSortie->type_paiement == 'شيك' || $AvanceSortie->type_paiement == 'كمبيالة') && $AvanceSortie->valider=='non') {
            if($request->input('type_paiement') != 'شيك' && $request->input('type_paiement') != 'كمبيالة')
           { 
            $AvanceSortie->type_paiement=$request->input('type_paiement');
            $AvanceSortie->date=$request->input('date');
            $AvanceSortie->description=$request->input('description');
            $AvanceSortie->montant=$request->input('montant');
            $AvanceSortie->numero=$request->input('numero');
            $sortie=Sortie::findOrFail($request->input('sortie_id'));
            $sortie->montant = $sortie->montant + $request->input('montant');
            $sortie->save();
            if($AvanceSortie->save()) {
                return new AvanceSortieResource($AvanceSortie);
            }}
            else{
                $AvanceSortie->type_paiement=$request->input('type_paiement');
                $AvanceSortie->date=$request->input('date');
                $AvanceSortie->description=$request->input('description');
                $AvanceSortie->numero=$request->input('numero');
                $AvanceSortie->montant=$request->input('montant');
                if($AvanceSortie->save()) {
                    return new AvanceSortieResource($AvanceSortie);
                }
            }
        }
       else {
        $montant1 = $AvanceSortie->montant;
        $AvanceSortie->type_paiement=$request->input('type_paiement');
        $AvanceSortie->date=$request->input('date');
        $AvanceSortie->description=$request->input('description');
        $AvanceSortie->description=$request->input('description');
        $AvanceSortie->numero=$request->input('numero');
        $montant2 = $AvanceSortie->montant;
        if($montant1>$montant2) {
            $diff=$montant1-$montant2;
            $sortie=Sortie::findOrFail($request->input('sortie_id'));
            $sortie->montant = $sortie->montant - $diff;
            $sortie->save();
        }
        if($montant2>$montant1) {
            $diff=$montant2-$montant1;
            $sortie=Sortie::findOrFail($request->input('sortie_id'));
            $sortie->montant = $sortie->montant + $diff;
            $sortie->save();
        }
        if($AvanceSortie->save()) {
            return new AvanceSortieResource($AvanceSortie);
        }}
    }

    public function valider($id)
    {
        $AvanceSortie=AvanceSortie::findOrFail($id);
        $AvanceSortie->valider='oui';
        if($AvanceSortie->save()) {
            return new AvanceSortieResource($AvanceSortie);
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
        $AvanceSortie=AvanceSortie::findOrFail($id);
        if($AvanceSortie->delete()) {
            return new AvanceSortieResource($AvanceSortie);
        }
    }
}
