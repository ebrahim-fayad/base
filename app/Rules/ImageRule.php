<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageRule implements Rule
{
    protected $maxSize; // الحجم بالـ KB
    protected $mimes;

    public function __construct($maxSize = 2048, $mimes = [])
    {
        $this->maxSize = $maxSize;
        $this->mimes = $mimes ?: ['jpeg','jpg','png','gif','bmp','svg','webp','tiff','ico'];
    }

    public function passes($attribute, $value)
    {
        if (!$value->isValid()) {
            return false;
        }

        // تحقق من MIME type
        $extension = strtolower($value->getClientOriginalExtension());
        if (!in_array($extension, $this->mimes)) {
            return false;
        }

        // تحقق من الحجم
        if ($value->getSize() / 1024 > $this->maxSize) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return __('admin.valid_image', [
            'types' => implode(', ', $this->mimes),
            'max' => $this->maxSize / 1024
        ]);
    }
}
