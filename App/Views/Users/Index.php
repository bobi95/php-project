<?php
$viewData['title'] = 'Потребители';
?>
<h3>Потребители</h3> <?php $html->link('Добави потребител', 'create', 'users') ?>
<hr>
<table class="table table-hover" id="user-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Потребителско име</th>
            <th>E-mail</th>
            <th>Роля</th>
            <th>Операции</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<?php

$sections['scripts-bottom'] = function(){
    echo '<script src="/js/users.js"></script>';
};