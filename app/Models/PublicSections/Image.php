<?php

namespace App\Models\PublicSections;

use App\Models\Core\BaseModel;
use Spatie\Translatable\HasTranslations;

class Image extends BaseModel
{
    use HasTranslations;
    const IMAGEPATH = 'images' ;
    protected $fillable = ['image', 'title'];
    public $translatable = ['title'];
}
