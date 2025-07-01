<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'requirement_id',
        'path',
        'filename',
        'filetype',
    ];

    /**
     * Get the requirement that owns the attachment.
     */
    public function requirement(): BelongsTo
    {
        return $this->belongsTo(Requirement::class);
    }
}
