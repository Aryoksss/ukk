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
        DB::unprepared("
            CREATE FUNCTION getRombelCode(code CHAR(1))
            RETURNS VARCHAR(20)
            DETERMINISTIC
            BEGIN
                RETURN CASE
                    WHEN code = 'A' THEN 'SIJA A'
                    WHEN code = 'B' THEN 'SIJA B'
                    ELSE 'Tidak diketahui'
                END;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP FUNCTION IF EXISTS getRombelCode");
    }
};
