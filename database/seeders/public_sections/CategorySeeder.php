<?php

namespace Database\Seeders\public_sections;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء 10 أقسام رئيسية
        $parentCategories = [
            [
                'name' => [
                    'ar' => 'عناية وجمال',
                    'en' => 'Beauty and Care',
                ],
                'image' => 'beauty.png',
            ],
            [
                'name' => [
                    'ar' => 'مطاعم',
                    'en' => 'Restaurants',
                ],
                'image' => 'restaurants.png',
            ],
            [
                'name' => [
                    'ar' => 'رياضة',
                    'en' => 'Sports',
                ],
                'image' => 'sports.png',
            ],
            [
                'name' => [
                    'ar' => 'صحة وطب',
                    'en' => 'Health and Medical',
                ],
                'image' => 'health.png',
            ],
            [
                'name' => [
                    'ar' => 'تعليم',
                    'en' => 'Education',
                ],
                'image' => 'education.png',
            ],
            [
                'name' => [
                    'ar' => 'تكنولوجيا',
                    'en' => 'Technology',
                ],
                'image' => 'technology.png',
            ],
            [
                'name' => [
                    'ar' => 'نقل ومواصلات',
                    'en' => 'Transportation',
                ],
                'image' => 'transportation.png',
            ],
            [
                'name' => [
                    'ar' => 'ترفيه',
                    'en' => 'Entertainment',
                ],
                'image' => 'entertainment.png',
            ],
            [
                'name' => [
                    'ar' => 'خدمات منزلية',
                    'en' => 'Home Services',
                ],
                'image' => 'home-services.png',
            ],
            [
                'name' => [
                    'ar' => 'تسوق',
                    'en' => 'Shopping',
                ],
                'image' => 'shopping.png',
            ],
        ];

        // حفظ معرفات الأقسام الرئيسية
        $parentIds = [];
        foreach ($parentCategories as $category) {
            $created = Category::create($category);
            $parentIds[] = $created->id;
        }

        // إنشاء 20 قسم فرعي (2 لكل قسم رئيسي)
        $childCategories = [
            // تحت عناية وجمال (0)
            [
                'name' => [
                    'ar' => 'تجميلية',
                    'en' => 'Beauty',
                ],
                'image' => 'beauty.png',
                'parent_id' => $parentIds[0],
            ],
            [
                'name' => [
                    'ar' => 'عناية بالبشرة',
                    'en' => 'Skincare',
                ],
                'image' => 'skincare.png',
                'parent_id' => $parentIds[0],
            ],
            // تحت مطاعم (1)
            [
                'name' => [
                    'ar' => 'مطاعم عربية',
                    'en' => 'Arabic Restaurants',
                ],
                'image' => 'arabic-restaurants.png',
                'parent_id' => $parentIds[1],
            ],
            [
                'name' => [
                    'ar' => 'مطاعم عالمية',
                    'en' => 'International Restaurants',
                ],
                'image' => 'international-restaurants.png',
                'parent_id' => $parentIds[1],
            ],
            // تحت رياضة (2)
            [
                'name' => [
                    'ar' => 'لياقة بدنية',
                    'en' => 'Fitness',
                ],
                'image' => 'fitness.png',
                'parent_id' => $parentIds[2],
            ],
            [
                'name' => [
                    'ar' => 'رياضات مائية',
                    'en' => 'Water Sports',
                ],
                'image' => 'water-sports.png',
                'parent_id' => $parentIds[2],
            ],
            // تحت صحة وطب (3)
            [
                'name' => [
                    'ar' => 'عيادات',
                    'en' => 'Clinics',
                ],
                'image' => 'clinics.png',
                'parent_id' => $parentIds[3],
            ],
            [
                'name' => [
                    'ar' => 'صيدليات',
                    'en' => 'Pharmacies',
                ],
                'image' => 'pharmacies.png',
                'parent_id' => $parentIds[3],
            ],
            // تحت تعليم (4)
            [
                'name' => [
                    'ar' => 'دورات تدريبية',
                    'en' => 'Training Courses',
                ],
                'image' => 'training-courses.png',
                'parent_id' => $parentIds[4],
            ],
            [
                'name' => [
                    'ar' => 'مدارس',
                    'en' => 'Schools',
                ],
                'image' => 'schools.png',
                'parent_id' => $parentIds[4],
            ],
            // تحت تكنولوجيا (5)
            [
                'name' => [
                    'ar' => 'برمجة',
                    'en' => 'Programming',
                ],
                'image' => 'programming.png',
                'parent_id' => $parentIds[5],
            ],
            [
                'name' => [
                    'ar' => 'صيانة أجهزة',
                    'en' => 'Device Repair',
                ],
                'image' => 'device-repair.png',
                'parent_id' => $parentIds[5],
            ],
            // تحت نقل ومواصلات (6)
            [
                'name' => [
                    'ar' => 'تاكسي',
                    'en' => 'Taxi',
                ],
                'image' => 'taxi.png',
                'parent_id' => $parentIds[6],
            ],
            [
                'name' => [
                    'ar' => 'توصيل',
                    'en' => 'Delivery',
                ],
                'image' => 'delivery.png',
                'parent_id' => $parentIds[6],
            ],
            // تحت ترفيه (7)
            [
                'name' => [
                    'ar' => 'سينما',
                    'en' => 'Cinema',
                ],
                'image' => 'cinema.png',
                'parent_id' => $parentIds[7],
            ],
            [
                'name' => [
                    'ar' => 'حدائق ترفيهية',
                    'en' => 'Amusement Parks',
                ],
                'image' => 'amusement-parks.png',
                'parent_id' => $parentIds[7],
            ],
            // تحت خدمات منزلية (8)
            [
                'name' => [
                    'ar' => 'تنظيف',
                    'en' => 'Cleaning',
                ],
                'image' => 'cleaning.png',
                'parent_id' => $parentIds[8],
            ],
            [
                'name' => [
                    'ar' => 'صيانة',
                    'en' => 'Maintenance',
                ],
                'image' => 'maintenance.png',
                'parent_id' => $parentIds[8],
            ],
            // تحت تسوق (9)
            [
                'name' => [
                    'ar' => 'ملابس',
                    'en' => 'Clothing',
                ],
                'image' => 'clothing.png',
                'parent_id' => $parentIds[9],
            ],
            [
                'name' => [
                    'ar' => 'إلكترونيات',
                    'en' => 'Electronics',
                ],
                'image' => 'electronics.png',
                'parent_id' => $parentIds[9],
            ],
        ];

        foreach ($childCategories as $category) {
            Category::create($category);
        }
    }
}
