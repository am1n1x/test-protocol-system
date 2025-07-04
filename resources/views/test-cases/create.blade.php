@extends('layouts.app')

@section('title', 'Создать тест-кейс')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Создать тест-кейс - {{ $project->name }}
        </h2>
        <a href="{{ route('projects.test-cases.index', $project) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Назад к тест-кейсам
        </a>
    </div>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form action="{{ route('projects.test-cases.store', $project) }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="requirement_id" class="block text-gray-700 text-sm font-bold mb-2">
                        Требование
                    </label>
                    <select name="requirement_id" id="requirement_id" 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('requirement_id') border-red-500 @enderror">
                        <option value="">-- Выберите требование (необязательно) --</option>
                        @foreach($requirements as $requirement)
                            <option value="{{ $requirement->id }}" {{ old('requirement_id') == $requirement->id ? 'selected' : '' }}>
                                #{{ $requirement->id }} - {{ $requirement->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('requirement_id')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">
                        Описание шага *
                    </label>
                    <textarea name="description" id="description" rows="3" 
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror"
                              placeholder="Введите описание шага тестирования" required>{{ old('description') }}</textarea>
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
                              placeholder="Введите действия, которые нужно выполнить" required>{{ old('actions') }}</textarea>
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
                              placeholder="Введите ожидаемый результат" required>{{ old('expected_result') }}</textarea>
                    @error('expected_result')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Создать тест-кейс
                    </button>
                    <a href="{{ route('projects.test-cases.index', $project) }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
