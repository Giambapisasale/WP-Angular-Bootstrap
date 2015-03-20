<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTacquaTblCategoriaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tacqua_tbl_categoria', function(Blueprint $table)
		{
			$table->increments('idtacqua_tbl_categoria');
			$table->integer('idsic_ente')->nullable();
			$table->string('categoria', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tacqua_tbl_categoria');
	}

}
