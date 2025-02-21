<?php

namespace Database\Seeders;

use App\Models\Movement;
use Illuminate\Database\Seeder;

class MovementSeeder extends Seeder
{
    public function run()
    {
        Movement::factory(50)->create();
    }
}
