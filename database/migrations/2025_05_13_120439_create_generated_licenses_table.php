<?php

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
        Schema::create('generated_licenses', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('project_name');
            $table->string('author')->nullable();
            $table->foreignIdFor(LicenseTemplate::class)->constrained()->deleteOnCascade();
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generated_licenses');
    }
};
