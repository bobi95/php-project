<?php
    $viewData['title'] = 'Добави курс';

/** @var \App\Models\Course $course */
$course = $model['course'];
?>
<form class="form-horizontal" role="search" method="post" action="">
	<fieldset>
	  <legend>Добавяне на курс</legend>
	  	<div class="form-group<?php if ($course->getError('name')) echo ' has-error'; ?>">
	    	<label for="name" class="col-md-2">Име на курс:</label>
	    	<div class="col-md-10">
	    		<input type="text" class="form-control" placeholder="Име" id="name" name="name" value="<?=escape($course->getName())?>">
	    		<?=$html->formError($course->getError('name')) ?>
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