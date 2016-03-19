<?php
$viewData['title'] = 'Редактирай студент';

/** @var \App\Models\Student $student */
$student = $model['student'];
?>
<form class="form-horizontal" method="post" action="">
    <fieldset>
        <legend>Редактиране на студент</legend>
        <input type="hidden" name="id" value="<?=$student->getId()?>">
        <div class="form-group<?php if ($student->getError('faculty_number')) echo ' has-error'; ?>">
            <label for="faculty_number" class="col-md-2">Факултетен номер:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" placeholder="Факултетен номер" id="faculty_number" name="faculty_number" value="<?=escape($student->getFacultyNumber())?>">
                <?=$html->formError($student->getError('faculty_number')) ?>
            </div>
        </div>
        
        <div class="form-group<?php if ($user->getError('role')) echo ' has-error'; ?>">
            <label for="course_id" class="col-md-2">Роля:</label>
            <div class="col-md-10">
                <select name="course_id" id="course_id" class="form-control">
                    <?php
                    $course_id = $user->getRoleId();
                    foreach ($model['roles'] as $role) { ?>
                        <option value="<?=$role->getId()?>"<?php if ($role->getId() === $course_id) echo " selected"; ?>><?=$role->getName()?></option>
                    <?php } ?>
                </select>
                <?=$html->formError($user->getError('course_id')) ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <a class="btn btn-default" href="<?=$html->url('index', 'students')?>">Откажи</a>
                <input type="submit" class="btn btn-default" value="Редактирай">
            </div>
        </div>
    </fieldset>
</form>