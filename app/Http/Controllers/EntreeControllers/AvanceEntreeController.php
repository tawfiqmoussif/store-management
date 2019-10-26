<?php
namespace App\Http\Controllers\EntreeControllers;

use Illuminate\Http\Request;
use App\AvanceEntree;
use App\Entree;
use App\Magasin;
use App\Http\Resources\AvanceEntree as AvanceEntreeResource;
use App\Http\Controllers\Controller;
use JWTAuth;


class AvanceEntreeController extends Controller
{
    //
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $AvanceEntrees = JWTAuth::parseToken()->toUser()->entrees;
        return AvanceEntreeResource::collection($AvanceEntrees);
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
        $AvanceEntree=new AvanceEntree();
        $AvanceEntree->entree_id=$request->input('entree_id');
        $AvanceEntree->user_id=JWTAuth::parseToken()->toUser()->id;
        $AvanceEntree->type_paiement=$request->input('type_paiement');
        $AvanceEntree->date=$request->input('date');
        $AvanceEntree->valider='non';
        $AvanceEntree->description=$request->input('description');
        $AvanceEntree->numero=$request->input('numero');
        $AvanceEntree->montant=$request->input('montant');
        if($AvanceEntree->save()) {
            return new AvanceEntreeResource($AvanceEntree);
        }
    }
    public function Avances(Request $request) {
        $date = $request->input('date');
        $id = JWTAuth::parseToken()->toUser()->id;
        $avances = AvanceEntree::where([['user_id','=',$id],
        ['date','=', $date],['type_paiement','=','شيك'],['valider','=','non']])->orWhere([['user_id','=',$id],
        ['date','=', $date],['type_paiement','=','كمبيالة'],['valider','=','non']])->get();
        return AvanceEntreeResource::collection($avances);
    }
    public function AvancesToCalendar(Request $request) {
        $date = $request->input('date');
        $year = explode('-',$date['date']);
        $id = JWTAuth::parseToken()->toUser()->id;
        $avances = AvanceEntree::where([['user_id','=',$id],
        ['type_paiement','=','شيك']])->orWhere([['user_id','=',$id],
        ['type_paiement','=','كمبيالة']])->whereYear('date', '=', $year[0])->get();
        return AvanceEntreeResource::collection($avances);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $AvanceEntree = AvanceEntree::findOrFail($id);
        return new AvanceEntreeResource($AvanceEntree);
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
        $AvanceEntree=AvanceEntree::findOrFail($id);
        $AvanceEntree->type_paiement=$request->input('type_paiement');
        $AvanceEntree->date=$request->input('date');
        $AvanceEntree->description=$request->input('description');
        $AvanceEntree->montant=$request->input('montant');
        if($AvanceEntree->save()) {
            return new AvanceEntreeResource($AvanceEntree);
        }
    }
    public function modifier(Request $request)
    {
        $AvanceEntree=AvanceEntree::findOrFail($request->input('id'));
        if(($AvanceEntree->type_paiement == 'شيك' || $AvanceEntree->type_paiement == 'كمبيالة') && $AvanceEntree->valider=='non') {
            if($request->input('type_paiement') != 'شيك' && $request->input('type_paiement') != 'كمبيالة')
           { 
            $AvanceEntree->type_paiement=$request->input('type_paiement');
            $AvanceEntree->date=$request->input('date');
            $AvanceEntree->description=$request->input('description');
            $AvanceEntree->montant=$request->input('montant');
            $AvanceEntree->numero=$request->input('numero');
            $entree=Entree::findOrFail($request->input('entree_id'));
            $entree->montant_paye = $entree->montant_paye + $request->input('montant');
            $entree->save();
            if($AvanceEntree->save()) {
                return new AvanceEntreeResource($AvanceEntree);
            }}
            else{
                $AvanceEntree->type_paiement=$request->input('type_paiement');
                $AvanceEntree->date=$request->input('date');
                $AvanceEntree->description=$request->input('description');
                $AvanceEntree->numero=$request->input('numero');
                $AvanceEntree->montant=$request->input('montant');
                if($AvanceEntree->save()) {
                    return new AvanceEntreeResource($AvanceEntree);
                }
            }
        }
       else {
        $montant1 = $AvanceEntree->montant;
        $AvanceEntree->type_paiement=$request->input('type_paiement');
        $AvanceEntree->date=$request->input('date');
        $AvanceEntree->numero=$request->input('numero');
        $AvanceEntree->description=$request->input('description');
        $AvanceEntree->montant=$request->input('montant');
        $montant2 = $AvanceEntree->montant;
        if($montant1>$montant2) {
            $diff=$montant1-$montant2;
            $entree=Entree::findOrFail($request->input('entree_id'));
            $entree->montant_paye = $entree->montant_paye - $diff;
            $entree->save();
        }
        if($montant2>$montant1) {
            $diff=$montant2-$montant1;
            $entree=Entree::findOrFail($request->input('entree_id'));
            $entree->montant_paye = $entree->montant_paye + $diff;
            $entree->save();
        }
        if($AvanceEntree->save()) {
            return new AvanceEntreeResource($AvanceEntree);
        }}
    }
    public function valider($id)
    {
        $AvanceEntree=AvanceEntree::findOrFail($id);
        $AvanceEntree->valider='oui';
        if($AvanceEntree->save()) {
            return new AvanceEntreeResource($AvanceEntree);
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
        $AvanceEntree=AvanceEntree::findOrFail($id);
        if($AvanceEntree->delete()) {
            return new AvanceEntreeResource($AvanceEntree);
        }
    }
}
