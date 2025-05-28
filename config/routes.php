<?php
$routes = [
    '' => [
        'controller' => 'home',
        'method' => 'index',
        'permissions' => ['authenticated'],
        ],
    'home' => [
        'controller' => 'home',
        'method' => 'index',
        'permissions' => ['authenticated'],
        ],
    'login' => [
        'controller' => 'auth',
        'method' => 'login',
        'permissions' => ['not_authenticated'],
        ],
    'logout' => [
        'controller' => 'auth',
        'method' => 'logout',
        'permissions' => ['authenticated', 'not_authenticated'],
        ],
    'phpinfo' => [
        'controller' => 'info',
        'method' => 'index',
        'permissions' => ['authenticated'],
        ],
    'usermgmgt/index' => [
        'controller' => 'usermgmt',
        'method' => 'index',
        'permissions' => ['usermgmgt_view', 'usermgmgt_edit', 'usermgmgt_delete', 'usermgmgt_create'],
        ],
    ];
