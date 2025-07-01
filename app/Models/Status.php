<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    /**
     * Get the test protocols with this status.
     */
    public function testProtocols(): HasMany
    {
        return $this->hasMany(TestProtocol::class);
    }

    /**
     * Get the test results with this status.
     */
    public function testResults(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }
}
