<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestProtocol extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'status_id',
    ];

    /**
     * Get the project that owns the test protocol.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user that created the test protocol.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the status of the test protocol.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Get the test results for the test protocol.
     */
    public function testResults(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }
}
