<?php
    include '../App/init.php';
    App::run();

$repo = new \App\DataAccess\UserRepository();
if (empty($repo->getAll())) {
    $role = new \App\Models\Role();
    $role->setName('Administrator');
    (new \App\DataAccess\RoleRepository())->save($role);

    $user = new \App\Models\User();
    $user->setUsername('useradmin');
    $user->setFirstName('Admin');
    $user->setMiddleName('Admin');
    $user->setLastName('Admin');
    $user->setPassword(\App\Helpers\Hash::create('pass1234'));
    $user->setEmail('admin@admin.com');
    $user->setRoleId($role->getId());
    $repo->save($user);

    $user = new \App\Models\User();
    $user->setUsername('useradmin2');
    $user->setFirstName('Admin2');
    $user->setMiddleName('Admin2');
    $user->setLastName('Admin2');
    $user->setPassword(\App\Helpers\Hash::create('pass1234'));
    $user->setEmail('admin2@admin.com');
    $user->setRoleId($role->getId());
    $repo->save($user);
}