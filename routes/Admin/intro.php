<?php

use Routes\Admin\LandingPage\{
    Fqs\IntroFqsRoutesName,
    FqsCategories\IntroFqsCategoriesRoutesName,
    HowWorks\IntroHowWorksRoutesName,
    Messages\IntroMessagesRoutesName,
    Partners\IntroPartnersRoutesName,
    Services\IntroServicesRoutesName,
    Slider\IntroSliderRoutesName,
    Socials\IntroSocialRoutesName,
};
use Illuminate\Support\Facades\Route;


Route::get('intro-site', [
    'icon'      => '<i class="feather icon-map"></i>',
    'title'     => 'introductory_site',
    'type'      => 'parent',
    'has_sub_route' => true,
    'child'     => array_merge(
        ['intro_settings.index'],
        IntroSliderRoutesName::getNames(),
        IntroServicesRoutesName::getNames(),
        IntroFqsCategoriesRoutesName::getNames(),
        IntroFqsRoutesName::getNames(),
        IntroPartnersRoutesName::getNames(),
        IntroMessagesRoutesName::getNames(),
        IntroHowWorksRoutesName::getNames(),
        IntroSocialRoutesName::getNames(),
    )

]);

Route::get('intro-settings', [
    'uses'      => 'LandingPage\IntroSetting@index',
    'as'        => 'intro_settings.index',
    'title'     => 'introductory_site_setting',
    'sub_link'  => true,
]);

require __DIR__ . '/LandingPage/Slider/routes-links.php';
require __DIR__ . '/LandingPage/Services/routes-links.php';
require __DIR__ . '/LandingPage/FqsCategories/routes-links.php';
require __DIR__ . '/LandingPage/Fqs/routes-links.php';
require __DIR__ . '/LandingPage/Partners/routes-links.php';
require __DIR__ . '/LandingPage/Messages/routes-links.php';
require __DIR__ . '/LandingPage/Socials/routes-links.php';
require __DIR__ . '/LandingPage/HowWorks/routes-links.php';


/*------------ end Of landing page ----------*/
