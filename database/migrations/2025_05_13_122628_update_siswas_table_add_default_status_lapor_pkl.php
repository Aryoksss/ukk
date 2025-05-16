<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update kolom status_lapor_pkl agar memiliki nilai default '0'
        Schema::table('siswas', function (Blueprint $table) {
            // Update kolom yang sudah ada agar memiliki nilai default
            $table->string('status_lapor_pkl')->default('0')->nullable(false)->change();
        });
        
        // Update semua nilai NULL yang ada menjadi '0'
        DB::table('siswas')
            ->whereNull('status_lapor_pkl')
            ->update(['status_lapor_pkl' => '0']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('status_lapor_pkl')->nullable()->default(null)->change();
        });
    }
};
