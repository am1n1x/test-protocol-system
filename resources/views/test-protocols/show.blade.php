@extends('layouts.app')

@section('title', 'Протокол тестирования #' . $testProtocol->id)

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Протокол тестирования #{{ $testProtocol->id }} - {{ $testProtocol->project->name }}
            </h2>
            <p class="text-gray-600 text-sm mt-1">
                Создан: {{ $testProtocol->created_at->format('d.m.Y H:i') }} | 
                Автор: {{ $testProtocol->user->name }}
            </p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('projects.test-protocols.index', $testProtocol->project) }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Назад к протоколам
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
        @if($testProtocol->testResults->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-8">
                                №
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">
                                Описание шага
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">
                                Действия в системе
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">
                                Ожидаемый результат
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">
                                Фактический результат
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                                Статус
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                                Тестировщик
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                                Дата тестирования
                            </th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-20">
                                Действие
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($testProtocol->testResults as $index => $result)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900">
                                    <div class="max-w-xs">
                                        {{ $result->testCase->description }}
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900">
                                    <div class="max-w-xs">
                                        {{ $result->testCase->actions }}
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900">
                                    <div class="max-w-xs">
                                        {{ $result->testCase->expected_result }}
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <form action="{{ route('test-results.update', $result) }}" method="POST" id="form-{{ $result->id }}">
                                        @csrf
                                        @method('PATCH')
                                        <textarea name="actual_result" rows="3" 
                                                  class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                                  placeholder="Введите фактический результат...">{{ $result->actual_result }}</textarea>
                                </td>
                                <td class="px-4 py-4">
                                    <select name="status_id" 
                                            class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}" 
                                                    {{ $result->status_id == $status->id ? 'selected' : '' }}
                                                    class="
                                                        @if($status->name == 'Пройден') text-green-700 @endif
                                                        @if($status->name == 'Провален') text-red-700 @endif
                                                        @if($status->name == 'Пропущен') text-yellow-700 @endif
                                                    ">
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $result->user->name }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $result->updated_at->format('d.m.Y') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <button type="submit" 
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">
                                        Сохранить
                                    </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
            <div class="bg-gray-50 px-6 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Сводка по тестированию</h3>
                    </div>
                    <div class="flex space-x-6 text-sm">
                        @php
                            $total = $testProtocol->testResults->count();
                            $notTested = $testProtocol->testResults->where('status_id', 1)->count();
                            $passed = $testProtocol->testResults->where('status_id', 2)->count();
                            $failed = $testProtocol->testResults->where('status_id', 3)->count();
                            $skipped = $testProtocol->testResults->where('status_id', 4)->count();
                        @endphp
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-600">{{ $total }}</div>
                            <div class="text-gray-500">Всего</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-400">{{ $notTested }}</div>
                            <div class="text-gray-500">Не протестировано</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $passed }}</div>
                            <div class="text-green-500">Пройдены</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600">{{ $failed }}</div>
                            <div class="text-red-500">Провалены</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600">{{ $skipped }}</div>
                            <div class="text-yellow-500">Пропущены</div>
                        </div>
                    </div>
                </div>

                @if($notTested == 0 && $total > 0)
                    <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium">
                                    Тестирование завершено!
                                </h3>
                                <div class="mt-2 text-sm">
                                    <p>Все тест-кейсы в этом протоколе были протестированы.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <div class="p-6 text-center">
                <div class="text-gray-500 text-lg mb-4">
                    В этом протоколе нет тест-кейсов для выполнения
                </div>
                <a href="{{ route('projects.test-protocols.index', $testProtocol->project) }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Назад к протоколам
                </a>
            </div>
        @endif
    </div>

    <script>
        // Auto-save functionality (optional enhancement)
        document.addEventListener('DOMContentLoaded', function() {
            // You can add auto-save functionality here if needed
            // For now, users need to click the save button for each row
        });
    </script>
@endsection
