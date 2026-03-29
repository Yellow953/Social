<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\HomepageSlide;
use Inertia\Inertia;
use Inertia\Response;

class WelcomeController extends Controller
{
    public function home(): Response
    {
        $homepageSlides = HomepageSlide::orderBy('order')->orderBy('id')->get()
            ->map(fn ($s) => [
                'id' => $s->id,
                'image_url' => asset('storage/' . $s->image_path) . '?v=' . $s->id,
                'title' => $s->title,
                'description' => $s->description,
            ])
            ->values()
            ->toArray();

        return Inertia::render('Welcome', ['page' => 'home', 'homepageSlides' => $homepageSlides]);
    }

    public function about(): Response
    {
        return Inertia::render('Welcome', ['page' => 'about']);
    }

    public function academique(): Response
    {
        $yearOrder = ['Sup', 'Spé', '1e', '2e', '3e'];
        $allCombinations = Course::pluck('combinations')->flatten(1);
        $existingYears = $allCombinations->pluck('year')->unique()->flip();
        $years = collect($yearOrder)->filter(fn($y) => $existingYears->has($y))->values();
        $majors = $allCombinations
            ->flatMap(fn($c) => $c['majors'] ?? [])
            ->filter(fn($m) => $m !== '*')
            ->unique()->sort()->values();

        return Inertia::render('Welcome', [
            'page'   => 'academique',
            'years'  => $years,
            'majors' => $majors,
        ]);
    }

    public function calculatrice(): Response
    {
        return Inertia::render('Welcome', ['page' => 'calculatrice']);
    }
}
