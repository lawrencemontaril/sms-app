<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /*
    | -------------------------
    |  Run the database seeds.
    | -------------------------
    */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Procurement',
                'code' => 'PROCR'
            ],
            [
                'name' => 'Finance',
                'code' => 'FIN'
            ],
            [
                'name' => 'School of Computer Studies',
                'code' => 'SCS'
            ],
            [
                'name' => 'School of Engineering, Architecture, and Technology',
                'code' => 'SEAT'
            ],
        ];

        foreach ($departments as $department) {
            Department::firstOrCreate(
                ['code' => $department['code']],
                [
                    'name' => $department['name'],
                ]
            );
        }
    }
}
