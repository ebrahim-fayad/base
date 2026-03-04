<?php

namespace App\Traits;

use App\Facades\BaseService;
use App\Models\AllUsers\User;
use App\Models\Programs\Level;
use App\Models\Programs\LevelSubscription;
use App\Support\QueryOptions;
use App\Models\AllUsers\Admin;
use App\Models\PublicSettings\Role;
use App\Models\LandingPage\IntroFqs;
use App\Models\LandingPage\IntroSlider;
use App\Models\LandingPage\IntroSocial;
use App\Models\LandingPage\IntroHowWork;
use App\Models\LandingPage\IntroPartner;
use App\Models\LandingPage\IntroService;
use App\Models\LandingPage\IntroMessages;
use App\Models\PublicSettings\LogActivity;
use App\Models\LandingPage\IntroFqsCategory;

trait MenuTrait
{
    public function home()
    {
        $options = (new QueryOptions());
        $totalUsers = User::count();
        $activeUsers = User::where('active', true)->count();
        $totalPrograms = Level::count();
        $totalLevels = Level::count();
        $totalSubscriptions = LevelSubscription::count();
        $subscriptionRate = $totalUsers > 0
            ? round(($totalSubscriptions / $totalUsers) * 100, 1)
            : 0;

        $menu = [
            [
                'name' => __('admin.registered_users'),
                'count' => $totalUsers,
                'count_type' => __('admin.users_count'),
                'icon' => 'icon-users',
                'url' => url('admin/clients'),
            ],
            [
                'name' => __('admin.active_users'),
                'count' => $activeUsers,
                'count_type' => __('admin.users_count'),
                'icon' => 'icon-user-check',
                'url' => url('admin/clients'),
            ],
            [
                'name' => __('admin.programs_label'),
                'count' => $totalPrograms,
                'count_type' => __('admin.programs_count'),
                'icon' => 'icon-award',
                'url' => route('admin.levels.index'),
            ],
            [
                'name' => __('admin.subscription_rate'),
                'count' => $subscriptionRate . '%',
                'count_type' => __('admin.subscription_rate_desc'),
                'icon' => 'icon-percent',
                'url' => route('admin.levels.index'),
            ],
            [
                'name' => __('admin.total_subscriptions'),
                'count' => $totalSubscriptions,
                'count_type' => __('admin.subscriptions_count'),
                'icon' => 'icon-calendar',
                'url' => route('admin.levels.index'),
            ],
            [
                'name' => __('routes.admins.index'),
                'count' => BaseService::setModel(Admin::class)->count((new QueryOptions())->conditions([['type', "!=", 'super_admin']])),
                'icon' => 'icon-users',
                'url' => url('admin/admins'),
            ],
            [
                'name' => __('routes.reports.index'),
                'count' => BaseService::setModel(LogActivity::class)->count($options),
                'icon' => 'icon-list',
                'url' => url('admin/reports'),
            ],
            [
                'name' => __('routes.roles.index'),
                'count' => BaseService::setModel(Role::class)->count($options),
                'icon' => 'icon-eye',
                'url' => url('admin/roles'),
            ],
        ];

        return $menu;
    }

    public function introSiteCards()
    {
        $options = (new QueryOptions());
        $menu = [
            [
                'name' => __('routes.intro_slider.index'),
                'count' => BaseService::setModel(IntroSlider::class)->count($options),
                'icon' => 'icon-users',
                'url' => url('admin/introsliders'),
            ],
            [
                'name' => __('routes.our_services.index'),
                'count' => BaseService::setModel(IntroService::class)->count($options),
                'icon' => 'icon-users',
                'url' => url('admin/introservices'),
            ],
            [
                'name' => __('routes.common_questions_sections.index'),
                'count' => BaseService::setModel(IntroFqsCategory::class)->count($options),
                'icon' => 'icon-users',
                'url' => url('admin/introfqscategories'),
            ],
            [
                'name' => __('routes.questions_sections.index'),
                'count' => BaseService::setModel(IntroFqs::class)->count($options),
                'icon' => 'icon-users',
                'url' => url('admin/introfqs'),
            ],
            [
                'name' => __('routes.success_Partners.index'),
                'count' => BaseService::setModel(IntroPartner::class)->count($options),
                'icon' => 'icon-users',
                'url' => url('admin/introparteners'),
            ],
            [
                'name' => __('routes.customer_messages.index'),
                'count' => BaseService::setModel(IntroMessages::class)->count($options),
                'icon' => 'icon-users',
                'url' => url('admin/intromessages'),
            ],
            [
                'name' => __('routes.socials.index'),
                'count' => BaseService::setModel(IntroSocial::class)->count($options),
                'icon' => 'icon-users',
                'url' => url('admin/introsocials'),
            ],
            [
                'name' => __('routes.how_the_site_works.index'),
                'count' => BaseService::setModel(IntroHowWork::class)->count($options),
                'icon' => 'icon-users',
                'url' => url('admin/introhowworks'),
            ],
        ];
        return $menu;
    }
}
