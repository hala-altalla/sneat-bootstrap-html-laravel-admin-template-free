<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission ;
use Spatie\Permission\Models\Role;

class SetupAdminandPermissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      Permission::firstOrCreate(['name' => 'accept-businessAccount']);
      Permission::firstOrCreate(['name' => 'reject-businessAccount']);
      Permission::firstOrCreate(['name' => 'accept-service']);
      Permission::firstOrCreate(['name' => 'reject-service']);
      Permission::firstOrCreate(['name' => 'add-category']);
      Permission::firstOrCreate(['name' => 'delete-category']);
      Permission::firstOrCreate(['name' => 'edit-category']);
      Permission::firstOrCreate(['name' => 'add-Subcategory']);
      Permission::firstOrCreate(['name' => 'edit-Subcategory']);
      Permission::firstOrCreate(['name' => 'delete-Subcategory']);
      Permission::firstOrCreate(['name' => 'add-dynamicField']);
      Permission::firstOrCreate(['name' => 'edit-dynamicField']);
      Permission::firstOrCreate(['name' => 'delete-dynamicField']);
      Permission::firstOrCreate(['name' => 'add-city']);
      Permission::firstOrCreate(['name' => 'media-sliderManagement']);
      Permission::firstOrCreate(['name' => 'manage-Reports']);
      ///////
      Permission::firstOrCreate(['name' => 'add-role']);
      Permission::firstOrCreate(['name' => 'edit-role']);
      Permission::firstOrCreate(['name' => 'delete-role']);
      Permission::firstOrCreate(['name' => 'assign-RolePermission']);
      Permission::firstOrCreate(['name' => 'add-admin']);
      Permission::firstOrCreate(['name' => 'edit-admin']);
      //////
     // 2. Create Roles

      $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
      $managBaccountRole = Role::firstOrCreate(['name' => 'manage-businessAccounts']);
      $manageServicesRole = Role::firstOrCreate(['name' => 'manage-services']);
      $manageCategory = Role::firstOrCreate(['name' => 'manage-Category']);
      $sliderManagement = Role::firstOrCreate(['name' => 'manage-slider']);
      $managereport = Role::firstOrCreate(['name' => 'manage-report']);


   // 3. Assign Permissions to Roles

   $superAdminRole->givePermissionTo([
    'accept-businessAccount' ,
    'reject-businessAccount' ,
    'accept-service' ,
    'reject-service' ,
    'add-category' ,
    'delete-category' ,
    'edit-category' ,
    'add-Subcategory' ,
    'edit-Subcategory',
    'delete-Subcategory' ,
    'add-dynamicField' ,
    'edit-dynamicField',
    'delete-dynamicField' ,
    'add-city',
    'media-sliderManagement',
    'manage-Reports',
    'add-role',
    'edit-role',
    'delete-role',
    'assign-RolePermission',
    'add-admin',
    'edit-admin'
   ]);
   $managBaccountRole->givePermissionTo([
    'accept-businessAccount' ,
    'reject-businessAccount' ,
   ]);

   $manageServicesRole->givePermissionTo([
    'accept-service' ,
    'reject-service' ,
    'add-city',


   ]);
   $manageCategory->givePermissionTo([
    'add-category' ,
    'delete-category' ,
    'edit-category' ,
    'add-Subcategory' ,
    'edit-Subcategory',
    'delete-Subcategory' ,
    'add-dynamicField' ,
    'edit-dynamicField',
    'delete-dynamicField' ,

   ]);

   $sliderManagement->givePermissionTo([
    'media-sliderManagement',

   ]);
   $managereport->givePermissionTo([
    'manage-Reports',
   ]);
   $user = User::firstOrCreate(
    ['name' => 'Super Admin'],
    ['type' => 'super_admin']
);

Admin::firstOrCreate(
    ['user_id' => $user->id],
    [
        'email' => 'admin@gmail.com',
        'password' => Hash::make('admin123')
    ]
);
$user->assignRole('super-admin');





















    }
}