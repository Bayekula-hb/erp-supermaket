<?php

use App\Models\Establishment;
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
        Schema::create('succursales', function (Blueprint $table) {
            $table->id();
            $table->string('nameSuccursale');
            $table->string('latitudeSuccursale')->nullable();
            $table->string('longitudeSuccursale')->nullable();
            $table->string('address')->default('');
            $table->json('workers')->nullable();
            $table->json('workingDays')->nullable();            
            $table->foreignIdFor(Establishment::class)
                            ->references('id')
                            ->on('establishments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('succursales');
    }
};
