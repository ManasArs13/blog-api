<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Конфигурация количества записей
    public const USER_COUNT = 10;
    public const POST_COUNT = 5;
    public const COMMENT_COUNT = 6;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(Self::USER_COUNT)
            ->has(
                Post::factory(Self::POST_COUNT)
                    ->hasComments(SELF::COMMENT_COUNT)
            )
            ->create();

        $this->printStatistics();
    }

    /**
     * Вывод статистики по заполненным данным
     */
    protected function printStatistics()
    {
        $this->command->info('Database seeded successfully!');
        $this->command->table(
            ['Таблица', 'Всего записей', 'Выполнено сейчас'],
            [
                ['Пользователи', User::count(), self::USER_COUNT],
                ['Посты', Post::count(), self::POST_COUNT],
                ['Комментарии', Comment::count(), self::COMMENT_COUNT],
            ]
        );
    }
}
