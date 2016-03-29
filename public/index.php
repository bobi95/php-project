<?php
    include '../App/init.php';
if (!\App\Services\AuthenticationService::isUserLogged()) {
    $userRepo = new \App\DataAccess\UserRepository();
    if (!$userRepo->getUserByUsername('administrator')) {
        $user = new \App\Models\User();
        $user->setFirstName('Admin');
        $user->setLastName('Adminov');
        $user->setUsername('administrator');
        $user->setPassword(\App\Helpers\Hash::create('userPass'));
        $userRepo->save($user);
    }

    if (!$userRepo->getUserByUsername('testUser')) {
        $user = new \App\Models\User();
        $user->setFirstName('Test');
        $user->setLastName('Userov');
        $user->setUsername('testUser');
        $user->setPassword(\App\Helpers\Hash::create('userPass'));
        $userRepo->save($user);
    }
}
    App::run();