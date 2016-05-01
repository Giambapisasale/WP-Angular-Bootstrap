<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Contratto;

use Illuminate\Http\Request;

class AdminController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return \Response::json(array(
        'error' => false,
        'message' => 'url deleted'),
        200
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

	public function export()
	{
		return "hello";
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{

	}
	
	/**
	 * Lista contratti per utente specificato
	 *
	 * @param  int  $id ID utente
	 * @return Response
	 */
	public function show($id)
	{
		
	    $data=uniqid();
		
		$truncate= \DB::table('wp_tokens')->truncate();
		$inserimento=\DB::table('wp_tokens')->insert([
				[ 'token'=> $data]
		]);
		
		
		return $data;
	}
	
	public function import($id)
	{
		
	    $data=uniqid();
		
		$truncate= \DB::table('wp_tokens')->truncate();
		$inserimento=\DB::table('wp_tokens')->insert([
				[ 'token'=> $data]
		]);
		
		
		return $data;
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
