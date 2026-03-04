<?php

namespace Database\Seeders\programs;

use App\Models\Programs\Level;
use App\Models\Programs\LevelDay;
use Illuminate\Database\Seeder;

class ProgramTableSeeder extends Seeder
{
    public function run(): void
    {
        $levelsData = [
            ['ar' => 'مستوى المبتدئين', 'en' => 'Beginner Level'],
            ['ar' => 'مستوى إنقاص الوزن', 'en' => 'Weight Loss Level'],
            ['ar' => 'مستوى بناء العضلات', 'en' => 'Muscle Building Level'],
            ['ar' => 'مستوى التحمل', 'en' => 'Endurance Level'],
            ['ar' => 'مستوى المرونة', 'en' => 'Flexibility Level'],
            ['ar' => 'مستوى القوة الوظيفية', 'en' => 'Functional Strength Level'],
            ['ar' => 'مستوى اللياقة العامة', 'en' => 'General Fitness Level'],
            ['ar' => 'مستوى حرق الدهون المتقدم', 'en' => 'Advanced Fat Burn Level'],
            ['ar' => 'مستوى HIIT', 'en' => 'HIIT Level'],
            ['ar' => 'مستوى الاستشفاء', 'en' => 'Recovery Level'],
            ['ar' => 'مستوى القوة العضلية', 'en' => 'Muscular Strength Level'],
            ['ar' => 'مستوى التوازن', 'en' => 'Balance Level'],
            ['ar' => 'مستوى القلب والأوعية', 'en' => 'Cardiovascular Level'],
            ['ar' => 'مستوى الكور', 'en' => 'Core Level'],
            ['ar' => 'مستوى القوة التفجيرية', 'en' => 'Explosive Power Level'],
            ['ar' => 'مستوى التحمل العضلي', 'en' => 'Muscular Endurance Level'],
            ['ar' => 'مستوى اللياقة المنزلية', 'en' => 'Home Fitness Level'],
            ['ar' => 'مستوى الأداء الرياضي', 'en' => 'Sports Performance Level'],
            ['ar' => 'مستوى المحترفين', 'en' => 'Pro Level'],
            ['ar' => 'مستوى البطل', 'en' => 'Champion Level'],
        ];

        $descriptions = [
            ['ar' => 'برنامج تدريبي للمبتدئين يركز على الأساسيات وبناء القوة البدنية', 'en' => 'Training program for beginners focusing on basics and building physical strength'],
            ['ar' => 'برنامج مكثف لحرق الدهون وإنقاص الوزن بشكل صحي', 'en' => 'Intensive program for burning fat and healthy weight loss'],
            ['ar' => 'برنامج متقدم لبناء الكتلة العضلية وزيادة القوة', 'en' => 'Advanced program for building muscle mass and increasing strength'],
            ['ar' => 'برنامج لتحسين التحمل والقدرة على الاستمرار', 'en' => 'Program to improve endurance and stamina'],
            ['ar' => 'برنامج لتحسين المرونة وحركة المفاصل', 'en' => 'Program to improve flexibility and joint mobility'],
            ['ar' => 'برنامج القوة الوظيفية للأنشطة اليومية', 'en' => 'Functional strength program for daily activities'],
            ['ar' => 'برنامج شامل لللياقة البدنية العامة', 'en' => 'Comprehensive general fitness program'],
            ['ar' => 'برنامج متقدم لحرق الدهون وشد الجسم', 'en' => 'Advanced fat burning and body toning program'],
            ['ar' => 'تمارين عالية الكثافة لفترات قصيرة', 'en' => 'High intensity interval training'],
            ['ar' => 'برنامج استشفاء وتمدد وتهدئة', 'en' => 'Recovery, stretching and cool-down program'],
            ['ar' => 'تركيز على بناء القوة العضلية القصوى', 'en' => 'Focus on building maximum muscular strength'],
            ['ar' => 'تمارين توازن واستقرار', 'en' => 'Balance and stability exercises'],
            ['ar' => 'تحسين صحة القلب والأوعية الدموية', 'en' => 'Improve cardiovascular health'],
            ['ar' => 'تركيز على عضلات البطن والظهر', 'en' => 'Focus on abs and back muscles'],
            ['ar' => 'تمارين قوة تفجيرية وسرعة', 'en' => 'Explosive power and speed exercises'],
            ['ar' => 'تحسين التحمل العضلي والتكرارات', 'en' => 'Improve muscular endurance and reps'],
            ['ar' => 'لياقة كاملة من المنزل بدون معدات', 'en' => 'Full fitness from home with no equipment'],
            ['ar' => 'برنامج لأداء رياضي أفضل', 'en' => 'Program for better sports performance'],
            ['ar' => 'برنامج للمحترفين والمتقدمين جداً', 'en' => 'Program for pros and very advanced'],
            ['ar' => 'أعلى مستوى تحدي وإنجاز', 'en' => 'Highest challenge and achievement level'],
        ];

        foreach ($levelsData as $order => $name) {
            $level = Level::create([
                'name' => $name,
                'description' => $descriptions[$order] ?? $descriptions[0],
                'subscription_price' => $order === 0 ? 0 : (50 + $order * 15),
                'active' => true,
                'level_number' => 'المستوى ' . ($order + 1),
                'order' => $order + 1,
            ]);
            for ($day = 1; $day <= Level::DURATION_DAYS; $day++) {
                $level->days()->create(['day_number' => $day]);
            }
        }
    }
}
