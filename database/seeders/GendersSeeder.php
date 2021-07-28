<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GendersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insertGenders();
    }

    public function insertGenders(): void
    {
        $now = now();
        $genders = [
            ['No Informado'],
            ['Masculino'],
            ['Femenino'],
        ];

        $genders = array_map(function ($gender) use ($now){
            return [
                'name' => $gender[0],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $genders);

        DB::table('genders')->insert($genders);
    }
}
