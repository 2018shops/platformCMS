<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErpProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_product', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->integer('product_no');
            $table->string('title',100);
            $table->integer('factory_id');
            $table->integer('brand_id');
            //生产日期
            $table->date('product_date');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('erp_product_factory', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->string('title',100);
        });

        Schema::create('erp_product_factory_brand', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->integer('factory_id');
            $table->string('title',100);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_product');
        Schema::dropIfExists('erp_product_factory');
        Schema::dropIfExists('erp_product_factory_brand');
    }
}
