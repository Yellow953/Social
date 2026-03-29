<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add new JSON columns
        Schema::table('courses', function (Blueprint $table) {
            $table->json('years')->nullable()->after('semester');
            $table->json('majors')->nullable()->after('years');
            $table->json('semesters')->nullable()->after('majors');
        });

        // 2. Copy existing single values into arrays
        DB::table('courses')->orderBy('id')->each(function ($row) {
            DB::table('courses')->where('id', $row->id)->update([
                'years'     => json_encode(array_values(array_filter([$row->year]))),
                'majors'    => json_encode(array_values(array_filter([$row->major]))),
                'semesters' => json_encode(array_values(array_filter([$row->semester]))),
            ]);
        });

        // 3. Drop old columns
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['year', 'major', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('major')->nullable()->after('description');
            $table->string('year')->nullable()->after('major');
            $table->string('semester')->default('1')->after('year');
        });

        DB::table('courses')->orderBy('id')->each(function ($row) {
            $years     = json_decode($row->years, true) ?? [];
            $majors    = json_decode($row->majors, true) ?? [];
            $semesters = json_decode($row->semesters, true) ?? [];
            DB::table('courses')->where('id', $row->id)->update([
                'year'     => $years[0] ?? null,
                'major'    => $majors[0] ?? null,
                'semester' => $semesters[0] ?? '1',
            ]);
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['years', 'majors', 'semesters']);
        });
    }
};
