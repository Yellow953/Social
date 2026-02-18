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
        return view('academique.index', [
            'materialsUrl' => url('/materials'),
            'majors' => config('majors'),
        ]);
    }

    /**
     * Return all standard years (always show all 5, even with no courses).
     */
    public function years(Request $request)
    {
        $years = ['Sup', 'Spé', '1e', '2e', '3e'];
        return response()->json(['years' => $years]);
    }

    /**
     * Return courses for a given year, major and semester. Only courses matching all are returned.
     */
    public function courses(Request $request)
    {
        $request->validate([
            'year' => 'required|string|max:50',
            'major' => 'required|string|max:255',
            'semester' => 'required|string|in:1,2',
        ]);

        $courses = Course::where('year', $request->year)
            ->where('major', $request->major)
            ->where('semester', $request->semester)
            ->orderBy('name')
            ->get(['id', 'name', 'code', 'year', 'major', 'semester']);

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
