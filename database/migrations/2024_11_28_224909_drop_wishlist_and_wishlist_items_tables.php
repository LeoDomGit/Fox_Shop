<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropWishlistAndWishlistItemsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Kiểm tra và xoá ràng buộc khóa ngoại nếu bảng tồn tại
        if (Schema::hasTable('wishlist_item')) {
            Schema::table('wishlist_item', function (Blueprint $table) {
                $table->dropForeign(['id_wishlist']); // Xoá ràng buộc khóa ngoại
            });

            // Xoá bảng wishlist_item
            Schema::dropIfExists('wishlist_item');
        }

        // Xoá bảng wishlist nếu tồn tại
        Schema::dropIfExists('wishlist');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Khôi phục bảng wishlist
        Schema::create('wishlist', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->index(); // Ví dụ: cột user_id
            $table->timestamps();
        });

        // Khôi phục bảng wishlist_item
        Schema::create('wishlist_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_wishlist')->index();
            $table->unsignedBigInteger('id_product')->index(); // Ví dụ: cột id_product
            $table->integer('quantity')->default(1); // Ví dụ: cột quantity
            $table->timestamps();

            // Khôi phục ràng buộc khóa ngoại
            $table->foreign('id_wishlist')->references('id')->on('wishlist')->onDelete('cascade');
        });
    }
}