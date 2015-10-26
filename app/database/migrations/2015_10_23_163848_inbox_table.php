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
  			$table->string('messageid'); 
  			$table->string('subject');
  			$table->string('snippet'); 
  			$table->string('date');
 			$table->string('sender');
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



From:{{$messageSender}}<br>
To: {{$message->payload['headers']['0']['value']}}<br>
Sub: {{$message->payload['headers']['12']['value']}}
217b5837e8a6b61fea9ab2f5d8ec39f7d29c78c0