<?php

declare(strict_types=1);

namespace App\services;


use App\forms\AddTaskForm;
use App\forms\UpdateTaskForm;
use App\models\Task;
use App\utils\Sorting;

class TaskService
{
    public const PAGE_SIZE = 3;

    public function getPage($pageNumber, Sorting $sorting)
    {
        $offset = $pageNumber * self::PAGE_SIZE;
        
        return Task::query()
            ->orderBy($sorting->getSortBy(), $sorting->getDirection())
            ->offset($offset)
            ->limit(self::PAGE_SIZE)
            ->get();
    }

    public function addTask(AddTaskForm $form)
    {
        $task = new Task();
        $task->username = $form->username;
        $task->email = $form->email;
        $task->text = $form->text;
        $task->save();
    }

    public function completeTask($id)
    {
        $task = $this->findById($id);
        $task->status = Task::STATUS_DONE;
        $task->save();
    }

    public function updateTask(UpdateTaskForm $form)
    {
        $task = $this->findById($form->id);
        $task->text = $form->text;
        $task->is_touched = 1;
        $task->save();
    }

    public function findById($id)
    {
        return Task::query()->findOrFail($id);
    }

    public function getTotalCount()
    {
        return Task::query()
            ->count();
    }
}