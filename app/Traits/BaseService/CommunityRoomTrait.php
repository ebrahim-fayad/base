<?php

namespace App\Traits\BaseService;

use App\Models\Chat\Room;
use App\Models\Chat\RoomMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

trait CommunityRoomTrait
{
    /**
     * Join a user/provider/admin to the community chat room.
     *
     * This method is idempotent - safe to call multiple times.
     * Uses firstOrCreate to prevent duplicate entries.
     *
     * @param Model $member The User, Provider, or Admin model instance
     * @return array Returns status array with key, msg, and optional data
     */
    public function joinCommunityRoom(Model $member): array
    {
        try {
            // Get the community room
            $communityRoom = Room::getCommunityRoom();

            if (!$communityRoom) {
                Log::warning('Community room not found. Please run the CommunityRoomSeeder.');
                return [
                    'key' => 'error',
                    'msg' => __('apis.community_room_not_found'),
                ];
            }

            // Join the room using firstOrCreate (idempotent)
            $roomMember = RoomMember::firstOrCreate([
                'room_id' => $communityRoom->id,
                'memberable_id' => $member->id,
                'memberable_type' => get_class($member),
            ]);

            $isNewMember = $roomMember->wasRecentlyCreated;

            return [
                'key' => 'success',
                'msg' => $isNewMember
                    ? __('apis.joined_community_room')
                    : __('apis.already_in_community_room'),
                'data' => [
                    'room_member' => $roomMember,
                    'is_new_member' => $isNewMember,
                ],
            ];
        } catch (\Exception $e) {
            Log::error('Failed to join community room: ' . $e->getMessage(), [
                'member_id' => $member->id,
                'member_type' => get_class($member),
            ]);

            return [
                'key' => 'error',
                'msg' => __('apis.failed_to_join_community_room'),
            ];
        }
    }

    /**
     * Check if a member is already in the community room.
     *
     * @param Model $member The User, Provider, or Admin model instance
     * @return bool
     */
    public function isInCommunityRoom(Model $member): bool
    {
        return RoomMember::where([
            'room_id' => Room::COMMUNITY_ROOM_ID,
            'memberable_id' => $member->id,
            'memberable_type' => get_class($member),
        ])->exists();
    }

    /**
     * Leave the community room (soft remove from room).
     * Note: Generally, users should not leave the community room.
     * This method is provided for admin/cleanup purposes.
     *
     * @param Model $member The User, Provider, or Admin model instance
     * @return array
     */
    public function leaveCommunityRoom(Model $member): array
    {
        try {
            $deleted = RoomMember::where([
                'room_id' => Room::COMMUNITY_ROOM_ID,
                'memberable_id' => $member->id,
                'memberable_type' => get_class($member),
            ])->delete();

            return [
                'key' => 'success',
                'msg' => $deleted ? __('apis.left_community_room') : __('apis.not_in_community_room'),
            ];
        } catch (\Exception $e) {
            Log::error('Failed to leave community room: ' . $e->getMessage());

            return [
                'key' => 'error',
                'msg' => __('apis.failed_to_leave_community_room'),
            ];
        }
    }

    /**
     * Get the community room membership for a member.
     *
     * @param Model $member The User, Provider, or Admin model instance
     * @return RoomMember|null
     */
    public function getCommunityRoomMembership(Model $member): ?RoomMember
    {
        return RoomMember::where([
            'room_id' => Room::COMMUNITY_ROOM_ID,
            'memberable_id' => $member->id,
            'memberable_type' => get_class($member),
        ])->first();
    }
}
