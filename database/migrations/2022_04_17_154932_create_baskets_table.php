<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Basket', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("userID");
            $table->unsignedBigInteger("productID");
            $table->unsignedBigInteger("statusID");
            /** 
             * 
             * When adding a product to the cart this column will be null
             * When removing a product from the cart, this column will reference the row that recorded the cart addition. Hence we'll be able to track which cart addition was removed by verifying if the addition record has removal reference
             * For buying status, it's the same as removing but since the buy feature won't be implemented no need for saying more...
             */
            $table->unsignedBigInteger("siblingID")->nullable()->comment("This column helps in tracking the cart addition entry that was removed or bought afterwards.");
            $table->integer("itemsCount")->nullable();
            $table->integer("created_at");
            $table->integer("updated_at");

            $table->foreign("userID")->references("id")->on("users")
            ->onUpdate("cascade")
            ->onDelete("restrict");

            $table->foreign("productID")->references("id")->on("Product")
            ->onUpdate("cascade")
            ->onDelete("restrict");

            $table->foreign("statusID")->references("id")->on("BasketStatus")
            ->onUpdate("cascade")
            ->onDelete("restrict");

            $table->foreign("siblingID")->references("id")->on("Basket")
            ->onUpdate("cascade")
            ->onDelete("restrict");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Basket');
    }
};
