<?php
    $viewData['title'] = 'Добави форма на обучение';

/** @var \App\Models\EducationType $educationType */
$educationType = $model['educationType'];
?>
<form class="form-horizontal" role="search" method="post" action="">
	<fieldset>
	  <legend>Добавяне на форма на обучение</legend>
	  	<div class="form-group<?php if ($educationType->getError('name')) echo ' has-error'; ?>">
	    	<label for="name" class="col-md-2">Име:</label>
	    	<div class="col-md-10">
	    		<input type="text" class="form-control" placeholder="Име" id="name" name="name" value="<?=escape($educationType->getName())?>">
	    		<?=$html->formError($educationType->getError('name')) ?>
	    	</div>
	  	</div>
	  	<div class="form-group<?php if ($educationType->getError('number')) echo ' has-error'; ?>">
	    	<label for="number" class="col-md-2">Номер:</label>
	    	<div class="col-md-10">
	    		<input type="text" class="form-control" placeholder="Номер" id="number" name="number" value="<?=escape($educationType->getNumber())?>">
	    		<?=$html->formError($educationType->getError('number')) ?>
	    	</div>
	  	</div>
	  	<div class="form-group">
		  	<div class="col-sm-offset-2 col-sm-10">
		  		<a class="btn btn-default">Откажи</a>
		  		<input type="submit" class="btn btn-default" value="Добави"></input>
		  	</div>
	  	</div>
  	</fieldset>
</form>