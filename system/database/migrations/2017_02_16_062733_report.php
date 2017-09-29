<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Report extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $exists = false;

        if (Schema::hasTable('report'))
        {
            $exists = true;
        }

        if(!$exists)
        {

            Schema::create('report', function(Blueprint $table)
            {
                $table->increments('report_ID');
                $table->string('user_ID');
                $table->string('type_ID');
                $table->string('approve_ID');
                $table->string('approve_status');
                $table->string('report_Title');
                $table->string('report_Description');
                $table->string('location_ID');
                $table->string('image');
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
        Schema::dropIfExists('report');
    }
}
