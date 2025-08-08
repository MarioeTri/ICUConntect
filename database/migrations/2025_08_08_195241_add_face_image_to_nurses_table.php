<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('nurses', function (Blueprint $table) {
        $table->text('face_image')->nullable()->after('password');
    });
}

public function down(): void
{
    Schema::table('nurses', function (Blueprint $table) {
        $table->dropColumn('face_image');
    });
}
};
