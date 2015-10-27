<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InboxTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	Schema::create('inbox_table', function(Blueprint $table)
        {
  			$table->integer('id');
  			$table->string('messageid')->unique(); 
  			$table->string('subject');
  			$table->string('from_mail'); 
  			$table->string('to_mail');
 			$table->string('time');
 			$table->longtext('body');
            $table->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('inbox_table');		
	}

}
