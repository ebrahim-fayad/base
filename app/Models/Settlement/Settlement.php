<?php

namespace App\Models\Settlement;


use App\Models\Core\BaseModel;
use App\Models\Order;
use App\Observers\SettlementObserver;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Models\CancelReason;

#[ObservedBy(SettlementObserver::class)]
class Settlement extends BaseModel
{
    use HasTranslations;
    const IMAGEPATH = 'settlements';
    protected $fillable = [
        'name',
        'country_id',
        'order_num',
        'settlementable_id',
        'settlementable_type',
        'total',
        'net_total',
        'commission_amount',
        'vat_amount',
        'status',
        'image',
        'cancel_reason',
    ];

    public function settlementable(): MorphTo
    {
        //? rel with pharmacy
        return $this->morphTo();
    }

    public function getSettlementNumAttribute(): string
    {
        return '#' . $this->id;
    }

    public function getTotalAmountAttribute(): float
    {
        return (float) ($this->attributes['total'] ?? 0);
    }

    public function getNetAmountAttribute(): float
    {
        return (float) ($this->attributes['net_total'] ?? 0);
    }

    public function getPaymentGatewayAmountAttribute(): float
    {
        $amount = $this->orders()->sum('payment_amount');
        return  $amount;
    }

    public function getProviderAttribute()
    {
        return $this->settlementable;
    }
    public function settlementItems(): HasMany
    {
        return $this->hasMany(SettlementItem::class);
    }

    public function orders(): MorphToMany
    {
        return $this->morphedByMany(Order::class, 'orderable', 'settlement_items');
    }

    /**
     * Search scope: handle settlement_num (virtual attribute) by searching id.
     */
    public function scopeSearch($query, $searchArray = [])
    {
        if (! empty($searchArray['settlement_num'] ?? null)) {
            $value = preg_replace('/[^0-9]/', '', $searchArray['settlement_num']);
            if ($value !== '') {
                $query->where('id', (int) $value);
            }
            $searchArray = collect($searchArray)->except('settlement_num')->all();
        }

        return parent::scopeSearch($query, $searchArray);
    }
}
