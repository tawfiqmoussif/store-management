<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//personnes
Route::post('personne','PersonneControllers\PersonneController@store');
Route::get('personnes','PersonneControllers\PersonneController@index');
Route::put('personne/{id}','PersonneControllers\PersonneController@update');
Route::delete('personne/{id}', 'PersonneControllers\PersonneController@destroy');
Route::get('personne/{id}', 'PersonneControllers\PersonneController@show');
Route::post('personneU','PersonneControllers\PersonneController@personneU');

//users
Route::post('user','UserControllers\UserController@store');
Route::get('users','UserControllers\UserController@index');
Route::put('user/{id}','UserControllers\UserController@update');
Route::get('user/{id}', 'UserControllers\UserController@show');
Route::delete('user/{id}', 'UserControllers\UserController@destroy');
Route::get('returnUser', 'UserControllers\UserController@returnUser');
Route::post('checkPassword', 'UserControllers\UserController@checkPassword');
Route::put('changePassword','UserControllers\UserController@changePassword');
Route::post('statistics', 'UserControllers\UserController@statistics');
//
Route::post('signin', 'UserControllers\UserController@signin');
//magasin
Route::get('magasin/{id}','MagasinControllers\MagasinController@show');
Route::get('magasins','MagasinControllers\MagasinController@index');
Route::post('magasin','MagasinControllers\MagasinController@store');
Route::delete('magasin/{id}','MagasinControllers\MagasinController@destroy');
Route::put('magasin/{id}','MagasinControllers\MagasinController@update');


//employes
Route::get('employe/{id}','EmployeControllers\EmployeController@show');
Route::get('employes',['uses'=>'EmployeControllers\EmployeController@index', 'middleware' => 'auth.jwt']);
Route::post('employe','EmployeControllers\EmployeController@store');
Route::delete('employe/{id}', 'EmployeControllers\EmployeController@destroy');
Route::put('employe/{id}', 'EmployeControllers\EmployeController@update');
Route::post('addSalaire', 'EmployeControllers\EmployeController@addSalaire');
Route::post('removeSalaire', 'EmployeControllers\EmployeController@removeSalaire');
Route::post('updateSalaire', 'EmployeControllers\EmployeController@updateSalaire');

//etats
Route::post('etat','EmployeControllers\EtatController@store');
Route::get('etats/{id}','EmployeControllers\EtatController@index');
//avanceEmploye
Route::post('avanceEmploye','EmployeControllers\AvanceEmployeController@store');
Route::get('avanceEmployes/{id}','EmployeControllers\AvanceEmployeController@index');
Route::post('getByDate','EmployeControllers\AvanceEmployeController@getByDate');

//charges
Route::post('charge','ChargeControllers\ChargeController@store');
Route::get('electricite','ChargeControllers\ChargeController@electricite');
Route::get('eau','ChargeControllers\ChargeController@eau');
Route::get('charges','ChargeControllers\ChargeController@index');
Route::put('charge/{id}','ChargeControllers\ChargeController@update');
Route::get('charge/{id}', 'ChargeControllers\ChargeController@show');
Route::delete('charge/{id}', 'ChargeControllers\ChargeController@destroy');

//type_charges
Route::get('typeCharges','ChargeControllers\TypeChargeController@index');
Route::delete('typeCharges/{id}', 'ChargeControllers\TypeChargeController@destroy');
Route::put('typeCharges/{id}','ChargeControllers\TypeChargeController@update');
Route::post('typeCharges','ChargeControllers\TypeChargeController@store');

//les fournisseurs
Route::get('fournisseur/{id}','FournisseurController@show');
Route::get('returnFournisseur/{id}','FournisseurController@returnFournisseur');
Route::get('fournisseurs','FournisseurController@index');
Route::post('fournisseur','FournisseurController@store');
Route::delete('fournisseur/{id}', 'FournisseurController@destroy');
Route::put('fournisseur/{id}', 'FournisseurController@update');
Route::get('marques','FournisseurController@returnMarques');


//clients
Route::post('client','ClientControllers\ClientController@store');
Route::get('clients','ClientControllers\ClientController@index');
Route::put('client/{id}','ClientControllers\ClientController@update');
Route::get('client/{id}', 'ClientControllers\ClientController@show');
Route::delete('client/{id}', 'ClientControllers\ClientController@destroy');

//series
Route::post('serie','SerieControllers\SerieController@store');
Route::get('series','SerieControllers\SerieController@index');
Route::get('refs','SerieControllers\SerieController@returnRefs');
Route::get('femmes','SerieControllers\SerieController@femmes');
Route::get('hommes','SerieControllers\SerieController@hommes');
Route::get('enfants','SerieControllers\SerieController@enfants');
Route::put('serie/{id}','SerieControllers\SerieController@update');
Route::post('modifierSerie','SerieControllers\SerieController@modifier');
Route::get('serie/{id}', 'SerieControllers\SerieController@show');
Route::delete('serie/{id}', 'SerieControllers\SerieController@destroy');
Route::post('existe','SerieControllers\SerieController@existe');
Route::get('femmesU/{id}','SerieControllers\SerieController@femmesU');
Route::get('hommesU/{id}','SerieControllers\SerieController@hommesU');
Route::get('enfantsU/{id}','SerieControllers\SerieController@enfantsU');
Route::post('serieCommande','SerieControllers\SerieController@serieCommande');

//type_series
Route::get('typeSeries','SerieControllers\TypeSerieController@index');
Route::get('libeles','SerieControllers\TypeSerieController@returnLibeles');
Route::delete('typeSeries/{id}', 'SerieControllers\TypeSerieController@destroy');
Route::put('typeSeries/{id}','SerieControllers\TypeSerieController@update');
Route::post('typeSeries','SerieControllers\TypeSerieController@store');

//articles
Route::post('article','SerieControllers\ArticleController@store');
Route::put('article/{id}','SerieControllers\ArticleController@update');
Route::get('articles/{id}','SerieControllers\ArticleController@index');
Route::get('countTailles/{id}','SerieControllers\ArticleController@countTailles');
Route::put('addStock','SerieControllers\ArticleController@addStock');
Route::get('returnTailles/{id}','SerieControllers\ArticleController@returnTailles');
Route::put('removeStock','SerieControllers\ArticleController@removeStock');
//
//Route::put('article/{id}','SerieControllers\ArticleController@updateStock');

//sortie_details
Route::get('sortieDetailsg','SerieControllers\SortieDetailsController@index');
Route::delete('sortieDetails/{id}', 'SerieControllers\SortieDetailsController@destroy');
Route::put('sortieDetails/{id}','SerieControllers\SortieDetailsController@update');
Route::post('sortieDetails','SerieControllers\SortieDetailsController@store');
Route::post('dailyStatistics','SerieControllers\SortieDetailsController@dailyStatistics');
Route::post('dailySales','SerieControllers\SortieDetailsController@dailySales');
//Les entrees
Route::post('entree','EntreeControllers\EntreeController@store');
Route::put('entree/{id}','EntreeControllers\EntreeController@update');
Route::put('ajouterPartie/{id}','EntreeControllers\EntreeController@ajouterPartie');
Route::put('modifierEntree','EntreeControllers\EntreeController@modifier');
Route::get('entrees','EntreeControllers\EntreeController@index');
Route::post('print','EntreeControllers\EntreeController@printPDF');
Route::get('sommeFourisseur/{id}','EntreeControllers\EntreeController@returnSommeFournisseur');
//ligneEntree
Route::post('ligneEntree','EntreeControllers\LigneEntreeController@store');
Route::put('ligneEntree/{id}','EntreeControllers\LigneEntreeController@update');
Route::get('returnPrix/{id}','EntreeControllers\LigneEntreeController@returnPrix');
//AvanceEntree
Route::put('modifierAvanceEntree','EntreeControllers\AvanceEntreeController@modifier');
Route::post('AvanceEntree','EntreeControllers\AvanceEntreeController@store');
Route::put('AvanceEntree/{id}','EntreeControllers\AvanceEntreeController@update');
Route::put('valider/{id}','EntreeControllers\AvanceEntreeController@valider');
Route::get('AvanceEntrees','EntreeControllers\AvanceEntreeController@index');
Route::post('avancesEntreeNotif','EntreeControllers\AvanceEntreeController@avances');
Route::post('avancesEntreeCalendar','EntreeControllers\AvanceEntreeController@AvancesToCalendar');
//Les sorties
Route::post('sortie','SortieControllers\SortieController@store');
Route::post('sortieC','SortieControllers\SortieController@ajouterCommande');
Route::put('sortie/{id}','SortieControllers\SortieController@update');
Route::put('modifierSortie','SortieControllers\SortieController@modifier');
Route::put('ajouterPartieS/{id}','SortieControllers\SortieController@ajouterPartie');
Route::get('sorties','SortieControllers\SortieController@index');
Route::get('sommeClient/{id}','SortieControllers\SortieController@returnSommeClient');
Route::post('printSortie','SortieControllers\SortieController@printPDF');
//ligneSortie
Route::post('ligneSortie','SortieControllers\LigneSortieController@store');
Route::post('ligneSortieCommande','SortieControllers\LigneSortieController@ajouterCommande');
Route::put('ligneSortie/{id}','SortieControllers\LigneSortieController@update');
//Route::get('returnPrix/{id}','SortieControllers\LigneSortieController@returnPrix');
//AvanceSortie
Route::put('modifierAvanceSortie','SortieControllers\AvanceSortieController@modifier');
Route::post('AvanceSortie','SortieControllers\AvanceSortieController@store');
Route::put('AvanceSortie/{id}','SortieControllers\AvanceSortieController@update');
Route::put('validerS/{id}','SortieControllers\AvanceSortieController@valider');
Route::get('AvanceSorties','SortieControllers\AvanceSortieController@index');
Route::post('avancesSortieNotif','SortieControllers\AvanceSortieController@avances');

//commandes
Route::post('AjouterCommande','CommandeController@store');
Route::get('commandes','CommandeController@index');
Route::get('commandes_en_attente','CommandeController@commandes_en_attente');
Route::get('commandes_acceptees','CommandeController@commandes_acceptees');
Route::put('accepte/{id}','CommandeController@accepte');
Route::put('refuse/{id}','CommandeController@refuse');
Route::put('recu/{id}','CommandeController@recu');
Route::put('nonRecu/{id}','CommandeController@non_recu');
//article commande
Route::post('AjouterArticleCommande','ArticleCommandeController@store');
Route::put('ModifierArticleCommande/{id}','ArticleCommandeController@update');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
