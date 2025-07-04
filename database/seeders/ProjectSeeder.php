<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\TestCase;
use App\Models\Requirement;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Проверяем, есть ли уже проекты в базе
        if (Project::count() > 0) {
            return; // Если проекты есть, выходим
        }

        // Получаем первого пользователя или создаем нового
        $user = User::first() ?? User::factory()->create([
            'name' => 'Администратор',
            'email' => 'admin@example.com',
        ]);

        // Создаем тестовый проект
        $project = Project::create([
            'name' => 'Тестовый проект веб-приложения',
            'description' => 'Проект для тестирования функциональности системы управления пользователями и заказами.',
        ]);

        // Создаем требования
        $requirement1 = $project->requirements()->create([
            'user_id' => $user->id,
            'title' => 'Авторизация пользователей',
            'description' => 'Система должна позволять пользователям входить в систему используя email и пароль.',
        ]);

        $requirement2 = $project->requirements()->create([
            'user_id' => $user->id,
            'title' => 'Управление заказами',
            'description' => 'Пользователи должны иметь возможность создавать, редактировать и удалять заказы.',
        ]);

        // Создаем тест-кейсы привязанные к требованиям
        $project->testCases()->create([
            'user_id' => $user->id,
            'requirement_id' => $requirement1->id,
            'description' => 'Проверка успешной авторизации с корректными данными',
            'actions' => '1. Открыть страницу входа\n2. Ввести корректный email\n3. Ввести корректный пароль\n4. Нажать кнопку "Войти"',
            'expected_result' => 'Пользователь успешно авторизован и перенаправлен на главную страницу',
        ]);

        $project->testCases()->create([
            'user_id' => $user->id,
            'requirement_id' => $requirement1->id,
            'description' => 'Проверка авторизации с некорректными данными',
            'actions' => '1. Открыть страницу входа\n2. Ввести некорректный email\n3. Ввести некорректный пароль\n4. Нажать кнопку "Войти"',
            'expected_result' => 'Отображается сообщение об ошибке, пользователь остается на странице входа',
        ]);

        $project->testCases()->create([
            'user_id' => $user->id,
            'requirement_id' => $requirement2->id,
            'description' => 'Создание нового заказа',
            'actions' => '1. Авторизоваться в системе\n2. Перейти в раздел "Заказы"\n3. Нажать кнопку "Создать заказ"\n4. Заполнить форму заказа\n5. Нажать "Сохранить"',
            'expected_result' => 'Заказ успешно создан и отображается в списке заказов',
        ]);

        $project->testCases()->create([
            'user_id' => $user->id,
            'requirement_id' => $requirement2->id,
            'description' => 'Редактирование существующего заказа',
            'actions' => '1. Открыть список заказов\n2. Выбрать существующий заказ\n3. Нажать кнопку "Редактировать"\n4. Изменить данные в форме\n5. Нажать "Сохранить"',
            'expected_result' => 'Изменения сохранены, отображается обновленная информация о заказе',
        ]);

        $project->testCases()->create([
            'user_id' => $user->id,
            'requirement_id' => $requirement2->id,
            'description' => 'Удаление заказа',
            'actions' => '1. Открыть список заказов\n2. Выбрать заказ для удаления\n3. Нажать кнопку "Удалить"\n4. Подтвердить удаление',
            'expected_result' => 'Заказ удален из системы и больше не отображается в списке',
        ]);
    }
}
