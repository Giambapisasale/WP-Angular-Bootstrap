<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContrattosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tacqua_dichiarazione', function(Blueprint $table)
		{
			$table->increments('idtacqua_dichiarazione');
			$table->integer('idsic_ente')->unsigned()->nullable();
			$table->integer('idtco_contribuente')->nullable();
			$table->integer('idtco_proprietario')->nullable();
			$table->integer('idtco_recapito')->nullable();
			$table->integer('numero_contratto')->nullable();
			$table->string('numero_protocollo', 10)->nullable();
			$table->date('data_protocollo')->nullable()->default('0001-01-01');
			$table->date('data_inizio_contratto')->nullable()->default('0001-01-01');
			$table->date('data_fine_contratto')->nullable()->default('0001-01-01');
			$table->date('data_inizio_sospensione')->nullable()->default('0001-01-01');
			$table->date('data_fine_sospensione')->nullable()->default('0001-01-01');
			$table->integer('idmaps_immobile')->nullable();
			$table->integer('codice_giro')->nullable();
			$table->integer('idtacqua_tbl_categoria')->unsigned()->nullable();
			$table->integer('idtacqua_tbl_classe')->nullable();
			$table->integer('idtacqua_tbl_tipo_riduzione')->unsigned()->nullable();
			$table->integer('idtacqua_tbl_scarico')->nullable();
			$table->string('matricola', 20)->nullable();
			$table->string('marca', 50)->nullable();
			$table->integer('numero_unita')->nullable();
			$table->integer('numero_allacci')->nullable();
			$table->text('messaggio')->nullable();
			$table->text('note')->nullable();
			$table->index(['idtco_contribuente','idtco_proprietario'], 'contribuente');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tacqua_dichiarazione');
	}

}
