@extends('layouts.app')

@section('title', 'Создать требование')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Создать требование - {{ $project->name }}
        </h2>
        <a href="{{ route('projects.requirements.index', $project) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Назад к требованиям
        </a>
    </div>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form action="{{ route('projects.requirements.store', $project) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">
                        Заголовок требования *
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror"
                           placeholder="Введите заголовок требования" required>
                    @error('title')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">
                        Описание
                    </label>
                    <textarea name="description" id="description" rows="4" 
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror"
                              placeholder="Введите описание требования">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="attachments" class="block text-gray-700 text-sm font-bold mb-2">
                        Файлы (необязательно)
                    </label>
                    <input type="file" name="attachments[]" id="attachments" multiple 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('attachments.*') border-red-500 @enderror"
                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.txt">
                    <p class="text-gray-600 text-xs mt-1">
                        Можно выбрать несколько файлов. Максимальный размер файла: 10MB
                    </p>
                    @error('attachments.*')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Создать требование
                    </button>
                    <a href="{{ route('projects.requirements.index', $project) }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
