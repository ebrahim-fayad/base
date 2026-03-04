<?php

namespace App\Models;

use App\Models\AllUsers\User;
use App\Enums\OrderStatusEnum;
use App\Models\Core\BaseModel;
use App\Enums\PaymentMethodEnum;
use App\Models\AllUsers\Provider;
use App\Models\PublicSections\Complaint;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends BaseModel
{
    protected $fillable = ['order_num', 'user_id', 'provider_id','service_id', 'price', 'vat_amount', 'total_price', 'admin_commission', 'payment_amount', 'status', 'payment_method', 'receiver_name', 'country_code', 'phone', 'sender_name', 'message', 'auto_cancelled_at', 'net_provider_amount', 'receiver_date_time','is_settled','is_settled_vat','job_id'];
    protected $casts = [
        'auto_cancelled_at' => 'datetime',
        'receiver_date_time' => 'datetime',
        'is_settled' => 'boolean',
        'is_settled_vat' => 'boolean',
        'status' => OrderStatusEnum::class,
        'payment_method' => PaymentMethodEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    public function getStatusTextAttribute()
    {
        return OrderStatusEnum::getTranslatedName($this->status->value,'orderStatusEnum');
    }

    public static function boot()
    {
        self::creating(function ($model) {
            $lastId = self::max('id') ?? 0;
            $model->order_num = date('Y') . ($lastId + 1);
        });
        parent::boot();
    }
}
