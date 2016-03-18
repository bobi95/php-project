<?php
$viewData['title'] = 'Roles';
?>
<h3>Roles</h3> <?php $html->link('Add role', 'create', 'roles') ?>
<hr>

<table id="roles-table" class="table">
	<thead>
		<tr>
			<th>#</th>
			<th>Име</th>
			<th>Опции</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>

<?php

$sections['scripts-bottom'] = function(){
    echo '<script src="/js/roles.js"></script>';
};