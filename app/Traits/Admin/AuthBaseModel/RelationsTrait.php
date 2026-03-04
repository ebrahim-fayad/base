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
    public function rooms()
    {
        return $this->morphMany(RoomMember::class, 'memberable');
    }

    public function ownRooms()
    {
        return $this->morphMany(Room::class, 'createable');
    }
    public function joinedRooms()
    {
        return $this->morphMany(RoomMember::class, 'memberable')
            ->with('room')
            ->get()
            ->sortByDesc('room.last_message_id')
            ->pluck('room');
    }

    public function replays()
    {
        return $this->morphMany(ComplaintReplay::class, 'replayer');
    }

    public function authUpdates()
    {
        return $this->morphMany(AuthUpdate::class, 'updatable');
    }

    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'walletable')->latest();
    }
    public function complaints(): MorphMany
    {
        return $this->morphMany(Complaint::class, 'complaintable');
    }

    public function bankAccount(): MorphOne
    {
        return $this->morphOne(BankAccount::class, 'bankable');
    }

    public function ratingsGiven(): MorphMany
    {
        return $this->morphMany(Rate::class, 'ratingable');
    }

    public function ratingsReceived(): MorphMany
    {
        return $this->morphMany(Rate::class, 'ratedable');
    }
}
