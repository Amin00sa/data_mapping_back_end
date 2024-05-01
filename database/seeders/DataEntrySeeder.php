<?php

namespace Database\Seeders;

use App\Models\DataEntry;
use Illuminate\Database\Seeder;

class DataEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataEntry::factory()->count(100)->create();
    }
}
