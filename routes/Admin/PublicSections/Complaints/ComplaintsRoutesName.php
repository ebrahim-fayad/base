<?php

namespace Routes\Admin\PublicSections\Complaints;

class ComplaintsRoutesName
{
    public static function getNames(): array
    {
        return [
            // complaint routes name
            'all_complaints',
            'complaints.delete',
            'complaints.deleteAll',
            'complaints.show',
            'complaints.replay',
        ];
    }
}
