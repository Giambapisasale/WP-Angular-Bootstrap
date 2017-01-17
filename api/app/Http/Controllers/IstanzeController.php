<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;

use Input;
use Form;

class IstanzeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show()
	{
		
	}
	

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function store()
	{
		session_start();
		
		$rules = array(
		'data_istanza'      	 => 'required|date',
		'titolo'	   			 => 'required|max:100',
		'oggetto'	   			 => 'required|max:500',
		'tipo_di_istanza'	   	 => 'required|max:50',
		'allegato'				 => 'max:2048|mimes:pdf,doc,docx,jpg,jpeg,bmp,png'
		);
		
		$validatorFail = Validator::make(\Input::all(), $rules)->fails() ? true : false;
		if ($validatorFail || !isset($_SESSION["userData"])) 
		{
			return "<script>window.location='/portale/#/panel/errore/';</script>";
		}
		
		$url_file="";
		if(\Input::file('allegato'))
        {
			$file_allegato = \Input::file('allegato');
			$filename  = time() . '.' . $file_allegato->getClientOriginalExtension();
			$path = public_path('istanze_file_upload/');
			if($file_allegato->move($path, $filename))
			{
				$url_file="/api/public/istanze_file_upload/".$filename;
			}
			else
			{
				return "<script>window.location='/portale/#/panel/errore/';</script>";
			}
        }
		$currentUserDecoded = json_decode($_SESSION["userData"]);
		$id_utente = $currentUserDecoded->ID;
		$data = date('Y-m-d', strtotime(\Input::get('data_istanza')));
		$titolo = \Input::get('titolo');
		$oggetto = \Input::get('oggetto');
		$tipo_di_istanza = \Input::get('tipo_di_istanza');
		
		$contribuente = \DB::table("wp_tco_utenti")
        	->where("wp_tco_utenti.idwp_user", "=", $id_utente)
            ->first(); 

		$inserimento = \DB::table('tco_istanza')->insert([
				[ 'id_utente'=> $contribuente->idtco_contribuente,'data_istanza'=>$data,'titolo' => $titolo,'oggetto' => $oggetto,'tipo_di_istanza' => $tipo_di_istanza,'url_allegato'=>$url_file]
			]);
		
		return "<script>window.location='/portale/#/panel/success/';</script>";
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
