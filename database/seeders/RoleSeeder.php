<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['super', 'admin', 'doctor', 'patient', 'receptionist'];
        $superPermissions = [
            'user',
            'appointment',
            'image',
            'medicine',
            'coupon',
            'slot',
            'questionnaire',
            'order',
            'certificate',
            'tag',
            'prescription',
            'setting',
            'category',
            'country'
        ];
        $doctorPermissions = [
            'appointment',
            'medicine',
            'prescription',
            'tag',
        ];
        $receptionistPermissions = [
            'user',
            'image',
            'appointment',
            'medicine',
            'prescription',
            'tag',
            'coupon',
            'slot',
            'questionnaire',
            'order',
            'certificate',
            'category',
            'country'
        ];
        $permissions =
            [
                'user',
                'image',
                'appointment',
                'medicine',
                'prescription',
                'tag',
                'coupon',
                'slot',
                'questionnaire',
                'order',
                'certificate',
                'setting',
                'category',
                'country'
            ];
        foreach ($permissions as $per) {
            Permission::create(["name" => $per . "_index"]);
            Permission::create(["name" => $per . "_create"]);
            Permission::create(["name" => $per . "_edit"]);
            Permission::create(["name" => $per . "_delete"]);
        }
        foreach ($roles as $role) {
            $currentRole = Role::create(["name" => $role]);
            if ($role === "super") {
                foreach ($superPermissions as $per) {
                    Permission::where(["name" => $per . "_index"])->first()->assignRole($currentRole);
                    Permission::where(["name" => $per . "_create"])->first()->assignRole($currentRole);
                    Permission::where(["name" => $per . "_edit"])->first()->assignRole($currentRole);
                    Permission::where(["name" => $per . "_delete"])->first()->assignRole($currentRole);
                }
            }
            if ($role === "admin") {
                foreach ($superPermissions as $per) {
                    Permission::where(["name" => $per . "_index"])->first()->assignRole($currentRole);
                    Permission::where(["name" => $per . "_create"])->first()->assignRole($currentRole);
                    Permission::where(["name" => $per . "_edit"])->first()->assignRole($currentRole);
                }
            }

            if ($role === "doctor") {
                foreach ($doctorPermissions as $per) {
                    Permission::where(["name" => $per . "_index"])->first()->assignRole($currentRole);
                    Permission::where(["name" => $per . "_create"])->first()->assignRole($currentRole);
                    Permission::where(["name" => $per . "_edit"])->first()->assignRole($currentRole);
                }
            }
            if ($role === "receptionist") {
                foreach ($receptionistPermissions as $per) {
                    Permission::where(["name" => $per . "_index"])->first()->assignRole($currentRole);
                    Permission::where(["name" => $per . "_create"])->first()->assignRole($currentRole);
                    Permission::where(["name" => $per . "_edit"])->first()->assignRole($currentRole);
                }
            }
        }
    }
}
