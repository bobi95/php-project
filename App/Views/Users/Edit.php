<?php
$viewData['title'] = 'Редактирай потребител';

/** @var \App\Models\User $user */
$user = $model['user'];
?>
<form class="form-horizontal" method="post" action="">
    <fieldset>
        <legend>Редактиране на потребител</legend>
        <input type="hidden" name="id" value="<?=$user->getId()?>">
        <div class="form-group<?php if ($user->getError('username')) echo ' has-error'; ?>">
            <label for="username" class="col-md-2">Потребителско име:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" placeholder="Потребителско име" id="username" name="username" value="<?=escape($user->getUsername())?>">
                <?=$html->formError($user->getError('username')) ?>
            </div>
        </div>
        <div class="form-group<?php if ($user->getError('first_name')) echo ' has-error'; ?>">
            <label for="first_name" class="col-md-2">Собствено име:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" placeholder="Собствено име" id="first_name" name="first_name" value="<?=escape($user->getFirstName())?>">
                <?=$html->formError($user->getError('first_name')) ?>
            </div>
        </div>
        <div class="form-group<?php if ($user->getError('last_name')) echo ' has-error'; ?>">
            <label for="last_name" class="col-md-2">Фамилия:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" placeholder="Фамилия" id="last_name" name="last_name" value="<?=escape($user->getLastName())?>">
                <?=$html->formError($user->getError('last_name')) ?>
            </div>
        </div>
        <div class="form-group<?php if ($user->getError('password')) echo ' has-error'; ?>">
            <label for="password" class="col-md-2">Парола:</label>
            <div class="col-md-10">
                <input type="password" class="form-control" placeholder="Парола" id="password" name="password">
                <?=$html->formError($user->getError('password')) ?>
            </div>
        </div>
        <div class="form-group<?php if ($user->getError('password_repeat')) echo ' has-error'; ?>">
            <label for="password_repeat" class="col-md-2">Повторете паролата:</label>
            <div class="col-md-10">
                <input type="password" class="form-control" placeholder="Повторете паролата" id="password_repeat" name="password_repeat">
                <?=$html->formError($user->getError('password_repeat')) ?>
            </div>
        </div>
        <div class="form-group<?php if ($user->getError('email')) echo ' has-error'; ?>">
            <label for="email" class="col-md-2">Имейл:</label>
            <div class="col-md-10">
                <input type="email" class="form-control" placeholder="Имейл" id="email" name="email" value="<?=escape($user->getEmail())?>">
                <?=$html->formError($user->getError('email')) ?>
            </div>
        </div>
        <div class="form-group<?php if ($user->getError('role')) echo ' has-error'; ?>">
            <label for="role_id" class="col-md-2">Роля:</label>
            <div class="col-md-10">
                <select name="role_id" id="role_id" class="form-control">
                    <?php
                    $role_id = $user->getRoleId();
                    foreach ($model['roles'] as $role) { ?>
                        <option value="<?=$role->getId()?>"<?php if ($role->getId() === $role_id) echo " selected"; ?>><?=$role->getName()?></option>
                    <?php } ?>
                </select>
                <?=$html->formError($user->getError('role_id')) ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <a class="btn btn-default" href="<?=$html->url('index', 'users')?>">Откажи</a>
                <input type="submit" class="btn btn-default" value="Редактирай">
            </div>
        </div>
    </fieldset>
</form>