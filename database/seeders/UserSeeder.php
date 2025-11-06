<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Staff',
                'email' => 'admin@sms.com',
                'password' => '@Super123',
                'role' => 'procurement',
                'department_code' => 'PROCR',
                'is_department_head' => true,
            ],
            [
                'name' => 'Accountant Staff',
                'email' => 'accountant@sms.com',
                'password' => '@Super123',
                'role' => 'accountant',
                'department_code' => 'FIN',
                'is_department_head' => true,
            ],
            [
                'name' => 'CS Faculty Staff',
                'email' => 'faculty_cs@sms.com',
                'role' => 'faculty',
                'password' => '@Super123',
                'department_code' => 'SCS',
                'is_department_head' => true,
            ],
            [
                'name' => 'SEAT Faculty Staff',
                'email' => 'faculty_seat@sms.com',
                'password' => '@Super123',
                'role' => 'faculty',
                'department_code' => 'SEAT',
                'is_department_head' => true,
            ],
        ];

        foreach ($users as $user) {
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
