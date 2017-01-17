<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;

class RegistrazioneController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		return array(
				1 => "Jon",
				2 => "May",
				3 => "Seven"
		);
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($request)
	{
		
		
		parse_str($request, $result);
		
		
		$rules = array(
        'nome'             => 'required|min:3',                        // just a normal required validation
		'cognome'          => 'required|min:3',
		'datanascita'      => 'required|date',
		'comunenascita'	   => 'required',
		'provincianascita' => 'required|max:2',
		'citt_residenza'   => 'required',
		'prov_residenza'   => 'required',
		'cap_residenza'    => 'required|max:6',
		'indirizzo'    	   => 'required',
		'civico'    	   => 'required',
		'singleSelect'     => 'required|max:1',
		'codicefiscale'    => 'required|max:16|min:16',
		'telefono'    	   => 'required|min:4|max:15',
		'cellulare'    	   => 'required|min:4|max:15',
		'notes'    	  	   => 'max:500',
        'email'            => 'required|email'     // required and must be unique in the ducks table
		);
		
		
		$validator = Validator::make($result, $rules);
		
		if ($validator->fails()) {
			 //return "Errore nei dati inseriti, riprovare <script>setTimeout(function(){ javascript:history.go(-1) }, 3000);</script>";
				return "<script>window.location='/portale/#/panel/errore/';<script>";
		}
		
		
		
		$wp_id = $result['wp_id'];
		$cognome = $result['cognome'];
		$nome = $result['nome'];
		$data_nascita = date('Y-m-d', strtotime($result['datanascita']));
		$comunenascita = $result['comunenascita'];
		$provincianascita = $result['provincianascita'];
		$citt_residenza = $result['citt_residenza'];
		$prov_residenza = $result['prov_residenza'];
		$cap_residenza = $result['cap_residenza'];
		$indirizzo = $result['indirizzo'];
		$civico = $result['civico'];
		$sesso = $result['singleSelect'];
		$scala = $result['scala'];
		$interno = $result['interno'];
		$piano = $result['piano'];
		$codicefiscale = $result['codicefiscale'];
		$partitaiva = $result['partitaiva'];
		$telefono = $result['telefono'];
		$cellulare = $result['cellulare'];
		$email = $result['email'];
		$note = $result['notes'];
		
		
		
		
		
		$inserimento=\DB::table('tco_contribuente')->insertGetId(
			array('cognome'=> $cognome,
				  'nome'=>$nome,
				  'data_nascita' => $data_nascita,
				  'comune_nascita' => $comunenascita,
				  'prov_nascita' => $provincianascita,
				  'citta' => $citt_residenza,
				  'indirizzo' => $indirizzo,
				  'prov' => $prov_residenza,
				  'cap' => $cap_residenza,
				  'civico' => $civico,
				  'sesso' => $sesso,
				  'scala' => $scala,
				  'interno' => $interno,
				  'piano' => $piano,
				  'codicefiscale' => $codicefiscale,
				  'piva' => $partitaiva,
				  'telefono' => $telefono,
				  'cellulare' => $cellulare,
				  'email' => $email,
				  'note' => $note,
				  'verifica'=>0
				)
			);
		
		$wp_tc_insert=\DB::table('wp_tco_utenti')->insertGetId(
			array( 'idwp_user'=>((int)$wp_id),
				   'idtco_contribuente'=>((int)$inserimento)
				 )
		);
		
		
		
		return "<script>window.location='/portale/#/panel/success/';</script>";
	}
	
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $id;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
