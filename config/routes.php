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
    'usermgmt/index' => [
        'controller' => 'usermgmt',
        'method' => 'index',
        'permissions' => ['usermgmt_view', 'usermgmt_edit', 'usermgmt_delete', 'usermgmt_create'],
    ],
    'usermgmt/add' => [
        'controller' => 'usermgmt',
        'method' => 'add',
        'permissions' => ['usermgmt_create'],
    ],
    'usermgmt/edit' => [
        'controller' => 'usermgmt',
        'method' => 'edit',
        'permissions' => ['usermgmt_edit'],
    ],
    'usermgmt/delete' => [
        'controller' => 'usermgmt',
        'method' => 'delete',
        'permissions' => ['usermgmt_delete'],
    ],
    'usermgmt/edit-permissions' => [
        'controller' => 'usermgmt',
        'method' => 'edit_permissions',
        'permissions' => ['usermgmt_edit_permissions']
    ]
];
