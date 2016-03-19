<?php
    $viewData['title'] = 'Добави оценка';
/** @var \App\Helpers\Html $html */

/** @var \App\Models\Assessment $assessment */
$assessment = $model['assessment'];

?>
<form class="form-horizontal" method="post" action="">
	<fieldset>
	  <legend>Добавяне на оценка</legend>
	  	<div class="form-group<?php if ($assessment->getError('name')) echo ' has-error'; ?>">
	    	<label for="name" class="col-md-2">Име на оценка:</label>
	    	<div class="col-md-10">
	    		<input type="text" class="form-control" placeholder="Име" id="name" name="name" value="<?=escape($assessment->getName())?>">
	    		<?php $html->formError($assessment->getError('name')) ?>
	    	</div>
	  	</div>
	  	<div class="form-group<?php if ($assessment->getError('student_id')) echo ' has-error'; ?>">
            <label for="student_id" class="col-md-2">Студент:</label>
            <div class="col-md-10">
                <select name="student_id" id="student_id" class="form-control">
                    <?php
                        $student_id = $assessment->getStudentId();
                        /** @var \App\Models\Student $item */
                        foreach ($model['students'] as $item) { ?>
                            <option value="<?=$item->getId()?>"<?php if ($item->getId() === $student_id) echo " selected"; ?>><?=$item->getFacultyNumber()?></option>
                    <?php } ?>
                </select>
                <?php $html->formError($assessment->getError('students')) ?>
            </div>
        </div>
		<div class="form-group<?php if ($assessment->getError('subject_id')) echo ' has-error'; ?>">
            <label for="subject_id" class="col-md-2">Предмет:</label>
            <div class="col-md-10">
                <select name="subject_id" id="subject_id" class="form-control">
                    <?php
                        $subject_id = $assessment->getSubjectId();
                        /** @var \App\Models\Subject $item */
                        foreach ($model['subjects'] as $item) { ?>
                                <option value="<?=$item->getId()?>"<?php if ($item->getId() === $subject_id) echo " selected"; ?>><?=$item->getName()?></option>
                    <?php } ?>
                </select>
                <?php $html->formError($assessment->getError('subject_id')) ?>
            </div>
        </div>
		<div class="form-group<?php if ($assessment->getError('grade')) echo ' has-error'; ?>">
            <label for="grade" class="col-md-2">Оценка:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" placeholder="Потребителско име" id="grade" name="grade" value="<?=escape($assessment->getGrade())?>">
                <?php $html->formError($assessment->getError('grade')) ?>
            </div>
        </div>
		<div class="form-group<?php if ($assessment->getError('lectures')) echo ' has-error'; ?>">
            <label for="lectures" class="col-md-2">Лекции:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" placeholder="Потребителско име" id="lectures" name="lectures" value="<?=escape($assessment->getLectures())?>">
                <?php $html->formError($assessment->getError('lectures')) ?>
            </div>
        </div>
		<div class="form-group<?php if ($assessment->getError('exercises')) echo ' has-error'; ?>">
            <label for="exercises" class="col-md-2">Упражнения:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" placeholder="Потребителско име" id="exercises" name="exercises" value="<?=escape($assessment->getExercises())?>">
                <?php $html->formError($assessment->getError('exercises')) ?>
            </div>
        </div>
	  	<div class="form-group">
		  	<div class="col-sm-offset-2 col-sm-10">
		  		<a class="btn btn-default">Откажи</a>
		  		<input type="submit" class="btn btn-default" value="Добави">
		  	</div>
	  	</div>
  	</fieldset>
</form>