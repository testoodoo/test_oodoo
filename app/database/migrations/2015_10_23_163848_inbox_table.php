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
  			$table->increments('id');
  			$table->string('message_id')->unique(); 
  			$table->string('thread_id');
  			$table->string('history_id'); 
  			$table->string('label');
  			$table->string('subject');
  			$table->string('from_name');
  			$table->string('to_name');
  			$table->string('from_mail');
  			$table->string('to_mail');
 			$table->longtext('body');
 			$table->text('attachment');
 			$table->string('time');
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
