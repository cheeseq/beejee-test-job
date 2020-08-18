<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace App\controllers;


use App\forms\AddTaskForm;
use App\forms\UpdateTaskForm;
use App\services\TaskService;
use App\services\UserService;
use App\utils\Sorting;

class TasksController extends BaseController
{
    private TaskService $taskService;

    public function __construct()
    {
        parent::__construct();
        $this->taskService = new TaskService();
    }

    public function showTasksPage($pageNumber)
    {
        $pageNumber = $pageNumber ? $pageNumber : 1;
        $sorting = new Sorting($_GET['sortBy'] ?? 'id', $_GET['direction'] ?? 'desc');

        $totalTasksCount = $this->taskService->getTotalCount();
        $totalPages = ceil($totalTasksCount / TaskService::PAGE_SIZE);

        $tasksPage = $this->taskService->getPage($pageNumber - 1, $sorting);

        $this->view->setVar('totalPages', $totalPages);
        $this->view->setVar('activePage', $pageNumber);
        $this->view->setVar('sorting', $sorting);
        $this->view->setVar('tasks', $tasksPage);

        $this->view->render('tasks');
    }

    /**
     * Supposed to work via AJAX
     */
    public function addTask()
    {
        $form = new AddTaskForm();
        $form->collect($_POST);

        $validation = $form->validate();

        if ($validation->passes()) {
            $this->taskService->addTask($form);
            $_SESSION['successMessage'] = 'Задача добавлена!';
            $this->jsonOutput(['success' => true]);
        }

        $this->jsonOutput(['success' => false, 'errors' => $validation->errors->all()]);
    }

    public function completeTask($id)
    {
        if (!UserService::isAdmin()) {
            $this->redirect("/login");
        }

        $this->taskService->completeTask($id);
        $this->goBack();
    }

    public function updateTask()
    {
        if (!UserService::isAdmin()) {
            $this->redirect("/login");
        }

        $form = new UpdateTaskForm();
        $form->collect($_POST);

        $validation = $form->validate();

        if ($validation->passes()) {
            $this->taskService->updateTask($form);
            $this->goBack();
        }

        $this->view->setVar('validationErrors', $validation->errors());
    }
}