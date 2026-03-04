<?php

namespace App\Services\Programs;

use App\Models\Programs\Level;
use App\Services\Core\BaseService;
use Illuminate\Database\Eloquent\Model;

class LevelService extends BaseService
{
    public function __construct()
    {
        $this->model = Level::class;
    }

    public function create(array $data): Model
    {
        $level = parent::create($data);
        for ($day = 1; $day <= Level::DURATION_DAYS; $day++) {
            $level->days()->create(['day_number' => $day]);
        }
        return $level;
    }
}
