<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{
    public function getUserTasks(User $user, array $filters = []): LengthAwarePaginator
    {
        $query = Task::with('user')
            ->forUser($user->id);

        if (isset($filters['status'])) {
            $query->byStatus($filters['status']);
        }

        return $query->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function createTask(User $user, array $data): Task
    {
        return Task::create([
            'user_id' => $user->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? 'pending',
            'due_date' => $data['due_date'] ?? null,
        ]);
    }

    public function updateTask(Task $task, array $data): Task
    {
        $task->update($data);
        $task->load('user');

        return $task;
    }

    public function deleteTask(Task $task): void
    {
        $task->delete();
    }
}
