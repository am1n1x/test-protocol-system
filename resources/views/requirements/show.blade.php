@extends('layouts.app')

@section('title', 'Требование: ' . $requirement->title)

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Требование: {{ $requirement->title }}
        </h2>
        <div class="flex space-x-2">
            <a href="{{ route('projects.requirements.edit', [$project, $requirement]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Редактировать
            </a>
            <a href="{{ route('projects.requirements.index', $project) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Назад к требованиям
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <!-- Основная информация о требовании -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Информация о требовании</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Заголовок:</label>
                        <p class="text-gray-900 bg-gray-50 p-2 rounded">{{ $requirement->title }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Автор:</label>
                        <p class="text-gray-900 bg-gray-50 p-2 rounded">{{ $requirement->user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Дата создания:</label>
                        <p class="text-gray-900 bg-gray-50 p-2 rounded">{{ $requirement->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Дата обновления:</label>
                        <p class="text-gray-900 bg-gray-50 p-2 rounded">{{ $requirement->updated_at->format('d.m.Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Описание -->
            @if($requirement->description)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Описание</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-900 whitespace-pre-wrap">{{ $requirement->description }}</p>
                    </div>
                </div>
            @endif

            <!-- Вложения -->
            @if($requirement->attachments && $requirement->attachments->count() > 0)
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-lg font-semibold text-gray-800">Вложения ({{ $requirement->attachments->count() }})</h3>
                        @if($requirement->attachments->count() > 1)
                            <a href="{{ route('requirements.attachments.download-all', $requirement) }}" 
                               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                📦 Скачать все
                            </a>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($requirement->attachments as $attachment)
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium text-gray-900 text-sm truncate">
                                        {{ $attachment->filename }}
                                    </h4>
                                    <span class="text-xs text-gray-500 bg-gray-200 px-2 py-1 rounded">
                                        {{ strtoupper($attachment->filetype ?? 'FILE') }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">
                                        {{ $attachment->created_at->format('d.m.Y H:i') }}
                                    </span>
                                    <a href="{{ route('attachments.download', $attachment) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Скачать
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Дополнительная информация -->
            <div class="border-t pt-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Дополнительная информация</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Проект:</span>
                        <span class="text-gray-900">{{ $project->name }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">ID требования:</span>
                        <span class="text-gray-900">#{{ $requirement->id }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
