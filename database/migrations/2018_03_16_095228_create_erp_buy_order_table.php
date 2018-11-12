<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErpBuyOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_buy_order', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('buy_order_no');
            $table->string('title','100');
            $table->integer('supplier_id');

            //总数量
            $table->integer('total_num');
            //总合计
            $table->float('total_amount',10,2);

            $table->integer('pay_method');
            $table->integer('pay_type');
            //状态//0 作废,10 草稿,20 待审,30 已审,40 完成
            $table->integer('status');
            //入库单号
            $table->integer('stock_in_id');
            //付款单号
            $table->integer('pay_order_id');

            //到货仓库
            $table->integer('stock_id');
            //制单人
            $table->integer('create_by');
            //审核人
            $table->integer('verify_by');
            //审核时间
            $table->dateTime('verify_at');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('erp_buy_order_detail', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('buy_order_id');
            $table->integer('product_id');
            $table->string('product_model',255);
            $table->float('price',10,2);
            $table->integer('number');
            $table->float('amount',10,2);

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_buy_order');
        Schema::dropIfExists('erp_buy_order_detail');
    }
}
