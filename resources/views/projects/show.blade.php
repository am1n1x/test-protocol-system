@extends('layouts.app')

@section('title', $project->name)

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $project->name }}
            </h2>
            <p class="text-gray-600 mt-1">{{ $project->description }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('projects.edit', $project) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Редактировать
            </a>
            <a href="{{ route('projects.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Назад к проектам
            </a>
        </div>
    </div>
@endsection

@section('content')
    <!-- Navigation tabs -->
    <div class="mb-6">
        <nav class="flex space-x-8" aria-label="Tabs">
            <a href="{{ route('projects.requirements.index', $project) }}" 
               class="text-gray-500 hover:text-gray-700 px-3 py-2 font-medium text-sm rounded-md 
                      {{ request()->routeIs('projects.requirements.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                Требования
            </a>
            <a href="{{ route('projects.test-cases.index', $project) }}" 
               class="text-gray-500 hover:text-gray-700 px-3 py-2 font-medium text-sm rounded-md
                      {{ request()->routeIs('projects.test-cases.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                Тест-кейсы
            </a>
            <a href="{{ route('projects.test-protocols.index', $project) }}" 
               class="text-gray-500 hover:text-gray-700 px-3 py-2 font-medium text-sm rounded-md
                      {{ request()->routeIs('projects.test-protocols.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                Протоколы тестирования
            </a>
        </nav>
    </div>

    <!-- Project overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Требования</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $project->requirements()->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('projects.requirements.index', $project) }}" class="font-medium text-blue-700 hover:text-blue-900">
                        Просмотреть все
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Тест-кейсы</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $project->testCases()->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('projects.test-cases.index', $project) }}" class="font-medium text-green-700 hover:text-green-900">
                        Просмотреть все
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Протоколы</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $project->testProtocols()->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('projects.test-protocols.index', $project) }}" class="font-medium text-purple-700 hover:text-purple-900">
                        Просмотреть все
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick actions -->
    <div class="mt-8 bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Быстрые действия</h3>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('projects.requirements.create', $project) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Добавить требование
                </a>
                <a href="{{ route('projects.test-cases.create', $project) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                    Добавить тест-кейс
                </a>
                @if($project->testCases()->count() > 0)
                    <form action="{{ route('projects.test-protocols.store', $project) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                            Создать протокол тестирования
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
