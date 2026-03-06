<?php

namespace Database\Seeders\public_sections;

use App\Models\AllUsers\User;
use Illuminate\Database\Seeder;
use App\Enums\ComplaintTypesEnum;
use App\Models\PublicSections\Complaint;
use Faker\Factory as Faker;

class ComplaintTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ar_SA');
        $users = User::pluck('id')->toArray();
        $userCount = count($users);

        $data = $this->getComplaintData();

        // Create 30 complaints - mix of authenticated users and guests, complaints and contact us
        for ($i = 0; $i < 30; $i++) {
            $isAuthenticated = rand(0, 1);
            $isComplaint = rand(0, 1);
            $type = $isComplaint ? ComplaintTypesEnum::Complaint->value : ComplaintTypesEnum::ContactUs->value;

            if ($isAuthenticated && $userCount > 0) {
                $this->createAuthenticatedComplaint($users, $type, $isComplaint, $data);
            } else {
                $this->createGuestComplaint($faker, $type, $isComplaint, $data);
            }
        }
    }

    /**
     * Get complaint data arrays
     *
     * @return array
     */
    private function getComplaintData(): array
    {
        return [
            'complaintSubjects' => [
                'شكوى في الخدمة',
                'مشكلة في الطلب',
                'شكوى في المعاملة',
                'مشكلة في الدفع',
                'شكوى في التوصيل',
                'مشكلة في المنتج',
            ],
            'contactUsSubjects' => [
                'استفسار عن الخدمة',
                'طلب معلومات',
                'اقتراح تحسين',
                'تواصل عام',
                'استفسار عن الأسعار',
                'طلب مساعدة',
            ],
            'complaintMessages' => [
                'معاملة سيئة جداً من الموظف',
                'الخدمة لم تكن كما هو متوقع',
                'تأخير كبير في التوصيل',
                'المنتج غير مطابق للمواصفات',
                'مشكلة في الدفع والاسترجاع',
                'عدم الرد على الاستفسارات',
            ],
            'contactUsMessages' => [
                'أريد معرفة المزيد عن الخدمات المتاحة',
                'هل يمكن الحصول على معلومات إضافية؟',
                'أود اقتراح تحسينات على الخدمة',
                'أحتاج مساعدة في استخدام الموقع',
                'استفسار عن طريقة التسجيل',
                'أريد التواصل مع فريق الدعم',
            ],
        ];
    }

    /**
     * Create complaint from authenticated user
     *
     * @param array $users
     * @param int $type
     * @param bool $isComplaint
     * @param array $data
     * @return void
     */
    private function createAuthenticatedComplaint(array $users, int $type, bool $isComplaint, array $data): void
    {
        $user = User::find($users[array_rand($users)]);

        Complaint::create([
            'user_name' => $user->name,
            'phone' => $user->country_code . $user->phone,
            'email' => $user->email,
            'complaintable_id' => $user->id,
            'complaintable_type' => User::class,
            'type' => $type,
            'subject' => $isComplaint
                ? $data['complaintSubjects'][array_rand($data['complaintSubjects'])]
                : $data['contactUsSubjects'][array_rand($data['contactUsSubjects'])],
            'complaint' => $isComplaint
                ? $data['complaintMessages'][array_rand($data['complaintMessages'])]
                : $data['contactUsMessages'][array_rand($data['contactUsMessages'])],
        ]);
    }

    /**
     * Create complaint from guest
     *
     * @param \Faker\Generator $faker
     * @param int $type
     * @param bool $isComplaint
     * @param array $data
     * @return void
     */
    private function createGuestComplaint($faker, int $type, bool $isComplaint, array $data): void
    {
        Complaint::create([
            'user_name' => $faker->name,
            'phone' => '966' . $faker->numerify('########'),
            'email' => $faker->email,
            'complaintable_id' => null,
            'complaintable_type' => null,
            'type' => $type,
            'subject' => $isComplaint
                ? $data['complaintSubjects'][array_rand($data['complaintSubjects'])]
                : $data['contactUsSubjects'][array_rand($data['contactUsSubjects'])],
            'complaint' => $isComplaint
                ? $data['complaintMessages'][array_rand($data['complaintMessages'])]
                : $data['contactUsMessages'][array_rand($data['contactUsMessages'])],
        ]);
    }
}
