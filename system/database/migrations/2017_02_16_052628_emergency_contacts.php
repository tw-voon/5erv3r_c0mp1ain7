<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmergencyContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $exists = false;

        if (Schema::hasTable('emergency_contact'))
        {
            $exists = true;
        }

        if(!$exists)
        {

            Schema::create('emergency_contact', function(Blueprint $table)
            {
                $table->increments('contact_id');
                $table->string('contact_name');
                $table->string('contact_number');
                $table->string('contact_description');
                $table->string('status');
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
        Schema::dropIfExists('emergency_contact');
    }
}
