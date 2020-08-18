<?php if ($this->hasVar('validationErrors') && count($this->getVar('validationErrors')->all()) > 0): ?>
    <div class="alert alert-danger" role="alert">
        Ошибки валидации:
        <ul>
            <?php foreach ($this->getVar('validationErrors')->all() as $validationError): ?>
                <li><?=$validationError?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="/login">
    <div class="form-group">
        <label for="login">Логин</label>
        <input type="text" name="LoginForm[username]" class="form-control" id="login" required>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Пароль</label>
        <input type="password" name="LoginForm[password]" class="form-control" id="exampleInputPassword1" required>
    </div>
    <button type="submit" class="btn btn-primary">Вход</button>
</form>