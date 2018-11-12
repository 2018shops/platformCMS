<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErpStoreEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_store_employee', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            //门店编号
            $table->integer('employee_no');
            $table->string('store_id',21);
            //员工姓名
            $table->string('name',100);
            //员工手机号
            $table->string('mobile',11);
            //登录账号
            $table->integer('user_id');
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
        Schema::dropIfExists('erp_store_employee');
    }
}
