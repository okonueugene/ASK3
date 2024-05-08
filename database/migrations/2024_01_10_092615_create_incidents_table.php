<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable();
            $table->foreignId('site_id')->nullable();
            $table->foreignId('guard_id')->nullable();
            $table->string('incident_no')->nullable();
            $table->string('police_ref')->nullable();
            $table->longText('details')->nullable();
            $table->longText('actions_taken')->nullable();
            $table->string('title')->nullable();
            $table->string('date')->nullable();
            $table->time('time')->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
