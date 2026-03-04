<?php

namespace Routes\Admin\Programs;

class ProgramsRoutesName
{
    public static function getNames(): array
    {
        return [
            'levels.index',
            'levels.create',
            'levels.store',
            'levels.show',
            'levels.edit',
            'levels.update',
            'levels.delete',
            'levels.deleteAll',
            'levels.toggleStatus',
            'levels.days.exercises.store',
            'levels.days.exercises.update',
            'levels.days.exercises.destroy',
            'levels.subscribers',
            'levels.subscriptions.toggleStatus',
        ];
    }
}
