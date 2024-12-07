<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUserIdTypeInPaymentManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_management', function (Blueprint $table) {
            // Thay đổi kiểu dữ liệu của cột user_id thành unsignedBigInteger
            $table->unsignedBigInteger('user_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_management', function (Blueprint $table) {
            // Khôi phục lại kiểu dữ liệu của cột user_id nếu rollback
            $table->integer('user_id')->change();
        });
    }
}