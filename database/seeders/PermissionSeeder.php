<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Permission::create(['guard_name'=>'compony','name' => 'Create-city']);
        Permission::create(['guard_name'=>'compony','name' => 'Update-city']);
        Permission::create(['guard_name'=>'compony','name' => 'Delete-city']);
        Permission::create(['guard_name'=>'compony','name' => 'Show-city']);
        Permission::create(['guard_name'=>'compony','name' => 'Read-city']);




        Permission::create(['guard_name'=>'compony','name' => 'Create-role']);
        Permission::create(['guard_name'=>'compony','name' => 'Update-role']);
        Permission::create(['guard_name'=>'compony','name' => 'Delete-role']);
        Permission::create(['guard_name'=>'compony','name' => 'Show-role']);
        Permission::create(['guard_name'=>'compony','name' => 'Read-role']);

        Permission::create(['guard_name'=>'compony','name' => 'Create-report']);
        
        Permission::create(['guard_name'=>'compony','name' => 'Show-report']);
        

        Permission::create(['guard_name'=>'compony','name' => 'Delete-user']);
        Permission::create(['guard_name'=>'compony','name' => 'Show-user']);
        Permission::create(['guard_name'=>'compony','name' => 'Read-user']);

        Permission::create(['guard_name'=>'compony','name' => 'Create-category']);
        Permission::create(['guard_name'=>'compony','name' => 'Update-category']);
        Permission::create(['guard_name'=>'compony','name' => 'Delete-category']);
        Permission::create(['guard_name'=>'compony','name' => 'Show-category']);
        Permission::create(['guard_name'=>'compony','name' => 'Read-category']);

        Permission::create(['guard_name'=>'compony','name' => 'Create-subcategory']);
        Permission::create(['guard_name'=>'compony','name' => 'Update-subcategory']);
        Permission::create(['guard_name'=>'compony','name' => 'Delete-subcategory']);
        Permission::create(['guard_name'=>'compony','name' => 'Show-subcategory']);
        Permission::create(['guard_name'=>'compony','name' => 'Read-subcategory']);

        Permission::create(['guard_name'=>'compony','name' => 'Create-paypoint']);
        Permission::create(['guard_name'=>'compony','name' => 'Update-paypoint']);
        Permission::create(['guard_name'=>'compony','name' => 'Delete-paypoint']);
        Permission::create(['guard_name'=>'compony','name' => 'Show-paypoint']);
        Permission::create(['guard_name'=>'compony','name' => 'Read-paypoint']);



        // points


        Permission::create(['guard_name'=>'point','name' => 'Create-employee']);
        Permission::create(['guard_name'=>'point','name' => 'Update-employee']);
        Permission::create(['guard_name'=>'point','name' => 'Delete-employee']);
        Permission::create(['guard_name'=>'point','name' => 'Show-employee']);
        Permission::create(['guard_name'=>'point','name' => 'Read-employee']);

        Permission::create(['guard_name'=>'point','name' => 'Create-report']);
        Permission::create(['guard_name'=>'point','name' => 'Update-report']);
        Permission::create(['guard_name'=>'point','name' => 'Delete-report']);
        Permission::create(['guard_name'=>'point','name' => 'Show-report']);
        Permission::create(['guard_name'=>'point','name' => 'Read-report']);

        Permission::create(['guard_name'=>'point','name' => 'Create-user']);
        Permission::create(['guard_name'=>'point','name' => 'Update-user']);
        Permission::create(['guard_name'=>'point','name' => 'Delete-user']);
        Permission::create(['guard_name'=>'point','name' => 'Show-user']);
        Permission::create(['guard_name'=>'point','name' => 'Read-user']);

        // Permission::create(['guard_name'=>'point','name' => 'Show-charge']);
        // Permission::create(['guard_name'=>'point','name' => 'Read-charge']);


        // employee

        Permission::create(['guard_name'=>'employee','name' => 'Create-charge']);
        Permission::create(['guard_name'=>'employee','name' => 'Update-charge']);
        Permission::create(['guard_name'=>'employee','name' => 'Delete-charge']);
        Permission::create(['guard_name'=>'employee','name' => 'Show-charge']);
        Permission::create(['guard_name'=>'employee','name' => 'Read-charge']);

        // User

        Permission::create(['guard_name'=>'users','name' => 'History-wallet']);
        Permission::create(['guard_name'=>'users','name' => 'Send-mony']);
        Permission::create(['guard_name'=>'users','name' => 'Read-subcategory']);
        Permission::create(['guard_name'=>'users','name' => 'Read-category']);

       


        // Permission::create(['guard_name'=>'','name' => 'Create-']);
        // Permission::create(['guard_name'=>'','name' => 'Update-']);
        // Permission::create(['guard_name'=>'','name' => 'Delete-']);
        // Permission::create(['guard_name'=>'','name' => 'Show-']);
        // Permission::create(['guard_name'=>'','name' => 'Read-']);
    }
}
