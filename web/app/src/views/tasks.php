<?php

use App\models\Task;
use App\services\UserService;
use App\utils\Sorting;

/** @var Sorting $sorting */
$sorting = $this->getVar('sorting');

/** @var Task[] $tasks */
$tasks = $this->hasVar('tasks') ? $this->getVar('tasks') : [];
?>

<?php if ($_SESSION['successMessage']): ?>
    <div class="alert alert-success" role="alert">
        <?=$_SESSION['successMessage']?>
    </div>
    <?php unset($_SESSION['successMessage']) ?>
<?php endif ?>


<?php if (count($tasks) == 0): ?>
    <p>Пока нет задач.</p>
<?php else: ?>
    <table class="table">
        <thead>
        <tr>
            <th>Имя пользователя <?=Sorting::renderSorter('username', $sorting)?></th>
            <th>E-mail <?=Sorting::renderSorter('email', $sorting)?></th>
            <th>Текст</th>
            <th>Статус <?=Sorting::renderSorter('status', $sorting)?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?=htmlentities($task->username, ENT_QUOTES)?></td>
                <td><?=htmlentities($task->email, ENT_QUOTES)?></td>
                <td>
                    <?=htmlentities($task->text, ENT_QUOTES)?>
                    <?php if ($task->isUpdatedByAdmin()): ?>
                        <div>
                            <small><i>Отредактировано администратором</i></small>
                        </div>
                    <?php endif; ?>
                </td>
                <td>
                    <?=$task->getFormattedStatus()?>

                    <?php if (UserService::isAdmin()): ?>
                        <div>
                            <button type="button" data-toggle="modal" data-target="#editModal<?=$task->id?>" class="btn btn-sm btn-primary">Редактировать</button>
                            <div class="modal fade" id="editModal<?=$task->id?>" tabindex="-1" aria-hidden="true">
                                <form method="post" action="/tasks/update">
                                    <input type="hidden" name="UpdateTaskForm[id]" value="<?=$task->id?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Редактировать текст задачи</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="text">Текст</label>
                                                    <textarea id="text" name="UpdateTaskForm[text]" class="form-control" required><?=htmlentities($task->text, ENT_QUOTES)?></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                                <button type="submit" class="btn btn-primary">Сохранить</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <?php if ($task->status == Task::STATUS_NOT_DONE): ?>
                            <div>
                                <a href="/tasks/complete/<?=$task->id?>" class="btn btn-sm btn-success">Выполнено</a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($this->getVar('totalPages') > 1): ?>
        <nav>
            <ul class="pagination">
                <?php if ($this->getVar('activePage') > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="/tasks/<?=($this->getVar('activePage') - 1) . $sorting->getSoringQueryString()?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php foreach (range(1, $this->getVar('totalPages')) as $pageNumber): ?>
                    <?php if ($pageNumber == $this->getVar('activePage')): ?>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href=""><?=$pageNumber?> <span class="sr-only">(current)</span></a>
                        </li>
                    <?php else: ?>
                        <li class="page-item"><a class="page-link" href="/tasks/<?=$pageNumber . $sorting->getSoringQueryString()?>"><?=$pageNumber?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if ($this->getVar('activePage') < $this->getVar('totalPages')): ?>
                    <li class="page-item">
                        <a class="page-link" href="/tasks/<?=($this->getVar('activePage') + 1) . $sorting->getSoringQueryString()?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>

<?php endif; ?>

<hr>
<h3>Добавить задачу</h3>

<div class="alert alert-danger" role="alert" style="display: none;" id="validation-errors-container">
    Ошибки валидации:
    <ul id="validation-errors">
    </ul>
</div>

<form class="mt-md-4" id="addTaskForm">
    <div class="form-group">
        <label for="username">Имя пользователя</label>
        <input type="text" name="AddTaskForm[username]" class="form-control" id="username" required>
    </div>
    <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" name="AddTaskForm[email]" class="form-control" id="email" required>
    </div>
    <div class="form-group">
        <label for="text">Текст</label>
        <textarea id="text" name="AddTaskForm[text]" class="form-control" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Добавить задачу</button>
</form>

<script>
  $(document).ready(function () {
    $('#addTaskForm').on('submit', function (e) {
      e.preventDefault();
      $.post('/tasks', $(this).serialize(), (data) => {
        data = JSON.parse(data);

        $('#validation-errors-container').hide();
        $('#validation-errors').empty();

        if (data.success) {
          window.location.reload();
        } else {
          $('#validation-errors-container').show();
          for (let error of data.errors) {
            $('#validation-errors').append(`<li>${error}</li>`)
          }
        }
      })
    })
  });
</script>