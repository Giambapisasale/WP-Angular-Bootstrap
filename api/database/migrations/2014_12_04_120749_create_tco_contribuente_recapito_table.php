<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTcoContribuenteRecapitoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tco_contribuente_recapito', function(Blueprint $table)
		{
			$table->integer('idtco_contribuente_recapito', true);
			$table->integer('idtco_contribuente');
			$table->string('nominativo', 200);
			$table->string('tipo_anagrafica', 200);
			$table->string('indirizzo', 200);
			$table->string('comune', 200);
			$table->string('provincia', 2);
			$table->string('cap', 10);
			$table->string('nazione', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tco_contribuente_recapito');
	}

}
