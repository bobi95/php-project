<?php
    $viewData['title'] = 'Create Role';

    /** @var \App\Helpers\Html $html */
    /** @var \App\Models\Role $role */
    /** @var array $model */

$role = $model['role'];
?>
<form class="form-horizontal" method="post" action="">
    <fieldset>
        <legend>Добавяне на роля</legend>
        <div class="form-group<?php if ($role->getError('name')) echo ' has-error'; ?>">
            <label for="name" class="col-md-2">Име:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" placeholder="Име" id="name" name="name" value="<?=escape($role->getName())?>">
                <?php $html->formError($role->getError('name')) ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <a class="btn btn-default" href="<?=$html->url('roles', 'users')?>">Откажи</a>
                <input type="submit" class="btn btn-default" value="Добави">
            </div>
        </div>
    </fieldset>
</form>