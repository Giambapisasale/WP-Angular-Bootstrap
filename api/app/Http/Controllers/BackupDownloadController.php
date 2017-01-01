<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;

use Input;
use Form;

class BackupDownloadController extends Controller {

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
	
	public function isNotAdmin($currentUserJSON)
	{
		$currentUserDecoded = json_decode($currentUserJSON);
		foreach($currentUserDecoded->roles as $value)
			if(strpos($value,"admin") !== false)
				return false;
		return true;
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show()
	{
		header('Content-Type: application/json');
		
		$rules = array(
		'tableName'      	 => 'required'
		);
		$validatorFail = Validator::make(\Input::all(), $rules)->fails() ? true : false;
		if ($validatorFail) 
		{
			$returnObject = array('error' => 'ERROR: something went wrong.');
			return json_encode($returnObject);
		}
		
		session_start();
		
		if(!isset($_SESSION["userData"]) || $this->isNotAdmin($_SESSION["userData"]))
		{
			$returnObject = array('error' => 'ERROR: Only admins can use this functionality!');
			return json_encode($returnObject);
		}
		
		$tableName = \Input::get('tableName');
		$table = \DB::table($tableName)->get();
		return json_encode($table);
	}
	

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function store()
	{
		header('Content-Type: application/json');
		
		$rules = array(
		'tableName'      	 => 'required',
		'modality'			=> 'required',
		'data'			=> 'required'
		);
		$validatorFail = Validator::make(\Input::all(), $rules)->fails() ? true : false;
		if ($validatorFail) 
		{
			$returnObject = array('error' => 'ERROR: something went wrong.');
			return json_encode($returnObject);
		}
		
		session_start();
		
		$returnObject;
		if(!isset($_SESSION["userData"]) || $this->isNotAdmin($_SESSION["userData"]))
		{
			$returnObject = array('error' => 'ERROR: Only admins can use this functionality!');
			return json_encode($returnObject);
		}
		
		$modality = \Input::get('modality');
		$tableName = \Input::get('tableName');
		$data = \Input::get('data');
		
		if($modality =="insert")
		{
			\DB::table($tableName)->truncate();
			\DB::table($tableName)->insert(json_decode($data,true));
			$returnObject = array('error' => 'OK');
		}
		else if($modality == "update")
		{
			\DB::table($tableName)->insert(json_decode($data,true));
			$returnObject = array('error' => 'OK');
		}
		return json_encode($returnObject);
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
