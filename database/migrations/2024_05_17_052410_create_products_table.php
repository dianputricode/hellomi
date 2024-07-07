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
            $table->id(); // Auto-increment ID
            $table->string('product_name');
            $table->string('product_image');
            $table->decimal('price', 10, 2);
            $table->string('material')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('capacity')->nullable();
            $table->string('weight')->nullable();
            $table->integer('stock')->default(0);
            $table->decimal('average_rating', 2, 1)->nullable();
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

