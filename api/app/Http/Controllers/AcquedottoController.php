<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;

use Input;
use Form;

class AcquedottoController extends Controller {

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
	public function store()
	{
		
		$rules = array(
		'data_lettura'      	 => 'required|date',
		'consumo'	   			 => 'required|numeric',
		'idtacqua_dichiarazione' => 'required|numeric',
		'note' 					 => 'max:500',
		'photo_file'			 => 'image|max:2048'
		);
		
		
		$validator = Validator::make(\Input::all(), $rules);
		
		if ($validator->fails()) {
			
			
			return "<script>window.location='/portale/#/panel/errore/';</script>";
		}
		
		$url_photo="";
		if(\Input::file('photo_file'))
        {
			$file_allegato = \Input::file('photo_file');
			$filename  = time() . '.' . $file_allegato->getClientOriginalExtension();
			$path = public_path('uploaded_pictures/');
			if($file_allegato->move($path, $filename))
			{
				$url_photo="/api/public/uploaded_pictures/".$filename;
			}
			else
			{
				return "<script>window.location='/portale/#/panel/errore/';</script>";
			}
        }

		$data = date('Y-m-d', strtotime(\Input::get('data_lettura')));
		$lettura = \Input::get('lettura');
		$consumo = \Input::get('consumo');
		$idacqua = \Input::get('idtacqua_dichiarazione');
		$note = \Input::get('note');
		
		//$data=str_replace('-', '/', $data);
		$inserimento=\DB::table('tacqua_dichiarazione_lettura')->insert([
				[ 'idtacqua_dichiarazione'=> $idacqua,'data_lettura'=>$data,'lettura' => ((float)$lettura),'consumo' => ((float)$consumo),'fatturata' => 2,'note' => $note,'idtacqua_tbl_tipo_lettura' =>4,'url_foto'=>$url_photo]
			]);
		
		
		
		
		return "<script>window.location='/portale/#/panel/success/';</script>";
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
