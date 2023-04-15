<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table -> integer (column:'package_type') -> primary();
            $table -> string (column:'suite_type');
            $table -> string (column:'stay_type');
            $table -> integer (column:'price_per_night');
            $table -> decimal (column:'tax');
            $table -> index ('package_type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
