<?php
    $viewData['title'] = 'Create User';

/** @var \App\Models\User $user */
$user = $model['user'];
?>
<form class="form-horizontal" method="post" action="">
    <fieldset>
        <legend>Добавяне на потребител</legend>
        <div class="form-group<?php if ($user->getError('username')) echo ' has-error'; ?>">
            <label for="username" class="col-md-2">Потребителско име:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" placeholder="Потребителско име" id="username" name="username" value="<?=escape($user->getUsername())?>">
                <?php $html->formError($user->getError('username')) ?>
            </div>
        </div>
        <div class="form-group<?php if ($user->getError('first_name')) echo ' has-error'; ?>">
            <label for="first_name" class="col-md-2">Собствено име:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" placeholder="Собствено име" id="first_name" name="first_name" value="<?=escape($user->getFirstName())?>">
                <?php $html->formError($user->getError('first_name')) ?>
            </div>
        </div>
        <div class="form-group<?php if ($user->getError('last_name')) echo ' has-error'; ?>">
            <label for="last_name" class="col-md-2">Фамилия:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" placeholder="Фамилия" id="last_name" name="last_name" value="<?=escape($user->getLastName())?>">
                <?php $html->formError($user->getError('last_name')) ?>
            </div>
        </div>
        <div class="form-group<?php if ($user->getError('password')) echo ' has-error'; ?>">
            <label for="password" class="col-md-2">Парола:</label>
            <div class="col-md-10">
                <input type="password" class="form-control" placeholder="Парола" id="password" name="password">
                <?php $html->formError($user->getError('password')) ?>
            </div>
        </div>
        <div class="form-group<?php if ($user->getError('password_repeat')) echo ' has-error'; ?>">
            <label for="password_repeat" class="col-md-2">Повторете паролата:</label>
            <div class="col-md-10">
                <input type="password" class="form-control" placeholder="Повторете паролата" id="password_repeat" name="password_repeat">
                <?php $html->formError($user->getError('password_repeat')) ?>
            </div>
        </div>
        <div class="form-group<?php if ($user->getError('email')) echo ' has-error'; ?>">
            <label for="email" class="col-md-2">Имейл:</label>
            <div class="col-md-10">
                <input type="email" class="form-control" placeholder="Имейл" id="email" name="email" value="<?=escape($user->getEmail())?>">
                <?php $html->formError($user->getError('email')) ?>
            </div>
        </div>
        <div class="form-group<?php if ($user->getError('role')) echo ' has-error'; ?>">
            <label for="role_id" class="col-md-2">Роля:</label>
            <div class="col-md-10">
                    <?php
                    /** @var \App\Models\Role[] $roles */
                    $roles = $user->getRoles();

                    $roleIds = [];
                    foreach($roles as $role) {
                        $roleIds[$role->getId()] = true;
                    }

                    /** @var \App\Models\Role $role */
                    foreach ($model['roles'] as $role) { ?>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="role_ids[]" value="<?=$role->getId()?>" <?php if (isset($roleIds[$role->getId()])) echo 'checked'; ?>>
                                <?=$role->getName()?>
                            </label>
                        </div>
                <?php
                    }
                    $html->formError($user->getError('role_id'));
                    ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <a class="btn btn-default" href="<?=$html->url('index', 'users')?>">Откажи</a>
                <input type="submit" class="btn btn-default" value="Добави">
            </div>
        </div>
    </fieldset>
</form>