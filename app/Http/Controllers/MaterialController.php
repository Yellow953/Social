<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialAccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Material::with('course')
            ->orderBy('course_id')
            ->orderBy('created_at');

        if ($request->has('course') && $request->course) {
            $query->where('course_id', $request->course);
        }

        $materials = $query->get();

        // Group materials by course
        $groupedMaterials = $materials->groupBy(function ($material) {
            return $material->course->name;
        });

        return view('materials.index', compact('materials', 'groupedMaterials'));
    }

    public function show(Material $material)
    {
        $user = Auth::user();

        if (!$material->canBeAccessedBy($user)) {
            return redirect()->route('materials')
                ->with('error', 'You need an active SOCIALPLUS subscription to access this material.');
        }

        MaterialAccessLog::create([
            'user_id' => $user->id,
            'material_id' => $material->id,
            'accessed_at' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('materials.show', compact('material'));
    }

    /**
     * Return media list for a material (for dynamic loading on show page).
     */
    public function media(Material $material)
    {
        $user = Auth::user();
        if (!$material->canBeAccessedBy($user)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $media = $material->media()->orderBy('order')->get()->map(function ($m) {
            return [
                'id' => $m->id,
                'original_filename' => $m->original_filename,
                'type' => $m->type,
                'formatted_file_size' => $m->formatted_file_size,
                'detail_url' => route('media.detail', $m),
            ];
        });

        return response()->json(['media' => $media]);
    }

    public function updateWatchTime(Request $request, Material $material)
    {
        $user = Auth::user();

        $request->validate([
            'duration_seconds' => 'required|integer|min:0',
        ]);

        $log = MaterialAccessLog::where('user_id', $user->id)
            ->where('material_id', $material->id)
            ->whereDate('accessed_at', today())
            ->first();

        if ($log) {
            $log->update([
                'duration_seconds' => max($log->duration_seconds, $request->duration_seconds),
            ]);
        } else {
            MaterialAccessLog::create([
                'user_id' => $user->id,
                'material_id' => $material->id,
                'accessed_at' => now(),
                'duration_seconds' => $request->duration_seconds,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }

        return response()->json(['success' => true]);
    }
}
