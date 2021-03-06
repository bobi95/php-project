<?php
/** @var \App\Helpers\Html $html */

/** @var \App\Models\Student[] $students */
$students = $model['students'];

/** @var \App\Models\Subject[] $subjects */
$subjects = $model['subjects'];

/** @var \App\Models\Course[] $courses */
$courses = $model['courses'];

/** @var \App\Models\Speciality[] $specialities */
$specialities = $model['specialities'];

/** @var \App\Models\SubjectAssessment[] $assessments */
$assessments = $model['assessments'];

$page = $model['page'];
$pages = $model['pages'];
$numbers = $model['numbers'];
$params = $model['params'];
function getGradeString($grade) {
    if ($grade < 3) {
        return 'Слаб';
    }

    if ($grade < 3.5) {
        return 'Среден';
    }

    if ($grade < 4.5) {
        return 'Добър';
    }

    if ($grade < 5.5) {
        return 'Мн. Добър';
    }

    return 'Отличен';
}
?>
<div class="container">
<form class="form-horizontal">
    <fieldset>
        <legend>Търсене</legend>
        <div class="form-group">
            <label for="fname" class="col-md-2">Име:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" id="fname" name="student_fname" value="<?=$params['student_fname']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="lname" class="col-md-2">Фамилия:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" id="lname" name="student_lname" value="<?=$params['student_lname']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="speciality" class="col-md-2">Специалност:</label>
            <div class="col-md-10">
                <select name="speciality_id" id="speciality" class="form-control">
                    <option></option>
                    <?php foreach ($specialities as $speciality) { ?>
                        <option value="<?=$speciality->getId()?>"<?php if ($speciality->getId() == $params['speciality_id']) echo ' selected'; ?>><?=$speciality->getName()?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="course" class="col-md-2">Курс:</label>
            <div class="col-md-10">
                <select name="course_id" id="course" class="form-control">
                    <option></option>
                    <?php foreach($courses as $course) { ?>
                        <option value="<?=$course->getId()?>"<?php if ($course->getId() == $params['course_id']) echo ' selected'; ?>><?=$course->getName()?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Търси</button>
            </div>
        </div>
    </fieldset>
</form>
</div>
<table class="table table-bordered table-hover table-striped">
    <thead>
    <tr>
        <th colspan="3"></th>
        <th colspan="<?=(count($subjects) + 1) * 3; ?>" class="text-center">Предмети (хорариум и оценки)</th>
    </tr>
    <tr>
        <th colspan="3"></th>
        <?php foreach ($subjects as $subject) { ?>
            <th colspan="3" class="text-center"><?=$subject;?></th>
        <?php } ?>
        <th colspan="3" class="text-center">Общо</th>
    </tr>
    <tr>
        <th>#</th>
        <th class="text-center">
            <a href="<?php
            $_params = $params;
            $_params['sort'] = $params['sort'] === 'name_desc' ? 'name_asc' : 'name_desc';
            echo $html->url('studentAssessments', 'home', $_params)?>">
                Имена <span class="glyphicon glyphicon-sort-by-alphabet<?php if ($params['sort'] === 'name_desc') echo '-alt';?>" aria-hidden="true"></span>
            </a>
        </th>
        <th class="text-center">Курс</th>
        <?php for($i = 0, $count = count($subjects); $i < $count; $i++) { ?>
            <th class="text-center">Лекции</th>
            <th class="text-center">Упражнения</th>
            <th class="text-center">Оценка</th>
        <?php } ?>
        <th class="text-center">Лекции</th>
        <th class="text-center">Упражнения</th>
        <th class="text-center">Ср. успех</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $counter = ($page - 1) * 15 + 1;
    foreach($students as $student) { ?>
        <tr>
            <th><?=$counter++; ?></th>
            <td>
                <?=$student->getFirstName()?>
                <?=$student->getLastName()?>
                (<?=$student->getFacultyNumber()?>)
            </td>
            <td>
                <?=$courses[$student->getCourseId()]->getName() ?>,
                <?=$specialities[$student->getSpecialityId()]->getShortName() ?>,
                (<?=$student->getEducationForm() ?>)
            </td>
            <?php
            $gradeSum = 0;
            $gradeCount = 0;
            $lectures = 0;
            $exercises = 0;
            $maxLectures = 0;
            $maxExercises = 0;

            foreach($subjects as $k => $v) {

                if (isset($assessments[$student->getId()][$k])) {

                    /** @var \App\Models\SubjectAssessment $assessment */
                    $assessment = $assessments[$student->getId()][$k];

                    $gradeSum += $assessment->getAssessment();
                    $gradeCount++;
                    $lectures += $assessment->getLectures();
                    $exercises += $assessment->getExercises();
                    $maxLectures += $assessment->getMaxLectures();
                    $maxExercises += $assessment->getMaxExercises();

                    ?>
                    <td><?=$assessment->getLectures();?> (<?=$assessment->getMaxLectures();?>)</td>
                    <td><?=$assessment->getExercises();?> (<?=$assessment->getMaxExercises();?>)</td>
                    <td><?=getGradeString($assessment->getAssessment());?> (<?=$assessment->getAssessment();?>)</td>
                    <?php
                } else {
                    ?>
                    <td></td>
                    <td></td>
                    <td></td>
                    <?php
                }
            }
            ?>
            <td><?=$lectures?> (<?=$maxLectures?>)</td>
            <td><?=$exercises?> (<?=$maxExercises?>)</td>
            <td><?php
                if ($gradeCount) {
                    echo getGradeString($gradeSum / $gradeCount);
                ?> (<?=round($gradeSum / $gradeCount, 2)?>)<?php
                } ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php

?>
<nav>
    <ul class="pagination">
        <li>
            <a href="<?=$html->url('studentAssessments', 'home', $params)?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <?php foreach ($numbers as $number) { ?>
            <li <?php if ($number == $page) echo 'class="active"';
            $_params = $params;
            $_params['page'] = $number;
            ?>><?php $html->link($number, 'studentAssessments', 'home', $_params);?></li>
        <?php }
        $_params = $params;
        $_params['page'] = $pages;
        ?>
        <li>
            <a href="<?=$html->url('studentAssessments', 'home', $_params)?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>