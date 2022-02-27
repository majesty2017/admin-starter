<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // USER MODEL
        $userPermission1 = Permission::create([
           'name' => 'create:user',
           'description' => 'create user',
        ]);
        $userPermission2 = Permission::create([
            'name' => 'read:user',
            'description' => 'read user',
        ]);
        $userPermission3 = Permission::create([
           'name' => 'update:user',
           'description' => 'update user',
        ]);
        $userPermission4 = Permission::create([
           'name' => 'delete:user',
           'description' => 'delete user',
        ]);

        // ROLE MODEL
        $rolePermission1 = Permission::create([
            'name' => 'create:role',
            'description' => 'create role',
        ]);

        $rolePermission2 = Permission::create([
            'name' => 'read:role',
            'description' => 'read role',
        ]);
        $rolePermission3 = Permission::create([
            'name' => 'update:role',
            'description' => 'update role',
        ]);
        $rolePermission4 = Permission::create([
            'name' => 'delete:role',
            'description' => 'delete role',
        ]);

        // PERMISSION MODEL

        $permission1 = Permission::create([
            'name' => 'create:permission',
            'description' => 'create permission',
        ]);
        $permission2 = Permission::create([
            'name' => 'permission:role',
            'description' => 'read permission',
        ]);
        $permission3 = Permission::create([
            'name' => 'update:permission',
            'description' => 'update permission',
        ]);
        $permission4 = Permission::create([
            'name' => 'delete:permission',
            'description' => 'delete permission',
        ]);

        // ADMIN
        $adminPermission2 = Permission::create([
            'name' => 'read:permission',
            'description' => 'read admin',
        ]);

        $adminPermission1 = Permission::create([
            'name' => 'read: admin',
            'description' => 'read admin',
        ]);

        // Creating roles for the users
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $moderatorRole = Role::create(['name' => 'moderator']);
        $developerRole = Role::create(['name' => 'developer']);
        $userRole = Role::create(['name' => 'user']);

        // Synchronizing roles & permissions to super admin role
        $superAdminRole->syncPermissions([
            $userPermission1,
            $userPermission2,
            $userPermission3,
            $userPermission4,
            $rolePermission1,
            $rolePermission2,
            $rolePermission3,
            $rolePermission4,
            $permission1,
            $permission2,
            $permission3,
            $permission4,
            $adminPermission1,
            $adminPermission2,
        ]);

        // Synchronizing roles & permissions to admin role
        $adminRole->syncPermissions([
            $userPermission1,
            $userPermission2,
            $userPermission3,
            $userPermission4,
            $rolePermission1,
            $rolePermission2,
            $rolePermission3,
            $rolePermission4,
            $permission1,
            $permission2,
            $permission3,
            $permission4,
            $adminPermission1,
            $adminPermission2,
        ]);

        // Synchronizing roles & permissions to moderator role
        $moderatorRole->syncPermissions([
            $userPermission2,
            $rolePermission2,
            $permission2,
            $adminPermission1,
        ]);

        // Synchronizing roles & permissions to developer role
        $developerRole->syncPermissions([
            $adminPermission1,
        ]);

        $superAdmin = User::create([
            'name' => 'Super Admin',
            'is_admin' => 1,
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('T1sc077a'), // password
            'remember_token' => Str::random(10),
        ]);

        $admin = User::create([
            'name' => 'Admin User',
            'is_admin' => 1,
            'email' => 'adminuser@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('T1sc077a'), // password
            'remember_token' => Str::random(10),
        ]);

        $moderator = User::create([
            'name' => 'Moderator',
            'is_admin' => 1,
            'email' => 'moderator@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('T1sc077a'), // password
            'remember_token' => Str::random(10),
        ]);

        $developer = User::create([
            'name' => 'Developer',
            'is_admin' => 1,
            'email' => 'developer@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('T1sc077a'), // password
            'remember_token' => Str::random(10),
        ]);

        $user = User::create([
            'name' => 'User',
            'is_admin' => 0,
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('T1sc077a'), // password
            'remember_token' => Str::random(10),
        ]);

        $superAdmin->syncRoles([$superAdminRole])->syncPermissions([
        $userPermission1,
        $userPermission2,
        $userPermission3,
        $userPermission4,
        $rolePermission1,
        $rolePermission2,
        $rolePermission3,
        $rolePermission4,
        $permission1,
        $permission2,
        $permission3,
        $permission4,
        $adminPermission1,
        $adminPermission2,
    ]);

        $admin->syncRoles($adminRole)->syncPermissions([
        $userPermission1,
        $userPermission2,
        $userPermission3,
        $userPermission4,
        $rolePermission1,
        $rolePermission2,
        $rolePermission3,
        $rolePermission4,
        $permission1,
        $permission2,
        $permission3,
        $permission4,
        $adminPermission1,
        $adminPermission2,
    ]);

        $moderator->syncRoles($moderatorRole)->syncPermissions([
        $userPermission2,
        $rolePermission2,
        $permission2,
        $adminPermission1,
    ]);

        $developer->syncRoles($developerRole)->syncPermissions([
        $adminPermission1,
    ]);

        $user->syncRoles($userRole);
    }
}
