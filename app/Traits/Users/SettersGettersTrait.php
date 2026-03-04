<?php

namespace App\Traits\Users;

trait SettersGettersTrait
{
    public function setPhoneAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['phone'] = fixPhone($value);
        }
    }

    public function setCountryCodeAttribute($value): void
    {
        if (!empty($value)) {
            $this->attributes['country_code'] = fixPhone($value);
        }
    }

    public function getFullPhoneAttribute(): string
    {
        return $this->attributes['country_code'] . $this->attributes['phone'];
    }

    public function getImageAttribute(): string
    {
        if ($this->attributes['image']) {
            $image = $this->getImage($this->attributes['image'], static::IMAGEPATH);
        } else {
            $image = $this->defaultImage('users');
        }
        return $image;
    }


    public function setImageAttribute($value)
    {
        if (null != $value) {
            isset($this->attributes['image']) ? $this->deleteFile($this->attributes['image'], static::IMAGEPATH) : '';
            $this->attributes['image'] = is_file($value) ? $this->uploadAllTypes($value, static::IMAGEPATH): $value;
        }
    }

    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

}
