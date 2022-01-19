<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignsZodiaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signs_zodiaks', function (Blueprint $table) {
            $table->id();
            $table->string('name_znak');
            $table->string('image_link',1000);
            $table->date("start_interval_date");
            $table->date("finish_interval_date");
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
        Schema::dropIfExists('signs_zodiaks');
    }
}
