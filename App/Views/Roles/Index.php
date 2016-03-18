<?php
$viewData['title'] = 'Roles';
?>
<h3>Roles</h3> <?php $html->link('Add role', 'create', 'roles') ?>
<hr>
<table class="table table-hover">
    <thead>
        <tr>
            <td>#</td>
            <td><?php
                $sort = 'username_asc';

                if (isset($model['params']['sort']) && $model['params']['sort'] === 'username_asc') {
                    $sort = 'username_desc';
                } else if (isset($model['params']['sort']) && $model['params']['sort'] === 'username_desc') {
                    $sort = null;
                }

                $params = $model['params'];
                $params['sort'] = $sort;
    
                $html->link('Потребителско име', 'index', 'users', $params);

                if ($sort === 'username_desc') {
                    echo ' <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>';
                } else if ($sort === null){
                    echo ' <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>';
                }
                ?></td>
            <td><?php
                $sort = 'email_asc';

                if (isset($model['params']['sort']) && $model['params']['sort'] === 'email_asc') {
                    $sort = 'email_desc';
                } else if (isset($model['params']['sort']) && $model['params']['sort'] === 'email_desc') {
                    $sort = null;
                }

                $params = $model['params'];
                $params['sort'] = $sort;

                $html->link('Имейл', 'index', 'users', $params);

                if ($sort === 'email_desc') {
                    echo ' <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>';
                } else if ($sort === null){
                    echo ' <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>';
                }
                ?></td>
            <td>Роля</td>
            <td>Операции</td>
        </tr>
    </thead>
    <tbody>
    <?php
    $users = $model['elements'];

    if (empty($users)) {
        ?>
        <tr>No users</tr>
        <?php
    } else {
        foreach($users as $n => $user) {
            ?>
            <tr>
                <td><?=($n+1)?></td>
                <td><?=escape($user->getUsername())?></td>
                <td><?=escape($user->getEmail())?></td>
                <td><?=escape($user->getRole()->getName())?></td>
                <td>
                    <?php
                    $html->link('Редактирай', 'edit', 'users', ['id' => $user->getId()]);
                    ?> | <?php
                    $html->link('Изтрий', 'delete', 'users', ['id' => $user->getId()]);
                    ?>
                </td>
            </tr>
            <?php
        }
    }?>
    </tbody>
</table>

<nav>
    <ul class="pagination">
        <li>
            <a href="<?php
            $params = $model['params'];
            $params['page'] = $model['page'] - 1;
            echo $html->url('index', 'users', $params);
            ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <?php foreach($model['numbers'] as $n) { ?>
            <li><?php $html->link($n, 'index', 'users', $model['params']); ?></li>
        <?php } ?>
        <li>
            <a href="<?php
            $params = $model['params'];
            $params['page'] = $model['page'] + 1;
            echo $html->url('index', 'users', $params);
            ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>