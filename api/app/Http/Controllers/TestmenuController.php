<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Contratto;

use Illuminate\Http\Request;

class TestmenuController extends Controller {

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

    /**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $affissioni = \DB::table("vista_affissioni_dichiazioni_completa")
            ->where("vista_affissioni_dichiazioni_completa.idtco_utente", "=", $id)
            ->get();

        return $affissioni;
    }

    public function dettaglio($id)
    {
        $affissioni = \DB::table("vista_affissioni_dichiazioni_completa")
            ->where("vista_affissioni_dichiazioni_completa.idtaffissione_dichiarazione", "=", $id)
            ->get();

        return $affissioni;
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
