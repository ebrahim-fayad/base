<?php

namespace App\Models\Core;

use App\Models\AllUsers\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminNotificationLog extends Model
{
    protected $fillable = [
        'admin_id',
        'type',
        'user_type',
        'title_ar',
        'title_en',
        'body_ar',
        'body_en',
        'body',
        'recipients_count',
    ];

    protected $casts = [
        'recipients_count' => 'integer',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function getTitleAttribute(): ?string
    {
        return lang() === 'ar' ? $this->title_ar : $this->title_en;
    }
}
