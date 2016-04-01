<?php
    $viewData['title'] = 'Edit student';

/** @var \App\Models\Student $student */
$student = $model['student'];
/** @var \App\Models\User $user */
$user = $model['user'];
?>
<form class="form-horizontal" method="post" action="">
    <input type="hidden" value="<?=$user->getId() ?>" name="user_id">
    <input type="hidden" value="<?=$student->getId() ?>" name="student_id">
    <fieldset>
        <legend>Редактиране на потребител</legend>
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
    </fieldset>

    <fieldset>
        <legend>Редактиране на студент</legend>
        <div class="form-group<?php if ($student->getError('course_id')) echo ' has-error'; ?>">
            <label for="course_id" class="col-md-2">Курс:</label>
            <div class="col-md-10">
                <select name="course_id" id="course_id" class="form-control">
                    <?php
                    $course_id = $student->getCourseId();
                    foreach ($model['courses'] as $course) { ?>
                    <option value="<?=$course->getId()?>"<?php if ($course->getId() === $course_id) echo " selected"; ?>><?=$course->getName()?></option>
                <?php } ?>
                </select>
                <?php $html->formError($student->getError('course_id')) ?>
            </div>
        </div>
        <div class="form-group<?php if ($student->getError('specialty_id')) echo ' has-error'; ?>">
            <label for="specialty_id" class="col-md-2">Специалност:</label>
            <div class="col-md-10">
                <select name="specialty_id" id="specialty_id" class="form-control">
                    <?php
                    $specialty_id = $student->getSpecialityId();
                    foreach ($model['specialties'] as $specialty) { ?>
                    <option value="<?=$specialty->getId()?>"<?php if ($specialty->getId() === $specialty_id) echo " selected"; ?>><?=$specialty->getName()?></option>
                <?php } ?>
                </select>
                <?php $html->formError($student->getError('specialty_id')) ?>
            </div>
        </div>
        <div class="form-group<?php if ($student->getError('education_form')) echo ' has-error'; ?>">
            <label for="education_form" class="col-md-2">Форма на обучение:</label>
            <div class="col-md-10">
                <select name="education_form" id="education_form" class="form-control">
                    <?php
                        $education_form = $student->getEducationForm();
                        /** @var \App\Models\EducationType $eType */
                        foreach ($model['educationTypes'] as $eType) { ?>
                                <option value="<?=$eType?>"<?php if ($eType === $education_form) echo " selected"; ?>><?=$eType?></option>
                    <?php } ?>
                </select>
                <?php $html->formError($student->getError('education_form')) ?>
            </div>
        </div>

        <div class="form-group<?php if ($student->getError('faculty_number')) echo ' has-error'; ?>">
            <label for="faculty_number" class="col-md-2">Факултетен номер:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" placeholder="Факултетен номер" id="faculty_number" name="faculty_number" value="<?=escape($student->getFacultyNumber())?>">
                <?php $html->formError($student->getError('faculty_number')) ?>
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