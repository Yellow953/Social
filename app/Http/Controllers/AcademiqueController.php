<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Material;
use Illuminate\Http\Request;

class AcademiqueController extends Controller
{
    /**
     * Show the academique page (Year → Course → Material).
     */
    public function index()
    {
        return view('academique.index', [
            'materialsUrl' => url('/materials'),
        ]);
    }

    /**
     * Return distinct years that have courses (for the 5-year selector).
     */
    public function years(Request $request)
    {
        $order = ['Sup' => 0, 'Spé' => 1, '1e' => 2, '2e' => 3, '3e' => 4];
        $years = Course::whereNotNull('year')
            ->where('year', '!=', '')
            ->distinct()
            ->pluck('year')
            ->sortBy(fn ($y) => $order[$y] ?? 99)
            ->values();

        // If no courses have year set, return the 5 standard years
        if ($years->isEmpty()) {
            $years = collect(['Sup', 'Spé', '1e', '2e', '3e']);
        }

        return response()->json(['years' => $years->toArray()]);
    }

    /**
     * Return courses for a given year.
     */
    public function courses(Request $request)
    {
        $request->validate(['year' => 'required|string|max:50']);

        $courses = Course::where('year', $request->year)
            ->orderBy('name')
            ->get(['id', 'name', 'code', 'year']);

        return response()->json(['courses' => $courses]);
    }

    /**
     * Return materials (previews) for a given course. Includes access info for current user.
     */
    public function materials(Request $request)
    {
        $request->validate(['course_id' => 'required|integer|exists:courses,id']);

        $user = $request->user();
        $materials = Material::where('course_id', $request->course_id)
            ->with('media:id,material_id,type')
            ->orderBy('created_at')
            ->get()
            ->map(function ($material) use ($user) {
                $mediaSummary = $material->media->groupBy('type')->map->count()->all();
                return [
                    'id' => $material->id,
                    'title' => $material->title,
                    'description' => $material->description,
                    'type' => $material->type,
                    'is_locked' => $material->is_locked,
                    'can_access' => $material->canBeAccessedBy($user),
                    'media_summary' => $mediaSummary, // e.g. ['pdf' => 2, 'video' => 1, 'image' => 3]
                ];
            });

        return response()->json(['materials' => $materials]);
    }
}
