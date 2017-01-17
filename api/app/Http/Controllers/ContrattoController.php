<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Contratto;

use Illuminate\Http\Request;

class ContrattoController extends Controller {

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
		$data = $request->input("data");
		$lettura = $request->input("lettura");
		$consumo = $request->input("consumo");
		return array($data,$lettura,$consumo);
	}

	


	/**
	 * Lista dettagli letture e documenti (fatture) per contratto selezionato
	 *
	 * @param  int  $id ID utente
	 * @return Response
	 */
	public function dettaglio($contratto)
	{
		$letture = \DB::table("tacqua_dichiarazione_lettura")
		->leftJoin("tacqua_tbl_tipo_lettura", "tacqua_dichiarazione_lettura.idtacqua_tbl_tipo_lettura", "=", "tacqua_tbl_tipo_lettura.idtacqua_tbl_tipo_lettura")
		->where("tacqua_dichiarazione_lettura.idtacqua_dichiarazione", "=", $contratto)
		->selectRaw('idtacqua_dichiarazione_lettura as id,
					anno,
					periodo,
					descrizione as tipo_lettura,
					DATE_FORMAT(data_lettura, "%d/%m/%Y") as data_lettura')
						->get();
		
		$preavvisi = \DB::table("tco_preavviso_acqua")
		->leftJoin("tco_preavviso", "tco_preavviso_acqua.idtco_preavviso", "=", "tco_preavviso.idtco_preavviso")
		->where("tco_preavviso_acqua.idtacqua_dichiarazione", "=", $contratto)
		->selectRaw('idtco_preavviso_acqua as id,
					tco_preavviso.idtco_preavviso,
					numero_preavviso as numero_fattura,
					importo_totale as importo_fattura,
					DATE_FORMAT(data_elaborazione, "%d/%m/%Y") as data_fattura')
							->get();
		foreach ($preavvisi as $i => $preavviso) {
			$scadenze = \DB::table("tco_preavviso_rata")
			->where("idtco_preavviso", "=", $preavviso->idtco_preavviso)
			->selectRaw('DATE_FORMAT(data_scadenza, "%d/%m/%Y") as data_scadenza')
			->lists('data_scadenza');
			$preavvisi[$i]->date_scadenza = implode(", ", $scadenze);
		}	
	
		return array("letture" => $letture, "documenti" => $preavvisi);
	}
	
	
	
	/**
	 * Lista contratti per utente specificato
	 *
	 * @param  int  $id ID utente
	 * @return Response
	 */
	public function show($id)
	{
		$contratti = \DB::table("tacqua_dichiarazione")
			->leftJoin("tco_contribuente_recapito", "tacqua_dichiarazione.idtco_recapito", "=", "tco_contribuente_recapito.idtco_contribuente_recapito")
			->leftJoin("tacqua_tbl_categoria", "tacqua_dichiarazione.idtacqua_tbl_categoria", "=", "tacqua_tbl_categoria.idtacqua_tbl_categoria")
			->leftJoin("wp_tco_utenti", "wp_tco_utenti.idtco_contribuente", "=", "tacqua_dichiarazione.idtco_contribuente")
			->where("wp_tco_utenti.idwp_user", "=", $id)
			->selectRaw('idtacqua_dichiarazione as id,
					indirizzo, 
					categoria,
					matricola, 
					DATE_FORMAT(data_inizio_contratto, "%d/%m/%Y") as data')
			->get();

		return array("contracts" => $contratti);
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
