<?php
// Migration: 2024_11_28_231246_add_foreign_keys_to_payment_management_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPaymentManagementTable extends Migration
{
    public function up()
    {
        Schema::table('payment_management', function (Blueprint $table) {
            // Thêm khóa ngoại cho user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Thêm khóa ngoại cho order_id
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('payment_management', function (Blueprint $table) {
            // Xóa khóa ngoại nếu cần rollback
            $table->dropForeign(['user_id']);
            $table->dropForeign(['order_id']);
        });
    }
}