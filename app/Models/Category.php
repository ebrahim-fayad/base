<?php

namespace App\Models;

use App\Models\Core\BaseModel;
use Spatie\Translatable\HasTranslations;

class Category extends BaseModel
{
    use HasTranslations;
    const IMAGEPATH = 'categories';
    protected $fillable = ['name', 'image','parent_id'];
    public $translatable = ['name'];
    protected $casts = [
        'name' => 'array',
    ];
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
