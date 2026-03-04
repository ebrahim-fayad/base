<?php

namespace Database\Seeders\programs;

use App\Models\Programs\Exercise;
use App\Models\Programs\Level;
use App\Models\Programs\LevelDay;
use Illuminate\Database\Seeder;

class DailyActivityTableSeeder extends Seeder
{
    protected array $activities = [
        ['ar' => 'المشي السريع', 'en' => 'Brisk Walking'],
        ['ar' => 'تمارين القرفصاء', 'en' => 'Squats'],
        ['ar' => 'تمارين الضغط', 'en' => 'Push-ups'],
        ['ar' => 'تمارين البلانك', 'en' => 'Plank'],
        ['ar' => 'القفز بالحبل', 'en' => 'Jump Rope'],
        ['ar' => 'تمارين الركض في المكان', 'en' => 'Running in Place'],
        ['ar' => 'تمارين المعدة', 'en' => 'Abdominal Exercises'],
        ['ar' => 'تمارين التمدد', 'en' => 'Stretching'],
    ];

    protected array $descriptions = [
        ['ar' => 'المشي لمدة 20 دقيقة بوتيرة سريعة', 'en' => 'Walk for 20 minutes at a brisk pace'],
        ['ar' => '3 مجموعات من 15 تكرار', 'en' => '3 sets of 15 reps'],
        ['ar' => '3 مجموعات من 10 تكرار', 'en' => '3 sets of 10 reps'],
        ['ar' => 'حبس الوضعية لمدة 30 ثانية', 'en' => 'Hold position for 30 seconds'],
        ['ar' => 'القفز لمدة 5 دقائق', 'en' => 'Jump for 5 minutes'],
        ['ar' => 'الركض لمدة 10 دقائق', 'en' => 'Run for 10 minutes'],
        ['ar' => '3 مجموعات من 20 تكرار', 'en' => '3 sets of 20 reps'],
        ['ar' => 'تمارين تمدد لمدة 10 دقائق', 'en' => 'Stretching exercises for 10 minutes'],
    ];

    public const EXERCISES_PER_DAY_FIRST_LEVEL = 4;

    public function run(): void
    {

        $levelsWithFullExercises = Level::with('days')->orderBy('order')->limit(5)->get();

        foreach ($levelsWithFullExercises as $level) {
            foreach ($level->days as $day) {
                for ($i = 0; $i < self::EXERCISES_PER_DAY_FIRST_LEVEL; $i++) {
                    $day->exercises()->create([
                        'exercise_name' => $this->activities[$i % count($this->activities)],
                        'description' => $this->descriptions[$i % count($this->descriptions)],
                        'incentive_points' => rand(5, 25),
                    ]);
                }
            }
        }

        $otherLevelDays = LevelDay::whereNotIn('level_id', $levelsWithFullExercises->pluck('id'))->get();

        foreach ($otherLevelDays as $day) {
            $count = rand(1, 3);
            for ($i = 0; $i < $count; $i++) {
                $index = (($day->id + $i) % count($this->activities));
                $day->exercises()->create([
                    'exercise_name' => $this->activities[$index],
                    'description' => $this->descriptions[$index],
                    'incentive_points' => rand(5, 20),
                ]);
            }
        }
    }
}
