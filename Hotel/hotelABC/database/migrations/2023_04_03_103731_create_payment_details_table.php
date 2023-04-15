<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table -> integer ('package_type');
            $table -> foreign ('package_type')
            ->references ('package_type')
            ->on ('packages');
            $table -> foreignID (column : 'booking_id') -> constrained (table : 'bookings');
            $table -> double ('subtotal');
            $table -> double ('tax');
            $table -> double ('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_details');
    }
};
