<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->bigIncrements('id');
            $table->bigInteger('category_id')->unsigned();
            $table->string('description');
            $table->string('description_large')->nullable()->default('NULL');
            $table->integer('qty')->default(0);
            $table->decimal('price', 18, 9)->default(0);
            $table->bigInteger('tax_id')->unsigned();
            $table->bigInteger('discount_id')->unsigned();
            $table->string('reference')->nullable()->default('NULL');
            $table->tinyInteger('configurable_product')->default(0);
            $table->string('photo')->nullable()->default('NULL');
            $table->tinyInteger('is_activated')->default(1);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references("id")->on("category");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('product');
    }
};
