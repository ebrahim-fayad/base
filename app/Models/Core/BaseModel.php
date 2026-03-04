<?php

namespace App\Models\Core;

use App\Models\AllUsers\DeliveryCompanyUpdate;
use Carbon\Carbon;
use App\Traits\UploadTrait;
use App\Models\AllUsers\PharmacyUpdate;
use Illuminate\Database\Eloquent\Model;
use App\Models\AllUsers\DeliveryManUpdate;

class BaseModel extends Model
{
    use UploadTrait;
    const IMAGEPATH = 'images';

    public function scopeSearch($query, $searchArray = [])
    {
        $query->where(function ($query) use ($searchArray) {
            if ($searchArray) {

                foreach ($searchArray as $key => $value) {

                    if ($key == 'is_parent') {
                        if ($value != null && $value !== '') {
                            if ($value == '1') {
                                $query->has('children');
                            } elseif ($value == '0') {
                                $query->doesntHave('children');
                            }
                        }
                    } elseif (str_contains($key, '_id') || str_contains($key, '_type')) {
                        if ($value != null && $value != "guest") {
                            $query->Where($key, $value);
                        } elseif ($value == "guest" && str_contains($key, '_type')) {
                            $query->WhereNull($key);
                        }
                    } elseif ($key == 'order') {
                    } elseif ($key == 'created_at_min') {
                        if ($value != null) {
                            $query->WhereDate('created_at', '>=', Carbon::createFromFormat('m-d-Y', $value));
                        }
                    } elseif ($key == 'created_at_max') {
                        if ($value != null) {
                            $query->WhereDate('created_at', '<=', Carbon::createFromFormat('m-d-Y', $value));
                        }
                    } elseif (str_contains($key, '.')) {
                        if ($value != null) {
                            [$relation, $column] = explode('.', $key);
                            $query->whereRelation($relation, $column, $value);
                        }
                    } else {
                        if ($value != null) {
                            $query->Where($key, 'like', '%' . $value . '%');
                        }
                    }
                }
            }
        });
        return $query->orderBy('created_at', request()->searchArray && isset(request()->searchArray['order']) ? request()->searchArray['order'] : 'DESC');
    }

    public function getImageAttribute()
    {
        if ($this->attributes['image'] != 'default.png' && $this->attributes['image'] != null) {
            $image = $this->getImage($this->attributes['image'], static::IMAGEPATH);
        } else {
            $image = $this->defaultImage(static::IMAGEPATH);
        }
        return $image;
    }
    public function getNotificationSoundAttribute()
    {
          if ($this->attributes['notification_sound'] != 'in.mp3' && $this->attributes['notification_sound'] != null) {
            return $this->getNotificationSound($this->attributes['notification_sound'], 'sounds');
        }
        return $this->defaultNotificationSound();
    }
    public function setImageAttribute($value)
    {
        if (null != $value && is_file($value)) {
            isset($this->attributes['image']) ? $this->deleteFile($this->attributes['image'], static::IMAGEPATH) : '';
            $this->attributes['image'] = $this->uploadAllTypes($value, static::IMAGEPATH);
        }
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public static function boot()
    {
        parent::boot();
        /* creating, created, updating, updated, deleting, deleted, forceDeleted, restored */

        static::deleted(function ($model) {
            if (isset($model->attributes['image'])) {
                $model->deleteFile($model->attributes['image'], static::IMAGEPATH);
            }
        });
    }
}
