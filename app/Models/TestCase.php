<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'description',
        'actions',
        'expected_result',
    ];

    /**
     * Get the project that owns the test case.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user that created the test case.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
