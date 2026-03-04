<?php

namespace App\Models\Core;

use App\Models\Core\BaseModel;
use Spatie\Translatable\HasTranslations;

class Page extends BaseModel
{
    use HasTranslations;
    const IMAGEPATH = 'pages';
    protected $fillable = ['title', 'slug', 'content','image'];
    public $translatable = ['title', 'content'];
}
