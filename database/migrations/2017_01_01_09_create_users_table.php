<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();

		Schema::create('users', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
			
			$table->increments('id');
			
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email')->unique()->index();
			$table->string('password');
			$table->string('job_title')->index();
			$table->string('telephone');
			$table->string('mobile');
			
			$table->unsignedInteger('company_id')->nullable()->index()->comment('Foreign key to the companies table');
			$table->unsignedInteger('location_id')->nullable()->index()->comment('Foreign key to the locations table');
			$table->unsignedInteger('status_id')->nullable()->index()->comment('Foreign key to the statuses table');
			$table->unsignedInteger('role_id')->nullable()->index()->comment('Foreign key to the roles table');
			
			$table->rememberToken();
			
			$table->timestamp('last_login_at')->nullable();
			
			$table->timestamps();
		});

		Schema::table('users', function (Blueprint $table) {
			$table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
			$table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
			$table->foreign('status_id')->references('id')->on('statuses')->onDelete('set null');
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}
}
