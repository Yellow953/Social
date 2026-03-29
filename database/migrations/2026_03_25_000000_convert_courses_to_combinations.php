<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->json('combinations')->nullable()->after('description');
        });

        // Migrate existing data: cartesian product of each year × semester, with all existing majors
        DB::transaction(function () {
            DB::table('courses')->orderBy('id')->each(function ($course) {
                $years     = json_decode($course->years, true) ?? [];
                $majors    = json_decode($course->majors, true) ?? [];
                $semesters = json_decode($course->semesters, true) ?? [];

                $combinations = [];
                foreach ($years as $year) {
                    foreach ($semesters as $semester) {
                        $combinations[] = [
                            'year'     => $year,
                            'majors'   => empty($majors) ? ['*'] : $majors,
                            'semester' => $semester,
                        ];
                    }
                }

                DB::table('courses')->where('id', $course->id)->update([
                    'combinations' => empty($combinations) ? null : json_encode($combinations),
                ]);
            });
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['years', 'majors', 'semesters']);
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->json('years')->nullable()->after('description');
            $table->json('majors')->nullable()->after('years');
            $table->json('semesters')->nullable()->after('majors');
        });

        // NOTE: down() is best-effort. Combinations encoding more information than flat arrays
        // (e.g., different majors per year/semester pair) cannot be perfectly restored to flat arrays.
        DB::transaction(function () {
            DB::table('courses')->orderBy('id')->each(function ($course) {
                $combinations = json_decode($course->combinations, true) ?? [];
                $years     = collect($combinations)->pluck('year')->unique()->values()->all();
                $semesters = collect($combinations)->pluck('semester')->unique()->values()->all();
                $majors    = collect($combinations)
                    ->flatMap(fn($c) => $c['majors'])
                    ->filter(fn($m) => $m !== '*')
                    ->unique()->values()->all();

                DB::table('courses')->where('id', $course->id)->update([
                    'years'     => json_encode($years),
                    'majors'    => json_encode($majors),
                    'semesters' => json_encode($semesters),
                ]);
            });
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('combinations');
        });
    }
};
