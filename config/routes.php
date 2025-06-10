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
    ],
    'productmgmt/index' => [
        'controller' => 'productmgmt',
        'method' => 'index',
        'permissions' => ['productmgmt_view', 'productmgmt_edit', 'productmgmt_delete', 'productmgmt_create'],
    ],
    'productmgmt/add' => [
        'controller' => 'productmgmt',
        'method' => 'add',
        'permissions' => ['productmgmt_create'],
    ],
    'productmgmt/edit' => [
        'controller' => 'productmgmt',
        'method' => 'edit',
        'permissions' => ['productmgmt_edit'],
    ],
    'productmgmt/delete' => [
        'controller' => 'productmgmt',
        'method' => 'delete',
        'permissions' => ['productmgmt_delete'],
    ],
    'productmgmt/view' => [
        'controller' => 'productmgmt',
        'method' => 'view',
        'permissions' => ['productmgmt_view'],
    ],
    'productmgmt/search' => [
        'controller' => 'productmgmt',
        'method' => 'search',
        'permissions' => ['productmgmt_view'],
    ]
];
