<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErpStoreStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_store_stock', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            //仓库编号
            $table->integer('stock_no');
            //门店ID
            $table->string('store_id',21);
            //仓库名称
            $table->string('title',100);
            //仓库地址
            $table->string('address',100);;
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_store_stock');
    }
}
