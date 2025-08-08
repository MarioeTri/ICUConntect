<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('family_member_name')->nullable()->after('condition');
            $table->string('phone_number')->nullable()->after('family_member_name');
            $table->string('emergency_phone_number')->nullable()->after('phone_number');
            $table->string('id_card_number')->nullable()->after('emergency_phone_number');
            $table->text('address')->nullable()->after('id_card_number');
            $table->string('room_responsible_person')->nullable()->after('address');
            $table->string('room_responsible_phone')->nullable()->after('room_responsible_person');
            $table->string('doctor_name')->nullable()->after('room_responsible_phone');
            $table->string('doctor_phone')->nullable()->after('doctor_name');
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['family_member_name', 'phone_number', 'emergency_phone_number', 'id_card_number', 'address', 'room_responsible_person', 'room_responsible_phone', 'doctor_name', 'doctor_phone']);
        });
    }
};