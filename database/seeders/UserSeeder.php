<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /*
    | -------------------------
    |  Run the database seeds.
    | -------------------------
    */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Harlene Muñoz',
                'email' => 'harlenemunoz@gmail.com',
                'role' => 'procurement',
                'password' => 'Admin@123',
                'department_code' => 'PROCR',
                'is_department_head' => true,
            ],
            [
                'name' => 'Christine Ann Taborda',
                'email' => 'christineanntaborda@gmail.com',
                'role' => 'accountant',
                'password' => 'Accountant@123',
                'department_code' => 'FIN',
                'is_department_head' => true,
            ],
            [
                'name' => 'Maricon Olfindo',
                'email' => 'mariconolfindo@gmail.com',
                'role' => 'faculty',
                'password' => 'Faculty@123',
                'department_code' => 'SCS',
                'is_department_head' => true,
            ],
            [
                'name' => 'Jenjie Dela Peña',
                'email' => 'jenjiedelapena@gmail.com',
                'role' => 'faculty',
                'password' => 'Faculty@123',
                'department_code' => 'SCS',
                'is_department_head' => false,
            ],
            [
                'name' => 'Jayson Nati',
                'email' => 'jaysonnati@gmail.com',
                'role' => 'faculty',
                'password' => 'Faculty@123',
                'department_code' => 'SCS',
                'is_department_head' => false,
            ],
            [
                'name' => 'Cathleen Aliyah Catenza',
                'email' => 'cathleenaliyahcatenza@gmail.com',
                'role' => 'faculty',
                'password' => 'Faculty@123',
                'department_code' => 'SEAT',
                'is_department_head' => true,
            ],
            [
                'name' => 'Alwyn Matthew Balosa',
                'email' => 'alwynmatthewbalosa@gmail.com',
                'role' => 'faculty',
                'password' => 'Faculty@123',
                'department_code' => 'SEAT',
                'is_department_head' => false,
            ],
        ];

        foreach($users as $user) {
            $department = Department::where('code', $user['department_code'])->firstOrFail();

            $userInstance = User::firstOrCreate([
                'email' => $user['email'],
            ], [
                'department_id' => $department->id,
                'name' => $user['name'],
                'password' => $user['password'],
            ]);

            $userInstance->syncRoles($user['role']);

            if ($user['is_department_head']) {
                $department->user()->associate($userInstance);
                $department->save();
            }
        }
    }
}
