<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultRoleUserPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define roles and their permissions
        $roles = [
            [
                'name' => 'admin',
                // Admin has all permissions, so no need to specify here
            ],
            [
                'name' => 'cashier',
                'permissions' => [
                    'Select all Product',
                    'Select all Sales',
                    'View POS',
                    'Create POS',
                    'View Customer',
                    'Create Customer',
                    'View Supplier',
                    'Create Supplier',
                    'View Request',
                    'Create Request',
                    'View Notification',
                ]
            ],
            [
                'name' => 'user',
                'permissions' => [
                    'View Product',
                    'View Sales',
                    'View Request',
                ]
            ],
        ];
    
        // Create roles and assign permissions
        foreach ($roles as $roleData) {
            $role = Role::create([
                'name' => $roleData['name'],
                'description' => ucfirst($roleData['name']) . ' Role',
                'active' => true, // Assuming you want the role to be active by default
            ]);
    
            // Attach permissions to the role
            if (isset($roleData['permissions'])) {
                foreach ($roleData['permissions'] as $permissionName) {
                    $permission = Permission::where('name', $permissionName)->first();
                    if ($permission) {
                        $role->permissions()->attach($permission);
                    }
                }
            }
        }
    
        // Attach all permissions to the admin role
        $adminRole = Role::where('name', 'admin')->first();
        $permissions = Permission::all();
        $adminRole->permissions()->attach($permissions);
    
        // Create default users
        $users = [
            [
                'username' => 'admin',
                'email' => 'haremhospital@gmail.com',
                'phone' => '0780 385 3805',
                'password' => Hash::make('harem@1harem'),
                'role' => 'admin', // Assign admin role to the admin user
            ],
            [
                'username' => 'cashier',
                'email' => 'cashier@example.com',
                'phone' => '0780 385 3805',
                'password' => Hash::make('cashier@1harem'),
                'role' => 'cashier', // Assign cashier role to the cashier user
            ],
            [
                'username' => 'user',
                'email' => 'user@example.com',
                'phone' => '0780 385 3805',
                'password' => Hash::make('user@1harem'),
                'role' => 'user', // Assign user role to the user
            ],
        ];
    
        // Create users and assign roles
        foreach ($users as $userData) {
            $user = User::create([
                'username' => $userData['username'],
                'email' => $userData['email'],
                'phone' => $userData['phone'],
                'password' => $userData['password'],
            ]);
    
            // Attach role to the user
            $role = Role::where('name', $userData['role'])->first();
            if ($role) {
                $user->roles()->attach($role);
            }
        }
    }
    
}
