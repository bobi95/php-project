<?php
    $viewData['title'] = 'Добави дисциплина';

    /** @var \App\Helpers\Html $html */
    /** @var \App\Models\Subject $subject */
    /** @var array $model */

$subject = $model['subject'];
?>
<form class="form-horizontal" method="post" action="">
    <fieldset>
        <legend>Добавяне на дисциплина</legend>
        <div class="form-group<?php if ($subject->getError('name')) echo ' has-error'; ?>">
            <label for="name" class="col-md-2">Име:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" placeholder="Име" id="name" name="name" value="<?=escape($subject->getName())?>">
                <?php $html->formError($subject->getError('name')) ?>
            </div>
        </div>
		 <div class="form-group<?php if ($subject->getError('lectures')) echo ' has-error'; ?>">
            <label for="lectures" class="col-md-2">Лекции (Х):</label>
            <div class="col-md-10">
                <input type="text" class="form-control" placeholder="Хорариум на лекциите" id="lectures" name="lectures" value="<?=escape($subject->getName())?>">
                <?php $html->formError($subject->getError('lectures')) ?>
            </div>
        </div>
		 <div class="form-group<?php if ($subject->getError('lectures')) echo ' has-error'; ?>">
            <label for="exercises" class="col-md-2">Упражнения (Х):</label>
            <div class="col-md-10">
                <input type="text" class="form-control" placeholder="Хорариум на упражненията" id="exercises" name="exercises" value="<?=escape($subject->getName())?>">
                <?php $html->formError($subject->getError('exercises')) ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <a class="btn btn-default" href="<?=$html->url('index', 'subjects')?>">Откажи</a>
                <input type="submit" class="btn btn-default" value="Добави">
            </div>
        </div>
    </fieldset>
</form>