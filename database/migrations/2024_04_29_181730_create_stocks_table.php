<?php

use App\Models\Product;
use App\Models\Succursale;
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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->double('price');
            $table->dateTime('expiryDate')->nullable();            
            $table->foreignIdFor(Product::class)
                            ->references('id')
                            ->on('products');            
            $table->foreignIdFor(Succursale::class)
                            ->references('id')
                            ->on('succursales');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
