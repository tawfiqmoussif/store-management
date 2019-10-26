<?php

namespace App\Http\Controllers\UserControllers;

use Illuminate\Http\Request;
use App\User;
use App\Magasin;
use App\Fournisseur;
use App\Client;
use App\Charge;
use App\AvanceEntree;
use App\AvanceSortie;
use App\AvanceEmploye;
use App\SortieDetails;
use App\Http\Resources\User as UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function statistics(Request $request) {
        $tableau = array("01" => 0,"02" => 0,"03" => 0,"04" => 0,
        "05" => 0,"06" => 0,"07" => 0,"08" => 0,
        "09" => 0,"10" => 0,"11" => 0,"12" => 0);
        $date = $request->input('date');
        $year = explode('-',$date);
        $avancesEmploye = AvanceEmploye::where([['user_id','=',JWTAuth::parseToken()->toUser()->id]])->whereYear('date', '=', $year[0])->get();
        $charges = Charge::where([['user_id','=',JWTAuth::parseToken()->toUser()->id]])->whereYear('date', '=', $year[0])->get();
        $avancesEntree = AvanceEntree::where([['user_id','=',JWTAuth::parseToken()->toUser()->id]])->whereYear('date', '=', $year[0])->get();
        $avancesSortie = AvanceSortie::where([['user_id','=',JWTAuth::parseToken()->toUser()->id]])->whereYear('date', '=', $year[0])->get();
        $sortieDetails = SortieDetails::where([['user_id','=',JWTAuth::parseToken()->toUser()->id]])->whereYear('date', '=', $year[0])->get();
        foreach($avancesEmploye as $avanceEmploye)
        {
            $month = explode('-',$avanceEmploye['date'])['1'];
            $tableau[$month] = $tableau[$month] - $avanceEmploye['montant'];
        }
        foreach($charges as $charge)
        {
            $month = explode('-',$charge['date'])['1'];
            $tableau[$month] = $tableau[$month] - $charge['montant_total'];
        }
        foreach($avancesEntree as $avanceEntree)
        {
            $month = explode('-',$avanceEntree['date'])['1'];
            $tableau[$month] = $tableau[$month] - $avanceEntree['montant'];
        }
        foreach($avancesSortie as $avanceSortie)
        {
            $month = explode('-',$avanceSortie['date'])['1'];
            $tableau[$month] = $tableau[$month] + $avanceSortie['montant'];
        }
        foreach($sortieDetails as $sortie)
        {
            $month = explode('-',$sortie['date'])['1'];
            $tableau[$month] = $tableau[$month] + $sortie['prix_de_vente_2']*$sortie['nombre'];
        }
        return response()->json(['benifices' => $tableau], 200);
    }
    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
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
    public function returnUser(){
        $user=JWTAuth::parseToken()->toUser();
        return new UserResource($user);
    }
    public function store(Request $request)
    {
        $user=new User();
        $user->personne_id=$request->input('personne_id');
        $user->role=$request->input('role');
        $user->email=$request->input('email');
        //$pssw=substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,7);
        $pssw = '123';
        $user->password=bcrypt($pssw);
        $user->save();
        $magasin=new Magasin();
        $magasin->nom = $request['magasin']['nom'];
        $magasin->numero_de_patente = $request['magasin']['numero_de_patente'];
        $magasin->rc = $request['magasin']['rc'];
        $magasin->user_id = $user->id;
        $magasin->numero_compte_bancaire = $request['magasin']['numero_compte_bancaire'];
        $magasin->save();
        $users = UserResource::collection(User::all());
        foreach($users as $useer) {
            if($user->id != $useer->id)
            {
            $fournisseur=new Fournisseur();
            $fournisseur->personne_id = $user->personne_id;
            $fournisseur->user_id = $useer->id;
            $fournisseur->id_fiscale = ' ';
            $fournisseur->nom_marque = $magasin->nom;
            $fournisseur->save();
            $client=new Client();
            $client->personne_id = $user->personne_id;
            $client->user_id = $useer->id;
            $client->identification_fiscale = ' ';
            $client->save();

            //code added
            $fournisseurU = new Fournisseur();
            $fournisseurU->personne_id = $useer->personne_id;
            $fournisseurU->user_id = $user->id;
            $fournisseurU->id_fiscale = ' ';
            $fournisseurU->nom_marque = $useer->magasin->nom;
            $fournisseurU->save();
            //code added
            $clientU = new Client();
            $clientU->personne_id = $useer->personne_id;
            $clientU->user_id = $user->id;
            $clientU->identification_fiscale = ' ';
            $clientU->save();

        }
        }
       
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        

        try {
            //Server settings
            $mail->SMTPDebug = 2;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = 'smtp.gmail.com;';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'idrissijanati.zineb@gmail.com';                     // SMTP username
            $mail->Password   = '';                               // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('from@example.com');
            $mail->addAddress($user->email);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'الرقم السري';
            $mail->Body    = '<b>'.$pssw.'</b> رقمكم السري هو';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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
        $user = User::findOrFail($id);
        return new UserResource($user);
    }
    public function checkPassword(Request $request) {
        if (Hash::check($request->input('password'), JWTAuth::parseToken()->toUser()->password )) {
           return 1;
        }
        return 0;
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
        $user=User::findOrFail($id);
        $user->personne_id=$request->input('personne_id');
        $user->name=$request->input('name');
        $user->email=$request->input('email');
        $user->password=$request->input('password');
        if($user->save()) {
            return new UserResource($user);
        }
    }
    public function changePassword(Request $request)
    {
        $user=User::findOrFail(JWTAuth::parseToken()->toUser()->id);
        $user->password=bcrypt($request->input('password'));
        if($user->save()) {
            return new UserResource($user);
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
        $user=User::findOrFail($id);
        if($user->delete()) {
            return new UserResource($user);
        }
    }

    public function signin(Request $request){
        $credentials = $request->only('email', 'password');
        try{
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json( [
                    'error' => 'Invalid Credentials'
                ], 401);
            }

        }catch(JWTException $e) {
            return response()->json( [
                'error' => 'could not create token!'
            ], 500);
        }
        return response()->json(['token' => $token], 200);

    }
}
