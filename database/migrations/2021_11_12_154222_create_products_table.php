<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('status')->nullable()->default(1);
            $table->text('description')->nullable();
            $table->double('price', 15, 2)->default(0.0);
            $table->string('image')->nullable();
            $table->string('image_filename')->nullable();
            $table->integer('category_id')->default(0)->nullable();
            $table->string('mask');
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
        Schema::dropIfExists('products');
    }
}
