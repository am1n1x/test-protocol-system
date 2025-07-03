<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Requirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $requirements = $project->requirements()->with('user', 'attachments')->latest()->get();
        return view('requirements.index', compact('project', 'requirements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        return view('requirements.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attachments.*' => 'nullable|file|max:10240', // 10MB max per file
        ]);

        $requirement = $project->requirements()->create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        // Handle file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                
                $requirement->attachments()->create([
                    'path' => $path,
                    'filename' => $file->getClientOriginalName(),
                    'filetype' => $file->getMimeType(),
                ]);
            }
        }

        return redirect()->route('projects.requirements.index', $project)
            ->with('success', 'Требование успешно создано.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Requirement $requirement)
    {
        $requirement->load('attachments', 'user');
        return view('requirements.show', compact('project', 'requirement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Requirement $requirement)
    {
        $requirement->load('attachments');
        return view('requirements.edit', compact('project', 'requirement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project, Requirement $requirement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attachments.*' => 'nullable|file|max:10240',
        ]);

        $requirement->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // Handle new file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                
                $requirement->attachments()->create([
                    'path' => $path,
                    'filename' => $file->getClientOriginalName(),
                    'filetype' => $file->getMimeType(),
                ]);
            }
        }

        return redirect()->route('projects.requirements.index', $project)
            ->with('success', 'Требование успешно обновлено.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Requirement $requirement)
    {
        // Delete associated files
        foreach ($requirement->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->path);
        }

        $requirement->delete();

        return redirect()->route('projects.requirements.index', $project)
            ->with('success', 'Требование успешно удалено.');
    }

    /**
     * Delete a specific attachment.
     */
    public function deleteAttachment(Project $project, Requirement $requirement, $attachmentId)
    {
        $attachment = $requirement->attachments()->findOrFail($attachmentId);
        Storage::disk('public')->delete($attachment->path);
        $attachment->delete();

        return back()->with('success', 'Файл успешно удален.');
    }
}
