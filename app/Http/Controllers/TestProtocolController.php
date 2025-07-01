<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\TestProtocol;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestProtocolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $testProtocols = $project->testProtocols()->with('user', 'status')->latest()->get();
        return view('test-protocols.index', compact('project', 'testProtocols'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $testProtocol = DB::transaction(function () use ($project) {
            // Create new test protocol with default "Not Tested" status
            $testProtocol = $project->testProtocols()->create([
                'user_id' => Auth::id(),
                'status_id' => 1, // "Не протестировано"
            ]);

            // Get all test cases for this project
            $testCases = $project->testCases;

            // Create test results for each test case
            foreach ($testCases as $testCase) {
                $testProtocol->testResults()->create([
                    'test_case_id' => $testCase->id,
                    'user_id' => Auth::id(),
                    'status_id' => 1, // "Не протестировано"
                    'actual_result' => null,
                ]);
            }

            return $testProtocol;
        });

        return redirect()->route('test-protocols.show', $testProtocol)
            ->with('success', 'Протокол тестирования создан.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TestProtocol $testProtocol)
    {
        $testProtocol->load([
            'project',
            'user',
            'status',
            'testResults.testCase',
            'testResults.user',
            'testResults.status'
        ]);

        $statuses = Status::all();

        return view('test-protocols.show', compact('testProtocol', 'statuses'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, TestProtocol $testProtocol)
    {
        $testProtocol->delete();

        return redirect()->route('projects.test-protocols.index', $project)
            ->with('success', 'Протокол тестирования удален.');
    }
}
