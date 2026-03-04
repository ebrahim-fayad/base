<?php

namespace App\Traits\Providers;

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
            $this->attributes['image'] = is_file($value) ? $this->uploadAllTypes($value, static::IMAGEPATH) : $value;
        }
    }
    public function getCommercialImageAttribute(): string
    {
        if ($this->attributes['commercial_image']) {
            $image = $this->getImage($this->attributes['commercial_image'], static::IMAGEPATH);
        } else {
            $image = $this->defaultImage('users');
        }
        return $image;
    }
    public function setCommercialImageAttribute($value)
    {
        if (null != $value) {
            isset($this->attributes['commercial_image']) ? $this->deleteFile($this->attributes['commercial_image'], static::IMAGEPATH) : '';
            $this->attributes['commercial_image'] = is_file($value) ? $this->uploadAllTypes($value, static::IMAGEPATH) : $value;
        }
    }





}
