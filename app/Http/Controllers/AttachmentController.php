<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Requirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class AttachmentController extends Controller
{
    /**
     * Download attachment file
     */
    public function download(Attachment $attachment): BinaryFileResponse
    {
        // Check if user has access to this attachment
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        // Check if file exists in storage (files are stored in public disk)
        if (!Storage::disk('public')->exists($attachment->path)) {
            abort(404, 'File not found');
        }

        // Return file download response
        return response()->download(
            Storage::disk('public')->path($attachment->path), 
            $attachment->filename
        );
    }

    /**
     * Download all attachments for a requirement as a ZIP file
     */
    public function downloadAll(Requirement $requirement): BinaryFileResponse
    {
        // Check if user has access
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        // Check if requirement has attachments
        if ($requirement->attachments->count() === 0) {
            abort(404, 'No attachments found');
        }

        // Create temporary ZIP file
        $zipFileName = 'requirement_' . $requirement->id . '_attachments_' . date('Y-m-d_H-i-s') . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);
        
        // Create temp directory if it doesn't exist
        if (!is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) !== TRUE) {
            abort(500, 'Cannot create ZIP file');
        }

        // Add each attachment to the ZIP
        foreach ($requirement->attachments as $attachment) {
            $filePath = Storage::disk('public')->path($attachment->path);
            if (file_exists($filePath)) {
                $zip->addFile($filePath, $attachment->filename);
            }
        }

        $zip->close();

        // Return ZIP file download and delete after sending
        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend();
    }

    /**
     * Delete attachment file
     */
    public function destroy(Attachment $attachment)
    {
        // Check if user has access
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        // Delete file from storage
        if (Storage::disk('public')->exists($attachment->path)) {
            Storage::disk('public')->delete($attachment->path);
        }

        // Delete record from database
        $attachment->delete();

        return response()->json(['success' => true]);
    }
}
