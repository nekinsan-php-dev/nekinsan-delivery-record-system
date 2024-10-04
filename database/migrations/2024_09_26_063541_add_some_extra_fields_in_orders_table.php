<?php

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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('scanned_at')->nullable()->after('barcode');
            $table->string('rto_remark')->nullable()->after('scanned_at');
            $table->foreignId('assigned_by')->nullable()->constrained('users')->after('rto_remark');
            $table->foreignId('created_by')->constrained('users')->after('update_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('scanned_at');
        });
    }
};
