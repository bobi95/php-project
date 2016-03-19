<?php
$viewData['title'] = 'Форма на обучение';
?>
<h3>Курсове</h3> <?php $html->link('Добави форма на обучение', 'create', 'educationTypes') ?>
<hr>
<table class="table table-hover" id="educationType-table">
    <thead>
        <tr>
            <td>#</td>
            <td>Име</td>
            <td>Номер</td>
            <td>Операции</td>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<?php

$sections['scripts-bottom'] = function(){
    echo '<script src="/js/educationTypes.js"></script>';
};