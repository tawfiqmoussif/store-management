<?php

namespace App\Http\Controllers\EmployeControllers;

use Illuminate\Http\Request;
use App\Employe;
use App\Magasin;
use App\Http\Resources\Employe as EmployeResource;
use App\Http\Controllers\Controller;
use JWTAuth;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       /* if(! $user = JWTAuth::parseToken()->authenticate()){
            return response()->json(['message' => 'User not found'], 404);
        }*/
        //get the user
        //$user = JWTAuth::parseToken()->toUser();
       // $employes = Employe::orderBy('created_at', 'desc')->paginate(5);
       //$magasin = Magasin::where('user_id', JWTAuth::parseToken()->toUser()->id)->get();
       //$employes = Magasin::find($magasin[0]['id'])->employes->sortByDesc('created_at');
       $employes = JWTAuth::parseToken()->toUser()->employes;
       return EmployeResource::collection($employes);
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
        $employe=new Employe();
        $employe->user_id=JWTAuth::parseToken()->toUser()->id;
        $employe->personne_id=$request->input('personne_id');
        $employe->magasin_id=$magasin[0]['id'];
        $employe->salaire=$request->input('salaire');
        $employe->sommesalaires=0;
        $employe->date_recrutement=$request->input('date_recrutement');
        if($employe->save()) {
            return new EmployeResource($employe);
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
        $employe = Employe::findOrFail($id);
        return new EmployeResource($employe);
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
        $employe=Employe::findOrFail($id);
        $employe->personne_id=$request->input('personne_id');
        $employe->salaire=$request->input('salaire');
        $employe->date_recrutement=$request->input('date_recrutement');
        if($employe->save()) {
            return new EmployeResource($employe);
        }
    }
    public function addSalaire(Request $request) {
        $employe=Employe::findOrFail($request->input('id'));
        $employe->sommesalaires = $employe->sommesalaires + $employe->salaire;
        if($employe->save()) {
            return new EmployeResource($employe);
        }
    }
    public function removeSalaire(Request $request) {
        $employe=Employe::findOrFail($request->input('id'));
        $employe->sommesalaires = $employe->sommesalaires - $employe->salaire;
        if($employe->save()) {
            return new EmployeResource($employe);
        }
    }
    public function updateSalaire(Request $request) {
        $employe=Employe::findOrFail($request->input('id'));
        $employe->sommesalaires = $employe->sommesalaires - $request->input('sommesalaires');
        if($employe->save()) {
            return new EmployeResource($employe);
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
        $employe=Employe::findOrFail($id);
        if($employe->delete()) {
            return new EmployeResource($employe);
        }
    }
}
