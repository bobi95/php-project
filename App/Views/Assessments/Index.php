<?php
$viewData['title'] = 'Оценки';
?>
<h3>Курсове</h3> <?php $html->link('Добави оценка', 'create', 'assessmentс') ?>
<hr>
<table class="table table-hover" id="assessment-table">
    <thead>
        <tr>
            <td>#</td>
            <td>Име</td>
            <td>Име</td>
            <td>Лекции</td>
            <td>Упражнения</td>            
            <td>Операции</td>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<?php

$sections['scripts-bottom'] = function(){
    echo '<script src="/js/assessmentс.js"></script>';
};