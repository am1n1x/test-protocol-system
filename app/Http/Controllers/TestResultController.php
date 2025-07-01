<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestResultController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TestResult $testResult)
    {
        $request->validate([
            'actual_result' => 'nullable|string',
            'status_id' => 'required|exists:statuses,id',
        ]);

        $testResult->update([
            'actual_result' => $request->actual_result,
            'status_id' => $request->status_id,
            'user_id' => Auth::id(), // Update who last modified it
        ]);

        return back()->with('success', 'Результат тестирования обновлен.');
    }
}
