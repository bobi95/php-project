<?php
$viewData['title'] = 'Редактирай оценка';

/** @var \App\Models\Course $couse */
$assessmentassessment = $model['assessment'];
?>
<form class="form-horizontal" role="search" method="post" action="">
	<fieldset>
	  <legend>Редактиране на оценка</legend>
	  <input type="hidden" name="id" value="<?=$assessment->getId()?>">
	  	<div class="form-group<?php if ($assessment->getError('name')) echo ' has-error'; ?>">
	    	<label for="name" class="col-md-2">Име на оценка:</label>
	    	<div class="col-md-10">
	    		<input type="text" class="form-control" placeholder="Име" id="name" name="name" value="<?=escape($assessment->getName())?>">
	    		<?=$html->formError($assessment->getError('name')) ?>
	    	</div>
	  	</div>
	  	<div class="form-group">
		  	<div class="col-sm-offset-2 col-sm-10">
		  		<a class="btn btn-default">Откажи</a>
		  		<input type="submit" class="btn btn-default" value="Редактирай"></input>
		  	</div>
	  	</div>
  	</fieldset>
</form>