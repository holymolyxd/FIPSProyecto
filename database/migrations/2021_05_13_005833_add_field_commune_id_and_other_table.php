<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldCommuneIdAndOtherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('adress')->after('gender_id')->nullable();
            $table->unsignedBigInteger('commune_id')->after('adress')->default(347);
            $table->foreign('commune_id')->references('id')->on('communes');
            $table->unsignedBigInteger('venue_id')->after('commune_id')->default(1);
            $table->foreign('venue_id')->references('id')->on('venues');
            $table->integer('career_id')->after('venue_id')->default(0);
            $table->integer('semester_id')->after('career_id')->default(9);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
