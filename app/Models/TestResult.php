<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_protocol_id',
        'test_case_id',
        'user_id',
        'status_id',
        'actual_result',
    ];

    /**
     * Get the test protocol that owns the test result.
     */
    public function testProtocol(): BelongsTo
    {
        return $this->belongsTo(TestProtocol::class);
    }

    /**
     * Get the test case that owns the test result.
     */
    public function testCase(): BelongsTo
    {
        return $this->belongsTo(TestCase::class);
    }

    /**
     * Get the user that tested the result.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the status of the test result.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
