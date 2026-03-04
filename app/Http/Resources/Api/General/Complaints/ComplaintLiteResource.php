<?php

namespace App\Http\Resources\Api\General\Complaints;

use App\Enums\ComplaintStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ComplaintLiteResource extends JsonResource
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
            'subject' => $this->subject,
            'status' => ComplaintStatusEnum::getFullObj($this->status, 'complaintStatusEnum'),
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y'),
        ];
    }
}
