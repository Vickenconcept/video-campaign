<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles for each funnel type
        $roles = [
            'FE',
            'OTO1', 
            'OTO2',
            'OTO3',
            'OTO4',
            'OTO5',
            'OTO6',
            'OTO7',
            'OTO8',
            'Bundle'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Create basic permissions
        $permissions = [
            'view_dashboard',
            'create_campaigns',
            'edit_campaigns',
            'delete_campaigns',
            'view_responses',
            'manage_folders',
            'access_email_campaigns',
            'access_video_pages',
            'connect_esp',
            'access_reseller',
            'access_support'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles based on funnel type
        $this->assignPermissionsToRoles();
    }

    private function assignPermissionsToRoles()
    {
        // FE (Front End) - Basic app features only
        $feRole = Role::where('name', 'FE')->first();
        $feRole->givePermissionTo([
            'view_dashboard',
            'create_campaigns',
            'edit_campaigns',
            'view_responses',
            'manage_folders',
            'access_support'
        ]);

        // OTO1 - Full access to all menus
        $oto1Role = Role::where('name', 'OTO1')->first();
        $oto1Role->givePermissionTo(Permission::all());

        // OTO2 - DFY Video Agency Setup + basic features
        $oto2Role = Role::where('name', 'OTO2')->first();
        $oto2Role->givePermissionTo([
            'view_dashboard',
            'create_campaigns',
            'edit_campaigns',
            'delete_campaigns',
            'view_responses',
            'manage_folders',
            'access_email_campaigns',
            'access_video_pages',
            'connect_esp',
            'access_reseller',
            'access_support'
        ]);

        // OTO3 - DFY Unlimited Traffic + basic features
        $oto3Role = Role::where('name', 'OTO3')->first();
        $oto3Role->givePermissionTo([
            'view_dashboard',
            'create_campaigns',
            'edit_campaigns',
            'delete_campaigns',
            'view_responses',
            'manage_folders',
            'access_email_campaigns',
            'access_video_pages',
            'connect_esp',
            'access_reseller',
            'access_support'
        ]);

        // OTO4 - Reseller access + basic features
        $oto4Role = Role::where('name', 'OTO4')->first();
        $oto4Role->givePermissionTo([
            'view_dashboard',
            'create_campaigns',
            'edit_campaigns',
            'delete_campaigns',
            'view_responses',
            'manage_folders',
            'access_email_campaigns',
            'access_video_pages',
            'connect_esp',
            'access_reseller',
            'access_support'
        ]);

        // OTO5 - Affiliate Marketing Training + basic features
        $oto5Role = Role::where('name', 'OTO5')->first();
        $oto5Role->givePermissionTo([
            'view_dashboard',
            'create_campaigns',
            'edit_campaigns',
            'delete_campaigns',
            'view_responses',
            'manage_folders',
            'access_email_campaigns',
            'access_video_pages',
            'connect_esp',
            'access_reseller',
            'access_support'
        ]);

        // Bundle - Full access to all menus
        $bundleRole = Role::where('name', 'Bundle')->first();
        $bundleRole->givePermissionTo(Permission::all());
    }
} 