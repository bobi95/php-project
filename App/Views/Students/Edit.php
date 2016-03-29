<?php
    $viewData['title'] = 'Create Student';

/** @var \App\Models\Student $student */
$student = $model['student'];
?>
<form class="form-horizontal" method="post" action="">
    <fieldset>
        <legend>Добавяне на студент</legend>
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
        <div class="form-group<?php if ($student->getError('education_type_id')) echo ' has-error'; ?>">
            <label for="education_type_id" class="col-md-2">Форма на обучение:</label>
            <div class="col-md-10">
                <select name="education_type_id" id="education_type_id" class="form-control">
                    <?php
                        $education_type_id = $student->getSpecialityId();
                        /** @var \App\Models\EducationType $eType */
                        foreach ($model['educationTypes'] as $eType) { ?>
                                <option value="<?=$eType->getId()?>"<?php if ($eType->getId() === $education_type_id) echo " selected"; ?>><?=$eType->getName()?></option>
                    <?php } ?>
                </select>
                <?php $html->formError($student->getError('education_type_id')) ?>
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
                <input type="submit" class="btn btn-default" value="Добави">
            </div>
        </div>
    </fieldset>
</form>