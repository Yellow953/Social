<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create the pivot table
        if (! Schema::hasTable('course_material')) {
            Schema::create('course_material', function (Blueprint $table) {
                $table->foreignId('course_id')->constrained()->onDelete('cascade');
                $table->foreignId('material_id')->constrained()->onDelete('cascade');
                $table->primary(['course_id', 'material_id']);
            });
        }

        // 2. Migrate existing course_id data into the pivot table (skip if column was already dropped)
        if (Schema::hasColumn('materials', 'course_id')) {
            DB::table('materials')
                ->whereNotNull('course_id')
                ->select('id', 'course_id')
                ->orderBy('id')
                ->each(function ($row) {
                    DB::table('course_material')->insertOrIgnore([
                        'course_id'   => $row->course_id,
                        'material_id' => $row->id,
                    ]);
                });
        }

        // 3. Drop the course_id foreign key (if it exists) and column
        if (Schema::hasColumn('materials', 'course_id')) {
            Schema::table('materials', function (Blueprint $table) {
                $fks = collect(DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'materials' AND COLUMN_NAME = 'course_id' AND REFERENCED_TABLE_NAME IS NOT NULL"))
                    ->pluck('CONSTRAINT_NAME');
                if ($fks->isNotEmpty()) {
                    $table->dropForeign($fks->first());
                }
                $table->dropColumn('course_id');
            });
        }
    }

    public function down(): void
    {
        // Re-add course_id (nullable to allow rollback even with multi-course materials)
        Schema::table('materials', function (Blueprint $table) {
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade');
        });

        // Restore first course association for each material
        DB::table('course_material')
            ->orderBy('material_id')
            ->orderBy('course_id')
            ->each(function ($row) {
                DB::table('materials')
                    ->where('id', $row->material_id)
                    ->whereNull('course_id')
                    ->update(['course_id' => $row->course_id]);
            });

        Schema::dropIfExists('course_material');
    }
};
