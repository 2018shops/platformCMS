<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErpCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('erp_customer');
        Schema::create('erp_customer', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('customer_no') ;
            $table->string('name','20');
            $table->string('mobile','11');
            $table->string('email','50');


            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });

        Schema::dropIfExists('erp_leads');
        Schema::create('erp_leads', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('customer_id') ;
            $table->string('title','100');

            $table->integer('product_id');
            $table->date('purpose_at');

            $table->integer('owner_id');
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('erp_customer');
        Schema::dropIfExists('erp_leads');

    }
}
