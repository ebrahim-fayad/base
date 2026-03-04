<?php

namespace App\Traits\Admin\AuthBaseModel;

use App\Mail\SendCode;
use App\Services\Sms\SmsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

trait HelperFunctions
{
    public function scopeSearch($query, $searchArray = [])
    {
        $query->where(function ($query) use ($searchArray) {
            if ($searchArray) {
                foreach ($searchArray as $key => $value) {
                    if (str_contains($key, '_id')) {
                        if (null != $value) {
                            $query->Where($key, $value);
                        }
                    } elseif ('order' == $key) {
                    } elseif ('created_at_min' == $key) {
                        if (null != $value) {
                            $query->WhereDate('created_at', '>=', Carbon::createFromFormat('m-d-Y', $value));
                        }
                    } elseif ('created_at_max' == $key) {
                        if (null != $value) {
                            $query->WhereDate('created_at', '<=', Carbon::createFromFormat('m-d-Y', $value));
                        }
                    } else {
                        if (null != $value) {
                            $query->Where($key, 'like', '%' . $value . '%');
                        }
                    }
                }
            }
        });
        return $query->orderBy('id', request()->searchArray && isset(request()->searchArray['order']) ? request()->searchArray['order'] : 'DESC');
    }

    public function markAsActive()
    {
        $this->update(['code' => null, 'code_expire' => null, 'active' => true]);
        return $this;
    }

    public function sendVerificationCode(): array
    {
        $this->update([
            'code'        => $this->activationCode(),
            'code_expire' => Carbon::now()->addMinutes(5),
        ]);
        $this->sendCodeAtSms($this->code);
        return ['user' => $this];
    }

    private function activationCode(): int
    {
        return 1234;
        //        return mt_rand(1111, 9999);
    }

    public function sendCodeAtSms($code, $full_phone = null)
    {
        return false;
        (new SmsService())->sendSms($full_phone ?? $this->full_phone, trans('apis.activeCode') . $code);
    }

    public function sendCodeAtEmail($code, $email = null): void
    {
        try {
            Mail::to($email ?? $this->email)->send(new SendCode($code, $this->name));
        } catch (\Exception $e) {
            info('Failed to send email: ' . $e->getMessage());
        }
    }

    public function login()
    {
        // $this->tokens()->delete();
        $this->updateDevice();
        $this->updateLang();

//        if (!$this['parent_id']) {
        $token = $this->createToken(request()->device_type ?? 'device')->plainTextToken;
//        } else {
//            $token = $this->getAbilitiesAndSetTokenAbility($this, request()->device_type);
//        }

        return $token;
    }

    public function updateLang()
    {
        if (
            request()->header('Lang') != null
            && in_array(request()->header('Lang'), languages())
        ) {
            $this->update(['lang' => request()->header('Lang')]);
        } else {
            $this->update(['lang' => defaultLang()]);
        }
    }

    public function updateDevice()
    {
        if (request()->device_id) {
            $this->devices()->updateOrCreate([
                'device_id'   => request()->device_id,
                'device_type' => request()->device_type,
                'lang'        => request()->lang
            ]);
        }
    }

    public function logout($request = null)
    {
        $this->currentAccessToken()->delete();
        if ($request?->device_id) {
            $this->devices()->where(['device_id' => $request?->device_id])->delete();
        }
        return true;
    }

    public static function boot()
    {
        parent::boot();
        /* creating, created, updating, updated, deleting, deleted, forceDeleted, restored */

        static::deleted(function ($model) {
            $model->deleteFile($model->attributes['image'], self::IMAGEPATH);
        });

    }
}
