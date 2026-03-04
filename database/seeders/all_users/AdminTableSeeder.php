<?php
namespace Database\Seeders\all_users;

use App\Models\AllUsers\Admin;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'name'     => 'Manager',
            'email'    => 'admin@admin.com',
            'phone'    => '0555105813',
            'password' => 123456,
            'type'     => 'super_admin',
          ]);
    }
}
