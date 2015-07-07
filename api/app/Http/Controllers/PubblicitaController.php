<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Contratto;

use Illuminate\Http\Request;

class PubblicitaController extends Controller {

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
        $pubblicita = \DB::table("vista_pubblicita_dichiazioni_completa")
            ->where("vista_pubblicita_dichiazioni_completa.idtco_contribuente", "=", $id)
            ->get();

        return array("pubblicita" => $pubblicita);
    }

    public function dettaglio($id)
    {
        $pubblicita = \DB::table("vista_pubblicita_dichiazioni_completa")
            ->where("vista_pubblicita_dichiazioni_completa.idtpub_tbl_utenza", "=", $id)
            ->get();

        return $pubblicita;
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
