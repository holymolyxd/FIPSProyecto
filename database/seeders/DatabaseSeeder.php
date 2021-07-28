<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GendersSeeder::class);
        $this->call(RegionsCommunesVenuesSeeder::class);
        $this->call(RolesPermissionsSeeder::class);
        #\App\Models\User::factory(400)->create();
        $this->call(InstitutionAreaCareerSemesterSubjectSeeder::class);
    }
}
