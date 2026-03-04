<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;

class Copy extends BaseModel
{
    use HasTranslations; 

    const IMAGEPATH = 'copys' ; 
    protected $fillable = ['title','description' ,'image'];
    public $translatable = ['title','description'];
    
}
