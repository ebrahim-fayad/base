<?php

namespace App\Models\PublicSections;


use App\Models\Order;
use App\Models\Core\BaseModel;
use App\Enums\ComplaintTypesEnum;
use App\Enums\ComplaintStatusEnum;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Complaint extends BaseModel
{


    protected $fillable = [
        'user_name',
        'order_id',
        'complaintable_id',
        'complaintable_type',
        'complaint',
        'phone',
        'email',
        'subject',
        'type',
        'status',
        'complaint_num'
    ];
    protected $casts = [
        'type' => ComplaintTypesEnum::class,
    ];

    public function complaintable(): MorphTo
    {
        // users , providers , employees
        return $this->morphTo();
    }

    public function replay(): HasOne
    {
        return $this->hasOne(ComplaintReplay::class, 'complaint_id', 'id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }


    public function getTypeTextAttribute()
    {
        // dd($this->attributes['type']);
        return ComplaintTypesEnum::getTranslatedName($this->attributes['type'], 'ComplaintTypesEnum');
    }
    public function getUrlAttribute()
    {
        return match ($this->type) {
            ComplaintTypesEnum::Complaint => route('admin.complaints.show', ['id' => $this->id]),
            ComplaintTypesEnum::ContactUs => route('admin.contact_messages.show', ['id' => $this->id]),
        };
    }
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            ComplaintStatusEnum::New->value => 'warning',
            ComplaintStatusEnum::Pending->value => 'info',
            ComplaintStatusEnum::Finished->value => 'success',
        };
    }
    public function getComplaintUrlAttribute(){
        return match ($this->type) {
            ComplaintTypesEnum::Complaint => route('admin.complaints.show', ['id' => $this->id]),
            ComplaintTypesEnum::ContactUs => route('admin.contact_messages.show', ['id' => $this->id]),
            ComplaintTypesEnum::OrderComplaint => route('admin.orders.show', ['id' => $this->order->id]),
            default => null,
        };
    }
    public static function boot()
    {
        self::creating(function ($model) {
            $lastId = self::max('id') ?? 0;
            $model->complaint_num = date('Y') . ($lastId + 1);
        });
        parent::boot();
    }

}
