<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReportType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         $exists = false;

        if (Schema::hasTable('report_type'))
        {
            $exists = true;
        }

        if(!$exists)
        {

            Schema::create('report_type', function(Blueprint $table)
            {
                $table->increments('typeID');
                $table->string('typeName');
                $table->string('isAutoReport');
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
        Schema::dropIfExists('report_type');
    }
}
