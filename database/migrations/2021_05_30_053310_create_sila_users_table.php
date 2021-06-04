<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSilaUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sila_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('handel');
            $table->string('crypto_address');
            $table->date('dob');
            $table->text('private_key');
            $table->text('address');
            $table->boolean('kyc_status')->default(0);
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
        Schema::dropIfExists('sila_users');
    }
}
