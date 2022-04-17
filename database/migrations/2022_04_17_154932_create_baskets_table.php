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
            $table->integer("itemsCount")->default(1);
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
