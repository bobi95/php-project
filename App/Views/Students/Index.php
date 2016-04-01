<?php
$viewData['title'] = 'Студенти';
?>
<h3>Студенти</h3> <?php $html->link('Добави студент', 'create', 'students') ?>
<hr>

<table id="students-table" class="table">
	<thead>
		<tr>
			<th>#</th>
            <th>Име и фамилия</th>
            <th>Факултетен номер</th>
            <th>Курс</th>
			<th>Специалност</th>
			<th>Форма на обучение</th>
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
        <h4 class="modal-title">Изтриване на студент</h4>
      </div>
      <div class="modal-body">
        <p>Сигурни ли сте, че искате да изтриете този студент?</p>
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
    echo '<script src="/js/students.js"></script>';
};