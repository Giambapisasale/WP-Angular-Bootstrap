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
		session_start();
		header('Content-Type: application/json');
		
		if(!isset($_SESSION["userData"]) || $this->isNotAdmin($_SESSION["userData"]))
		{
			$returnObject = array('error' => 'ERROR: Only admins can use this functionality!');
			return json_encode($returnObject);
		}
		else if(!isset($_GET["tableName"]))
		{
			$returnObject = array('error' => 'ERROR: parameter tableName must not be empty.');
			return json_encode($returnObject);
		}
		
		$table = \DB::table($_GET["tableName"])->get();
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
		session_start();
		header('Content-Type: application/json');
		$returnObject;
		if(!isset($_SESSION["userData"]) || $this->isNotAdmin($_SESSION["userData"]))
		{
			$returnObject = array('error' => 'ERROR: Only admins can use this functionality!');
			return json_encode($returnObject);
		}
		else if(!isset($_POST["tableName"]))
		{
			$returnObject = array('error' => 'ERROR: parameter tableName must not be empty.');
			return json_encode($returnObject);
		}
		
		if($_POST["modality"] =="insert")
		{
			\DB::table($_POST["tableName"])->truncate();
			\DB::table($_POST["tableName"])->insert(json_decode($_POST["data"],true));
			$returnObject = array('error' => 'OK');
		}
		else if($_POST["modality"] == "update")
		{
			\DB::table($_POST["tableName"])->insert(json_decode($_POST["data"],true));
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
