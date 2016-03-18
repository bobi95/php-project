<?php
/** @var App\Helpers\Html $html */
$viewData['title'] = 'Home/Index';
?>
<a href="/Users">Add User</a>

<?php
    \App\Services\PagingService::getElements(new \App\DataAccess\UserRepository(), 1, 10,
        [
            'username' => 'ASC'
        ], [
        'like' => [
            'username' => 'gos%'
        ]
    ]);
?>


<div>
    <?php
    $html->label('Test Label', 'test');
    $html->textField('test', 'text', null, null, ['placeholder' => 'Test']); ?>
</div>
