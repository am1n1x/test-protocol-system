@extends('layouts.app')

@section('title', 'Редактировать требование')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Редактировать требование - {{ $project->name }}
        </h2>
        <a href="{{ route('projects.requirements.index', $project) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Назад к требованиям
        </a>
    </div>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form action="{{ route('projects.requirements.update', [$project, $requirement]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">
                        Заголовок требования *
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $requirement->title) }}" 
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
                              placeholder="Введите описание требования">{{ old('description', $requirement->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @if($requirement->attachments && $requirement->attachments->count() > 0)
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Текущие файлы
                        </label>
                        <div class="space-y-2">
                            @foreach($requirement->attachments as $attachment)
                                <div class="flex items-center justify-between bg-gray-50 p-2 rounded" id="attachment-{{ $attachment->id }}">
                                    <span class="text-sm text-gray-700">{{ $attachment->filename }}</span>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('attachments.download', $attachment) }}" 
                                           class="text-blue-500 hover:text-blue-700 text-sm">
                                            Скачать
                                        </a>
                                        <button type="button" onclick="deleteAttachment({{ $attachment->id }})"
                                                class="text-red-500 hover:text-red-700 text-sm">
                                            Удалить
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-6">
                    <label for="attachments" class="block text-gray-700 text-sm font-bold mb-2">
                        Добавить файлы (необязательно)
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
                        Сохранить изменения
                    </button>
                    <a href="{{ route('projects.requirements.index', $project) }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function deleteAttachment(attachmentId) {
    if (confirm('Вы уверены, что хотите удалить этот файл?')) {
        fetch(`/attachments/${attachmentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove attachment element from DOM
                const attachmentElement = document.getElementById(`attachment-${attachmentId}`);
                if (attachmentElement) {
                    attachmentElement.remove();
                }
                
                // Check if no attachments remain and hide the section
                const remainingCount = document.querySelectorAll('[id^="attachment-"]').length;
                if (remainingCount === 0) {
                    const attachmentsSection = document.querySelector('.mb-4:has([id^="attachment-"])');
                    if (attachmentsSection) {
                        attachmentsSection.style.display = 'none';
                    }
                }
                
                alert('Файл успешно удален');
            } else {
                alert('Ошибка при удалении файла');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ошибка при удалении файла');
        });
    }
}
</script>
@endpush
