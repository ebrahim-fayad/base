<?php

namespace Routes\Admin\AllUsers\Admins;

class AdminsRoutesName
{
    public static function getNames(): array
    {
        return [
            // countries routes
            'admins.index',
            'admins.store',
            'admins.update',
            'admins.edit',
            'admins.delete',
            'admins.deleteAll',
            'admins.create',
            'admins.edit',
            'admins.notifications',
            'admins.notifications.delete',
            'admins.show',
            'admins.block',
        ];
    }
}
