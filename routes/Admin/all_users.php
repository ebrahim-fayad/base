<?php

use Routes\Admin\AllUsers\{
    Admins\AdminsRoutesName,
    Clients\ClientsRoutesName
};
use Illuminate\Support\Facades\Route;

Route::get('all-users', [
    'as'            => 'all_users',
    'icon'          => '<i class="feather icon-users"></i>',
    'title'         => 'all_users',
    'type'          => 'parent',
    'has_sub_route' => true,
    'child'         => array_merge(
    ClientsRoutesName::getNames(),  AdminsRoutesName::getNames()
    )
]);
require __DIR__ . '/AllUsers/Clients/routes-links.php';
require __DIR__ . '/AllUsers/Admins/routes-links.php';
