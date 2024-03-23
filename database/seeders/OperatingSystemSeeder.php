<?php

namespace Database\Seeders;

use App\Models\OperatingSystem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperatingSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OperatingSystem::factory()->count(3)->create();
    }
}
