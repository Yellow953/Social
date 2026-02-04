<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentManagementController extends Controller
{
    public function index()
    {
        $slides = HomepageSlide::orderBy('order')->orderBy('id')->paginate(20);
        return view('admin.content-management.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.content-management.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'order' => 'nullable|integer|min:0',
        ]);

        $file = $request->file('image');
        $path = $file->store('homepage_slides', 'public');
        $validated['image_path'] = $path;
        $validated['order'] = (int) ($request->input('order', 0));
        unset($validated['image']);

        HomepageSlide::create($validated);

        return redirect()->route('admin.content-management.index')
            ->with('success', 'Slide added successfully.');
    }

    public function edit(HomepageSlide $content_management)
    {
        $slide = $content_management;
        return view('admin.content-management.edit', compact('slide'));
    }

    public function update(Request $request, HomepageSlide $content_management)
    {
        $slide = $content_management;
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['order'] = (int) ($request->input('order', 0));

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($slide->image_path);
            $path = $request->file('image')->store('homepage_slides', 'public');
            $validated['image_path'] = $path;
        }
        unset($validated['image']);

        $slide->update($validated);

        return redirect()->route('admin.content-management.index')
            ->with('success', 'Slide updated successfully.');
    }

    public function destroy(HomepageSlide $content_management)
    {
        $slide = $content_management;
        Storage::disk('public')->delete($slide->image_path);
        $slide->delete();
        return redirect()->route('admin.content-management.index')
            ->with('success', 'Slide deleted successfully.');
    }
}
