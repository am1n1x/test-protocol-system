@extends('layouts.app')

@section('title', 'Редактировать тест-кейс')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Редактировать тест-кейс #{{ $testCase->id }} - {{ $project->name }}
        </h2>
        <a href="{{ route('projects.test-cases.index', $project) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Назад к тест-кейсам
        </a>
    </div>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form action="{{ route('projects.test-cases.update', [$project, $testCase]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">
                        Описание шага *
                    </label>
                    <textarea name="description" id="description" rows="3" 
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror"
                              placeholder="Введите описание шага тестирования" required>{{ old('description', $testCase->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="actions" class="block text-gray-700 text-sm font-bold mb-2">
                        Действия в системе *
                    </label>
                    <textarea name="actions" id="actions" rows="3" 
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('actions') border-red-500 @enderror"
                              placeholder="Введите действия, которые нужно выполнить" required>{{ old('actions', $testCase->actions) }}</textarea>
                    @error('actions')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="expected_result" class="block text-gray-700 text-sm font-bold mb-2">
                        Ожидаемый результат *
                    </label>
                    <textarea name="expected_result" id="expected_result" rows="3" 
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('expected_result') border-red-500 @enderror"
                              placeholder="Введите ожидаемый результат" required>{{ old('expected_result', $testCase->expected_result) }}</textarea>
                    @error('expected_result')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Информация о тест-кейсе -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Информация о тест-кейсе</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-600">ID:</span>
                            <span class="text-gray-900">#{{ $testCase->id }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Автор:</span>
                            <span class="text-gray-900">{{ $testCase->user->name }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Создан:</span>
                            <span class="text-gray-900">{{ $testCase->created_at->format('d.m.Y') }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Обновлен:</span>
                            <span class="text-gray-900">{{ $testCase->updated_at->format('d.m.Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Сохранить изменения
                    </button>
                    <div class="flex space-x-2">
                        <a href="{{ route('projects.test-cases.show', [$project, $testCase]) }}" class="inline-block align-baseline font-bold text-sm text-green-600 hover:text-green-800">
                            Просмотр
                        </a>
                        <a href="{{ route('projects.test-cases.index', $project) }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Отмена
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
