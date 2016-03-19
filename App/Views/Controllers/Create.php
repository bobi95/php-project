<?php
    $viewData['title'] = 'Добави контролер';
/** @var \App\Helpers\Html $html */

/** @var \App\Models\Controller $controller */
$controller = $model['controller'];
?>
<form class="form-horizontal" role="search" method="post" action="">
	<fieldset>
	  <legend>Добавяне на контролер</legend>
	  	<div class="form-group<?php if ($controller->getError('name')) echo ' has-error'; ?>">
	    	<label for="name" class="col-md-2">Име:</label>
	    	<div class="col-md-10">
	    		<input type="text" class="form-control" placeholder="Име" id="name" name="name" value="<?=escape($controller->getName())?>">
	    		<?php $html->formError($controller->getError('name')) ?>
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