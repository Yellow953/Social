<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Material;
use Illuminate\Http\Request;

class AcademiqueController extends Controller
{
    /**
     * Show the academique page (Year → Major → Course → Material).
     */
    public function index()
    {
        $user = auth()->user();

        return view('academique.index', [
            'materialsUrl' => url('/materials'),
            'majors'       => config('majors'),
            'userYear'     => $user->study_year,
            'userMajor'    => $user->major,
        ]);
    }

    /**
     * Return all standard years.
     */
    public function years(Request $request)
    {
        return response()->json(['years' => ['Sup', 'Spé', '1e', '2e', '3e']]);
    }

    /**
     * Return courses for a given year, major and semester. Only courses matching all are returned.
     * Non-subscribed users only see courses that have at least one unlocked material.
     */
    public function courses(Request $request)
    {
        $request->validate([
            'year' => 'required|string|max:50',
            'major' => 'required|string|max:255',
            'semester' => 'required|string|in:1,2',
        ]);

        $year     = $request->year;
        $major    = $request->major;
        $semester = $request->semester;

        $user = auth()->user();

        $courses = Course::orderBy('name')
            ->get(['id', 'name', 'code', 'combinations'])
            ->filter(fn($c) => $c->matchesFilter($year, $major, $semester))
            ->map(fn($c) => ['id' => $c->id, 'name' => $c->name, 'code' => $c->code, 'is_extra' => false]);

        $extraCourses = $user->extraCourses()
            ->orderBy('name')
            ->get(['courses.id', 'courses.name', 'courses.code'])
            ->map(fn($c) => ['id' => $c->id, 'name' => $c->name, 'code' => $c->code, 'is_extra' => true]);

        $merged = $courses->keyBy('id')
            ->merge($extraCourses->keyBy('id'))
            ->values();

        return response()->json(['courses' => $merged]);
    }

    /**
     * Return materials (previews) for a given course.
     * Only returns materials the current user can actually access.
     */
    public function materials(Request $request)
    {
        $request->validate(['course_id' => 'required|integer|exists:courses,id']);

        $user = $request->user();
        $materials = Material::whereHas('courses', fn ($q) => $q->where('courses.id', $request->course_id))
            ->with('media:id,material_id,type')
            ->orderBy('created_at')
            ->get()
            ->filter(fn ($material) => $material->canBeAccessedBy($user))
            ->map(function ($material) use ($user) {
                $mediaSummary = $material->media->groupBy('type')->map->count()->all();
                return [
                    'id'            => $material->id,
                    'title'         => $material->title,
                    'description'   => $material->description,
                    'type'          => $material->type,
                    'is_locked'     => $material->is_locked,
                    'can_access'    => true, // only accessible materials are returned
                    'media_summary' => $mediaSummary,
                ];
            })
            ->values();

        return response()->json(['materials' => $materials]);
    }
}
