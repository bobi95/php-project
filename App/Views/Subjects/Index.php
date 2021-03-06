<?php
$viewData['title'] = 'Дисциплини';
?>
<h3>Дисциплини</h3> <?php $html->link('Добави дисциплина', 'create', 'subjects') ?>
<hr>

<table id="subjects-table" class="table">
	<thead>
		<tr>
			<th>#</th>
			<th>Име</th>
			<th>Лекции</th>
			<th>Упражнения</th>
			<th>Опции</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>

<div class="modal fade" tabindex="-1" role="dialog" id="delete-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Изтриване на дисциплина</h4>
      </div>
      <div class="modal-body">
        <p>Сигурни ли сте, че искате да изтриете тази дисциплина?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Не</button>
        <button type="button" class="btn btn-primary" id="confirm-deletion">Да</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php

$sections['scripts-bottom'] = function(){
    echo '<script src="/js/subjects.js"></script>';
};