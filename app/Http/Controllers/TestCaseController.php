<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestCaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $testCases = $project->testCases()->with(['user', 'requirement'])->latest()->get();
        return view('test-cases.index', compact('project', 'testCases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        $requirements = $project->requirements()->get();
        return view('test-cases.create', compact('project', 'requirements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'requirement_id' => 'nullable|exists:requirements,id',
            'description' => 'required|string',
            'actions' => 'required|string',
            'expected_result' => 'required|string',
        ]);

        $project->testCases()->create([
            'requirement_id' => $request->requirement_id,
            'description' => $request->description,
            'actions' => $request->actions,
            'expected_result' => $request->expected_result,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('projects.test-cases.index', $project)
            ->with('success', 'Тест-кейс успешно создан.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, TestCase $testCase)
    {
        $testCase->load(['user', 'requirement']);
        return view('test-cases.show', compact('project', 'testCase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, TestCase $testCase)
    {
        $requirements = $project->requirements()->get();
        return view('test-cases.edit', compact('project', 'testCase', 'requirements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project, TestCase $testCase)
    {
        $request->validate([
            'requirement_id' => 'nullable|exists:requirements,id',
            'description' => 'required|string',
            'actions' => 'required|string',
            'expected_result' => 'required|string',
        ]);

        $testCase->update([
            'requirement_id' => $request->requirement_id,
            'description' => $request->description,
            'actions' => $request->actions,
            'expected_result' => $request->expected_result,
        ]);

        return redirect()->route('projects.test-cases.index', $project)
            ->with('success', 'Тест-кейс успешно обновлен.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, TestCase $testCase)
    {
        $testCase->delete();

        return redirect()->route('projects.test-cases.index', $project)
            ->with('success', 'Тест-кейс успешно удален.');
    }
}
