<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->string('username'); // Username
            $table->unsignedBigInteger('product_id'); // Product ID
            $table->integer('rating')->check('rating >= 1 and rating <= 5'); // Rating between 1 and 5
            $table->text('comment')->nullable(); // Optional comment
            $table->timestamps(); // Created at and Updated at

            // Foreign key constraints
            $table->foreign('username')->references('username')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rates');
    }
}

