<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Compte admin
        $admin = User::factory()->create([
            'name'     => 'Admin',
            'email'    => 'admin@taskflow.test',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        // Compte utilisateur standard
        $user = User::factory()->create([
            'name'     => 'Utilisateur Test',
            'email'    => 'user@taskflow.test',
            'password' => bcrypt('password'),
            'role'     => 'user',
        ]);

        // 3 utilisateurs aléatoires supplémentaires
        $extraUsers = User::factory(3)->create();

        // Tags globaux
        $tags = Tag::factory(6)->create();

        // Boards et tâches pour l'admin
        Board::factory(3)->create(['user_id' => $admin->id])
            ->each(function ($board) use ($admin, $tags) {
                Task::factory(4)->create([
                    'board_id' => $board->id,
                    'user_id'  => $admin->id,
                ])->each(fn($task) => $task->tags()->attach(
                    $tags->random(rand(1, 3))->pluck('id')
                ));
            });

        // Boards et tâches pour l'utilisateur test
        Board::factory(2)->create(['user_id' => $user->id])
            ->each(function ($board) use ($user, $tags) {
                Task::factory(3)->create([
                    'board_id' => $board->id,
                    'user_id'  => $user->id,
                ])->each(fn($task) => $task->tags()->attach(
                    $tags->random(rand(1, 2))->pluck('id')
                ));
            });

        // Boards pour les utilisateurs aléatoires
        foreach ($extraUsers as $extraUser) {
            Board::factory(rand(1, 2))->create(['user_id' => $extraUser->id])
                ->each(function ($board) use ($extraUser, $tags) {
                    Task::factory(rand(2, 4))->create([
                        'board_id' => $board->id,
                        'user_id'  => $extraUser->id,
                    ])->each(fn($task) => $task->tags()->attach(
                        $tags->random(rand(0, 2))->pluck('id')
                    ));
                });
        }
    }
}