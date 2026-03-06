<?php

namespace App\Models;

use App\Models\Core\BaseModel;
use Spatie\Translatable\HasTranslations;

class Country extends BaseModel
{
    use HasTranslations;
    const IMAGEPATH = 'countries';

    protected $fillable = ['name', 'key', 'flag'];

    public $translatable = ['name'];

    public function getFlagAttribute(): string
    {
        if ($this->attributes['flag']) {
            $flag = asset('admin/assets/flags/png/' . $this->attributes['flag']);
        } else {
            $flag = $this->defaultImage();
        }
        return $flag;
    }

    public function myFlag()
    {
        return $this->attributes['flag'];
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    /**
     * Default exportable columns configuration for Countries.
     *
     * @return array<int, array{label:string,value:string,default:bool}>
     */
    public static function exportColumns(): array
    {
        return [
            [
                'label' => '#',
                'value' => 'id',
                'default' => false,
            ],
            [
                'label' => __('admin.name'),
                'value' => 'name',
                'default' => true,
            ],
            [
                'label' => __('admin.country_code'),
                'value' => 'key',
                'default' => true,
            ],
            [
                'label' => __('admin.image'),
                'value' => 'flag',
                'default' => true,
            ],
        ];
    }
}
