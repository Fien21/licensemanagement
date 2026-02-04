<?php

namespace Database\Seeders;

use App\Models\License;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            License::create([
                'vendo_box_no' => $faker->unique()->numerify('VENDO-####'),
                'vendo_machine' => $faker->randomElement(['PISOFI', 'LPB']),
                'license' => $faker->uuid,
                'device_id' => $faker->macAddress,
                'description' => $faker->sentence,
                'date' => $faker->date(),
                'technician' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'customer_name' => $faker->name,
                'address' => $faker->address,
                'contact' => $faker->phoneNumber,
                'status' => $faker->randomElement(['active', 'inactive', 'expired']),
            ]);
        }
    }
}
