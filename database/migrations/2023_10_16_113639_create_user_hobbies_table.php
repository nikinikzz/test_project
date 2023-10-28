<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_hobbies', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('profile_id')->unsigned();
            $table->BigInteger('hobby_id')->unsigned();
            $table->timestamps();
            $table->foreign('profile_id')->references('id')->on('profiles');

            $table->foreign('hobby_id')->references('id')->on('hobbies');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_hobbies');
    }
};
