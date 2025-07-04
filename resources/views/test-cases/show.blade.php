@extends('layouts.app')

@section('title', 'Тест-кейс #' . $testCase->id)

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Тест-кейс #{{ $testCase->id }} - {{ $project->name }}
        </h2>
        <div class="flex space-x-2">
            <a href="{{ route('projects.test-cases.edit', [$project, $testCase]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Редактировать
            </a>
            <a href="{{ route('projects.test-cases.index', $project) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Назад к тест-кейсам
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <!-- Основная информация о тест-кейсе -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Информация о тест-кейсе</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ID:</label>
                        <p class="text-gray-900 bg-gray-50 p-2 rounded">#{{ $testCase->id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Требование:</label>
                        @if($testCase->requirement)
                            <p class="text-gray-900 bg-gray-50 p-2 rounded">
                                <span class="font-medium">#{{ $testCase->requirement->id }}</span> - {{ $testCase->requirement->title }}
                            </p>
                        @else
                            <p class="text-gray-500 bg-gray-50 p-2 rounded italic">Не указано</p>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Автор:</label>
                        <p class="text-gray-900 bg-gray-50 p-2 rounded">{{ $testCase->user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Дата создания:</label>
                        <p class="text-gray-900 bg-gray-50 p-2 rounded">{{ $testCase->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Описание шага -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Описание шага</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $testCase->description }}</p>
                </div>
            </div>

            <!-- Действия -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Действия для выполнения</h3>
                <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-400">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $testCase->actions }}</p>
                </div>
            </div>

            <!-- Ожидаемый результат -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Ожидаемый результат</h3>
                <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-400">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $testCase->expected_result }}</p>
                </div>
            </div>

            <!-- Дополнительная информация -->
            <div class="border-t pt-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Дополнительная информация</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Проект:</span>
                        <span class="text-gray-900">{{ $project->name }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Статус:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Создан
                        </span>
                    </div>
                </div>
            </div>

            <!-- Действия в нижней части -->
            <div class="mt-8 flex justify-between items-center pt-4 border-t">
                <div class="text-sm text-gray-500">
                    Последнее обновление: {{ $testCase->updated_at->diffForHumans() }}
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('projects.test-cases.edit', [$project, $testCase]) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        ✏️ Редактировать
                    </a>
                    <a href="{{ route('projects.test-cases.index', $project) }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        📋 К списку
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
