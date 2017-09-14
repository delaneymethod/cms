<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();
		
		Schema::create('notifications', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
			
			$table->uuid('id')->primary();
			
			$table->string('type');
			
			$table->morphs('notifiable');
			
			$table->text('data');
			
			$table->timestamp('read_at')->nullable();
			
			$table->timestamps();
		});
		
		Schema::table('notifications', function (Blueprint $table) {
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('notifications');
	}
}
