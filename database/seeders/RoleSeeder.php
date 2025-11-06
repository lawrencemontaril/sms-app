<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/*
| --------------------------------------------------------------------
|  RoleSeeder: Populate the database with user roles and permissions.
| --------------------------------------------------------------------
*/
class RoleSeeder extends Seeder
{
    /*
    | -------------------------
    |  Run the database seeds.
    | -------------------------
    */
    public function run(): void
    {
        $permissions = [
            'users' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'departments' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'suppliers' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'supplies' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'supplyRequests' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'requisitions' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'requisitionApprovals' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'purchaseOrders' => ['viewAny', 'view', 'create', 'update', 'delete'],
        ];

        foreach ($permissions as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "$module.$action"]);
            }
        }

        $rolePermissions = [
            'procurement' => [
                'users.viewAny', 'users.view', 'users.create', 'users.update', 'users.delete',
                'departments.viewAny', 'departments.view', 'departments.create', 'departments.update', 'departments.delete',
                'suppliers.viewAny', 'suppliers.view', 'suppliers.create', 'suppliers.update', 'suppliers.delete',
                'supplies.viewAny', 'supplies.view', 'supplies.create', 'supplies.update', 'supplies.delete',
                'supplyRequests.viewAny', 'supplyRequests.view', 'supplyRequests.update', 'supplyRequests.delete',
                'requisitions.viewAny', 'requisitions.view', 'requisitions.create', 'requisitions.update', 'requisitions.delete',
                'requisitionApprovals.viewAny', 'requisitionApprovals.view', 'requisitionApprovals.create', 'requisitionApprovals.update', 'requisitionApprovals.delete',
                'purchaseOrders.viewAny', 'purchaseOrders.view', 'purchaseOrders.create', 'purchaseOrders.update', 'purchaseOrders.delete',
            ],
            'accountant' => [
                'users.viewAny', 'users.view',
                'departments.viewAny', 'departments.view',
                'supplies.viewAny', 'supplies.view',
                'supplyRequests.viewAny', 'supplyRequests.view', 'supplyRequests.create',
                'requisitions.viewAny', 'requisitions.view', 'requisitions.create', 'requisitions.update',
                'requisitionApprovals.viewAny', 'requisitionApprovals.view', 'requisitionApprovals.update',
                'purchaseOrders.viewAny', 'purchaseOrders.view', 'purchaseOrders.update',
            ],
            'faculty' => [
                'users.viewAny', 'users.view',
                'departments.viewAny', 'departments.view',
                'supplies.viewAny', 'supplies.view',
                'supplyRequests.viewAny', 'supplyRequests.view', 'supplyRequests.create',
                'requisitions.viewAny', 'requisitions.view', 'requisitions.create', 'requisitions.update',
                'requisitionApprovals.viewAny', 'requisitionApprovals.view',
                'purchaseOrders.viewAny', 'purchaseOrders.view',
            ],
        ];

        foreach ($rolePermissions as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($permissions);
        }
    }
}
