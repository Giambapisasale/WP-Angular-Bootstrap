<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Contratto;

use Illuminate\Http\Request;
use Mail;

class VerificaController extends Controller {

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
		
        $verifica = \DB::table("tacqua_dichiarazione")
			->join("tco_contribuente","tacqua_dichiarazione.idtco_contribuente","=","tco_contribuente.idtco_contribuente")
			->join("tacqua_dichiarazione_lettura","tacqua_dichiarazione_lettura.idtacqua_dichiarazione","=","tacqua_dichiarazione.idtacqua_dichiarazione")
		   //->where("tacqua_dichiarazione.tco_contribuente.idtco_contribuente = tacqua_dichiarazione.idtco_contribuente")
		    ->select ("tacqua_dichiarazione.*","tco_contribuente.*","tacqua_dichiarazione_lettura.*")
			->where("tacqua_dichiarazione_lettura.verifica", "=", "0")
			->get();
			

        return $verifica;
    }
	//gestione e verifica contribuenti
	 public function utenti($id)
    {
		
        $verifica = \DB::table("tco_contribuente")
			->select ("tco_contribuente.*")
			->where("tco_contribuente.verifica", "=", "0")
			->get();
			

        return $verifica;
    }
	public function utente($id)
    {
       
		 $verifica = \DB::table("tco_contribuente")
			->select ("tco_contribuente.*")
			->where("tco_contribuente.verifica", "=", "0")
			->where("tco_contribuente.idtco_contribuente", "=", $id)
			->get();

        return $verifica;
    }
	public function accettaUtente($id)
    {	

        $verifica = \DB::table("tco_contribuente")
			->where("tco_contribuente.idtco_contribuente", "=", $id)
            ->update(['verifica' => 1]);	
			
			
        return $verifica;
    }
	public function rifiutaUtente($id)
    {	

        $verifica = \DB::table("tco_contribuente")
			->where("tco_contribuente.idtco_contribuente", "=", $id)
            ->update(['verifica' => 0]);

			
			
        return $verifica;
    }
	
	//gestione aquedotto
    public function dettaglio($id)
    {
     
		$verifica = \DB::table("tacqua_dichiarazione")
			->join("tco_contribuente","tacqua_dichiarazione.idtco_contribuente","=","tco_contribuente.idtco_contribuente")
			->join("tacqua_dichiarazione_lettura","tacqua_dichiarazione_lettura.idtacqua_dichiarazione","=","tacqua_dichiarazione.idtacqua_dichiarazione")
		    ->select("tacqua_dichiarazione.*","tco_contribuente.*","tacqua_dichiarazione_lettura.*")
			->where("tacqua_dichiarazione_lettura.idtacqua_dichiarazione_lettura", "=", $id)
			->get();

        return $verifica;
    }
	
	
	 public function accetta($id)
    {	

        $verifica = \DB::table("tacqua_dichiarazione_lettura")
			->where("tacqua_dichiarazione_lettura.idtacqua_dichiarazione_lettura", "=", $id)
            ->update(['verifica' => 1]);
	
		
		/* Invio email, contenuto template "welcome"
		\Mail::send("welcome", array(), function ($message) {
		$message->from('us@example.com', 'Laravel');

		$message->to('mg.divenire@gmail.com')->subject('Accettazione dati nel portale');
		});
		
		*/
        return $verifica;
    }
	
	
	
	 public function rifiuta($id)
    {
         $verifica = \DB::table("tacqua_dichiarazione_lettura")
			->where("tacqua_dichiarazione_lettura.idtacqua_dichiarazione_lettura", "=", $id)
            ->update(['verifica' => 2]);
			
		

        return $verifica;
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
