<?php
    $viewData['title'] = 'Добави оценка';

/** @var \App\Models\Аssessment $assessment */
$assessment = $model['assessment'];
?>
<form class="form-horizontal" role="search" method="post" action="">
	<fieldset>
	  <legend>Добавяне на оценка</legend>
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
		  		<input type="submit" class="btn btn-default" value="Добави"></input>
		  	</div>
	  	</div>
  	</fieldset>
</form>