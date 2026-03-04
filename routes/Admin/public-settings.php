<?php

use Illuminate\Support\Facades\Route;
use Routes\Admin\PublicSettings\{
    Socials\SocialsRoutesName,
    Roles\RolesRoutesName,
    Settings\SettingsRoutesName,
    Reports\ReportsRoutesName
};

Route::get('public-settings', [
    'as'            => 'public-settings',
    'icon'          => '<i class="feather icon-flag"></i>',
    'title'         => 'public_settings',
    'type'          => 'parent',
    'has_sub_route' => true,
    'child'         => array_merge(
        SocialsRoutesName::getNames(),
        RolesRoutesName::getNames(),
        SettingsRoutesName::getNames(),
        ReportsRoutesName::getNames()
    )
]);

require __DIR__ . '/PublicSettings/Socials/routes-links.php';
require __DIR__ . '/PublicSettings/Roles/routes-links.php';
require __DIR__ . '/PublicSettings/Settings/routes-links.php';
require __DIR__ . '/PublicSettings/Reports/routes-links.php';

/*------------ END Of public settings ----------*/
