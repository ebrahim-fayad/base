<?php

namespace Routes\Admin\AllUsers\Clients;

class ClientsRoutesName
{
    public static function getNames(): array
    {
        return [
            // users routes
            'clients.index',
            'clients.show',
            'clients.store',
            'clients.update',
            'clients.delete',
            'clients.notify',
            'clients.deleteAll',
            'clients.create',
            'clients.edit',
            'clients.block',
            'clients.updateBalance',
            'clients.updateNutritional',
        ];
    }
}
