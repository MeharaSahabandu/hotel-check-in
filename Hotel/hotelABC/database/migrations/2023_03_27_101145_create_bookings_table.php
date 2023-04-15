<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table -> foreignID(column:'guest_id') -> constrained(table:'guests');
            $table -> foreignID (column:'room_id') -> constrained (table:'rooms');
            $table -> integer('package_type');
            $table -> foreign('package_type')
                ->references('package_type')
                ->on ('packages');
            $table -> dateTime(column:'check_in');
            $table -> dateTime(column:'check_out');
           // $table -> string (column:'status');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
