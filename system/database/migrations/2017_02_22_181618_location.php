<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Location extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $exists = false;

        if (Schema::hasTable('location'))
        {
            $exists = true;
        }

        if(!$exists)
        {

            Schema::create('location', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('location_name');
                $table->string('location_latitute');
                $table->string('location_longitute');
                $table->timestamps();
            });

        }  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location');
    }
}
