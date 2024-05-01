<?php

namespace Database\Seeders;

use App\Models\ExternalDataBase;
use Illuminate\Database\Seeder;

class ExternalDataBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExternalDataBase::factory()->count(100)->create();
    }
}
