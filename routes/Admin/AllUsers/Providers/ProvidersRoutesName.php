<?php

namespace Routes\Admin\AllUsers\Providers;

class ProvidersRoutesName
{
    public static function getNames(): array
    {
        return [
            // users routes
            'providers.index',
            'providers.show',
            'providers.store',
            'providers.update',
            'providers.delete',
            'providers.notify',
            'providers.deleteAll',
            'providers.create',
            'providers.edit',
            'providers.block',
            'providers.updateBalance',
            'providers.toggleApprovement',
            'providers.getUpdates',
            'providers.updates-toggle',
        ];
    }
}
