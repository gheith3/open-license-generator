<?php

use App\Models\Option;
use App\Models\LicenseTemplate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('option_license_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Option::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(LicenseTemplate::class)->constrained()->cascadeOnDelete();
            $table->integer('score')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('option_license_scores');
    }
};
