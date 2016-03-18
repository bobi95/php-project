<?php
$viewData['title'] = 'Users';
?>
<h3>Users</h3> <?php $html->link('Create User', 'create', 'users') ?>
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