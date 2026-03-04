<?php

namespace App\Http\Resources\Api\General\Complaints;

use App\Enums\ComplaintStatusEnum;
use App\Http\Resources\Api\Basics\BasicResourceWithImage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ComplaintDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'complaint_num' => '#' . $this->complaint_num,
            'complaint' => $this->complaint,
            'subject' => $this->subject,
            'replay' => $this->replay?->replay,
            'status' => ComplaintStatusEnum::getFullObj($this->status, 'complaintStatusEnum'),
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y'),
        ];
    }
}
