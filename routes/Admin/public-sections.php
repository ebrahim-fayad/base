<?php

use Routes\Admin\PublicSections\{
    Images\ImagesRoutesName,
    Complaints\ComplaintsRoutesName,
    ContactMessages\ContactMessagesRoutesName,
    Fqs\FqsRoutesName,
    IntrosSliders\IntrosSlidersRoutesName
};
use Illuminate\Support\Facades\Route;

/*------------ start Of public sections ----------*/

Route::get('public-sections', [
    'as' => 'public-sections',
    'icon' => '<i class="feather icon-flag"></i>',
    'title' => 'public_sections',
    'type' => 'parent',
    'has_sub_route' => true,
    'child' => array_merge(
        IntrosSlidersRoutesName::getNames(),
        ImagesRoutesName::getNames(),
        ContactMessagesRoutesName::getNames(),
        ComplaintsRoutesName::getNames(),
        FqsRoutesName::getNames()
    )
]);

require __DIR__ . '/PublicSections/IntrosSliders/routes-links.php';
require __DIR__ . '/PublicSections/Images/routes-links.php';
require __DIR__ . '/PublicSections/ContactMessages/routes-links.php';
require __DIR__ . '/PublicSections/Complaints/routes-links.php';
require __DIR__ . '/PublicSections/Fqs/routes-links.php';

/*------------ end Of public sections ----------*/
