<?php
    $viewData['title'] = 'Редактиране на специалност';

/** @var \App\Models\Specialty $specialty */
$specialty = $model['specialty'];
?>
<form class="form-horizontal" method="post" action="">
    <fieldset>
        <legend>Редактиране на специалност</legend>
        <input type="hidden" name="id" value="<?=$specialty->getId()?>">
        <div class="form-group<?php if ($specialty->getError('name')) echo ' has-error'; ?>">
            <label for="name" class="col-md-2">Име:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" placeholder="Име" id="name" name="name" value="<?=escape($specialty->getName())?>">
                <?php $html->formError($specialty->getError('name')) ?>
            </div>
        </div>
        <div class="form-group<?php if ($specialty->getError('short_name')) echo ' has-error'; ?>">
            <label for="short_name" class="col-md-2">Късо име:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" placeholder="Късо име" id="short_name" name="short_name" value="<?=escape($specialty->getShortName())?>">
                <?php $html->formError($specialty->getError('short_name')) ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <a class="btn btn-default" href="<?=$html->url('index', 'specialties')?>">Откажи</a>
                <input type="submit" class="btn btn-default" value="Редактирай">
            </div>
        </div>
    </fieldset>
</form>