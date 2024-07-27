<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Reset cached roles and permissions
         app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

         // Create permissions
         Permission::create(['name' => 'manage_users']);
         Permission::create(['name' => 'manage_posts']);
         Permission::create(['name' => 'manage_categories']);
         Permission::create(['name' => 'manage_tags']);
         Permission::create(['name' => 'manage_comments']);

         // Create roles and assign created permissions

         // this can be done as separate statements
         $adminRole = Role::create(['name' => 'admin']);
         $adminRole->givePermissionTo(Permission::all());

         // or may be done by chaining
         $authorRole = Role::create(['name' => 'author']);
         $authorRole->givePermissionTo(['manage_posts', 'manage_comments']);
    }
}
