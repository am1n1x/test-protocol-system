@extends('layouts.app')

@section('title', 'Протоколы тестирования - ' . $project->name)

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Протоколы тестирования - {{ $project->name }}
            </h2>
        </div>
        <div class="flex space-x-2">
            @if($project->testCases()->count() > 0)
                <form action="{{ route('projects.test-protocols.store', $project) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                        Создать новый протокол
                    </button>
                </form>
            @endif
            <a href="{{ route('projects.show', $project) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Назад к проекту
            </a>
        </div>
    </div>
@endsection

@section('content')
    @if($project->testCases()->count() == 0)
        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">
                        Необходимы тест-кейсы
                    </h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>Прежде чем создавать протокол тестирования, необходимо добавить хотя бы один тест-кейс в проект.</p>
                    </div>
                    <div class="mt-4">
                        <div class="-mx-2 -my-1.5 flex">
                            <a href="{{ route('projects.test-cases.create', $project) }}" class="bg-yellow-50 px-2 py-1.5 rounded-md text-sm font-medium text-yellow-800 hover:bg-yellow-100">
                                Добавить тест-кейс
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        @if($testProtocols->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Создан
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Автор
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Статус
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Прогресс
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Действия
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($testProtocols as $protocol)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $protocol->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $protocol->created_at->format('d.m.Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $protocol->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'Не протестировано' => 'bg-gray-100 text-gray-800',
                                            'Пройден' => 'bg-green-100 text-green-800',
                                            'Провален' => 'bg-red-100 text-red-800',
                                            'Пропущен' => 'bg-yellow-100 text-yellow-800',
                                        ];
                                        $colorClass = $statusColors[$protocol->status->name] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $colorClass }}">
                                        {{ $protocol->status->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @php
                                        $total = $protocol->testResults->count();
                                        $completed = $protocol->testResults->where('status_id', '!=', 1)->count();
                                        $percentage = $total > 0 ? round(($completed / $total) * 100) : 0;
                                    @endphp
                                    <div class="flex items-center">
                                        <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="text-xs">{{ $completed }}/{{ $total }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('test-protocols.show', $protocol) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                        Выполнить тест
                                    </a>
                                    <form action="{{ route('projects.test-protocols.destroy', [$project, $protocol]) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Вы уверены, что хотите удалить этот протокол?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-6 text-center">
                <div class="text-gray-500 text-lg mb-4">
                    Пока нет протоколов тестирования для этого проекта
                </div>
                @if($project->testCases()->count() > 0)
                    <form action="{{ route('projects.test-protocols.store', $project) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            Создать первый протокол
                        </button>
                    </form>
                @endif
            </div>
        @endif
    </div>
@endsection
