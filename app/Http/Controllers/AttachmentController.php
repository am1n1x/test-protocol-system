<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AttachmentController extends Controller
{
    /**
     * Download attachment file
     */
    public function download(Attachment $attachment): BinaryFileResponse
    {
        // Check if user has access to this attachment
        // This is a basic check - you might want to implement more sophisticated access control
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
}
