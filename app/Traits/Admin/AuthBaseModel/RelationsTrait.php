<?php

namespace App\Traits\Admin\AuthBaseModel;

use App\Models\Chat\Room;
use App\Models\BankAccount;
use App\Models\Wallet\Wallet;
use App\Models\Chat\RoomMember;
use App\Models\Core\AuthUpdate;
use App\Models\PublicSettings\Device;
use App\Models\PublicSections\Complaint;
use App\Models\PublicSections\ComplaintReplay;
use App\Models\Rate;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;


trait RelationsTrait
{
    public function devices()
    {
        return $this->morphMany(Device::class, 'morph');
    }


    public function authUpdates()
    {
        return $this->morphMany(AuthUpdate::class, 'updatable');
    }
}
