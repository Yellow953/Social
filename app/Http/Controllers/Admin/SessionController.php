<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoSession;
use App\Models\Course;
use App\Models\SessionMedia;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = VideoSession::with('course')
            ->orderBy('course_id')
            ->orderBy('year')
            ->orderBy('order')
            ->paginate(20);

        return view('admin.sessions.index', compact('sessions'));
    }

    public function create()
    {
        $courses = Course::orderBy('name')->get();
        return view('admin.sessions.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'year' => 'required|string|in:Sup,Spé,1e,2e,3e',
            'is_locked' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'media' => 'nullable|array',
            'media.*' => 'file|mimes:pdf,mp4,webm,ogg,mov,avi,jpg,jpeg,png,gif,webp|max:512000', // 500MB max
        ]);

        $validated['is_locked'] = $request->has('is_locked');

        $session = VideoSession::create($validated);

        // Handle media uploads
        if ($request->hasFile('media')) {
            $this->handleMediaUploads($request, $session);
        }

        // Notify users about new session
        $this->notifyUsersAboutSession($session, 'created');

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Session created successfully.');
    }

    public function edit(VideoSession $session)
    {
        $courses = Course::orderBy('name')->get();
        $session->load('media');
        return view('admin.sessions.edit', compact('session', 'courses'));
    }

    public function update(Request $request, VideoSession $session)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'year' => 'required|string|in:Sup,Spé,1e,2e,3e',
            'is_locked' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['is_locked'] = $request->has('is_locked');

        $session->update($validated);

        // Handle media uploads
        if ($request->hasFile('media')) {
            $this->handleMediaUploads($request, $session);
        }

        // Handle media deletion
        if ($request->has('delete_media')) {
            $this->handleMediaDeletion($request->delete_media);
        }

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Session updated successfully.');
    }

    public function destroy(VideoSession $session)
    {
        // Delete associated media files
        foreach ($session->media as $media) {
            Storage::disk('local')->delete($media->file_path);
        }

        $session->delete();

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Session deleted successfully.');
    }

    /**
     * Handle media file uploads
     */
    private function handleMediaUploads(Request $request, VideoSession $session)
    {
        if (!$request->hasFile('media')) {
            return;
        }

        $files = $request->file('media');
        
        // Ensure files is an array
        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            // Skip invalid files
            if (!$file || !$file->isValid()) {
                continue;
            }

            $extension = strtolower($file->getClientOriginalExtension());
            
            // Determine type from extension
            $type = null;
            if ($extension === 'pdf') {
                $type = 'pdf';
            } elseif (in_array($extension, ['mp4', 'webm', 'ogg', 'mov', 'avi', 'mkv', 'flv'])) {
                $type = 'video';
            } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $type = 'image';
            }

            // Skip if type couldn't be determined
            if (!$type) {
                continue;
            }

            try {
                // Store file in private storage
                $path = $file->store('sessions/media', 'local');
                
                // Get the highest order number for this session
                $maxOrder = $session->media()->max('order') ?? 0;

                // Create media record
                SessionMedia::create([
                    'video_session_id' => $session->id,
                    'type' => $type,
                    'file_path' => $path,
                    'original_filename' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'order' => $maxOrder + 1,
                ]);
            } catch (\Exception $e) {
                continue;
            }
        }
    }

    /**
     * Notify users about session changes
     */
    private function notifyUsersAboutSession(VideoSession $session, string $action = 'created')
    {
        $users = User::where('role', 'user')->get();
        
        $title = $action === 'created' ? 'New Session Available' : 'Session Updated';
        $message = $action === 'created' 
            ? "A new session \"{$session->title}\" has been added to the course \"{$session->course->name}\"."
            : "The session \"{$session->title}\" in course \"{$session->course->name}\" has been updated.";
        
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'type' => 'session',
                'title' => $title,
                'message' => $message,
                'data' => [
                    'session_id' => $session->id,
                    'session_title' => $session->title,
                    'course_id' => $session->course_id,
                    'course_name' => $session->course->name,
                ],
                'read' => false,
            ]);
        }
    }

    /**
     * Handle media deletion
     */
    private function handleMediaDeletion(array $mediaIds)
    {
        foreach ($mediaIds as $mediaId) {
            $media = SessionMedia::find($mediaId);
            if ($media) {
                Storage::disk('local')->delete($media->file_path);
                $media->delete();
            }
        }
    }
}
