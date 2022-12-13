<?php

namespace Database\Seeders;

use App\Models\Compony;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComponySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Compony::create([
            'name' => "ooredoo",
            'email' => "ooredoo@admin.com",
            'mobile' => "12324456",
            'city_id' => 1,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ])->syncRoles(['super Admin']);


    }
}
