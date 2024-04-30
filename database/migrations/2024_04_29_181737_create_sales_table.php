<?php

use App\Models\Stock;
use App\Models\Succursale;
use App\Models\User;
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
        Schema::create('sales', function (Blueprint $table) {

            $table->id();
            $table->integer('quantity');            
            $table->foreignIdFor(User::class)
                ->references('id')
                ->on('users');
            $table->foreignIdFor(Succursale::class)
                ->references('id')
                ->on('succursales');
            $table->foreignIdFor(Stock::class)
                ->references('id')
                ->on('stocks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
