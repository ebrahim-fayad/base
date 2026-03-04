<?php

namespace App\Models\Settlement;

use App\Enums\Categories\ConsultationCourseTypesEnum;
use App\Enums\Orders\OrderTypesEnum;
use App\Models\Core\BaseModel;
use App\Models\Orders\Consultation;
use App\Models\Orders\PartialServiceOrder;
use App\Models\Orders\Research;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Translatable\HasTranslations;

class SettlementItem extends BaseModel
{
    use HasTranslations;

    const IMAGEPATH = 'settlements';
    protected $fillable = [
        'settlement_id',
        'orderable_id',
        'orderable_type',
    ];
    protected $appends = ['type'];

    public function orderable(): MorphTo
    {
        //? rel with orders
        return $this->morphTo();
    }

    public function settlement(): BelongsTo
    {
        return $this->belongsTo(Settlement::class);
    }

}
