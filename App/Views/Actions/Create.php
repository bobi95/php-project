<?php
    $viewData['title'] = 'Добави екшън';
/** @var \App\Helpers\Html $html */

/** @var \App\Models\Action $action */
$action = $model['action'];
?>
<form class="form-horizontal" role="search" method="post" action="">
	<fieldset>
	  <legend>Добавяне на екшън</legend>
	  	<div class="form-group<?php if ($action->getError('name')) echo ' has-error'; ?>">
	    	<label for="name" class="col-md-2">Име:</label>
	    	<div class="col-md-10">
	    		<input type="text" class="form-control" placeholder="Име" id="name" name="name" value="<?=escape($action->getName())?>">
	    		<?php $html->formError($action->getError('name')) ?>
	    	</div>
	  	</div>
		<div class="form-group<?php if ($action->getError('controller')) echo ' has-error'; ?>">
			<label for="controller_id" class="col-md-2">Контролер:</label>
			<div class="col-md-10">
				<select name="controller_id" id="controller_id" class="form-control">
					<?php
					$controller_id = $action->getControllerId();

					/** @var \App\Models\Controller $controller */
					foreach ($model['controllers'] as $controller) { ?>
						<option value="<?=$controller->getId()?>"<?php if ($controller->getId() === $controller_id) echo " selected"; ?>><?=$controller->getName()?></option>
					<?php } ?>
				</select>
				<?php $html->formError($action->getError('controller_id')) ?>
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