<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('access_key');
            $table->text('condition')->nullable();
            $table->string('family_member_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('emergency_phone_number')->nullable();
            $table->string('id_card_number')->nullable();
            $table->text('address')->nullable();
            $table->foreignId('room_responsible_nurse_id')->nullable()->constrained('nurses')->onDelete('set null');
            $table->string('room_responsible_nurse_phone')->nullable();
            $table->string('doctor_name')->nullable();
            $table->string('doctor_phone')->nullable();
            $table->text('face_image')->nullable(); // Store base64 image
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};