<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // Admin permissions
            'view_admin_dashboard',
            'manage_all_users',
            'approve_mentors',
            'manage_content',
            'view_all_activities',
            'manage_soal_global',

            // Mentor permissions
            'view_mentor_dashboard',
            'manage_own_murids',
            'create_soal',
            'view_murid_progress',
            'approve_murid_requests',

            // Murid permissions
            'view_murid_dashboard',
            'play_games',
            'view_own_progress',
            'choose_mentor',
            'watch_videos',
            'study_modules',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Buat Roles
        $adminRole = Role::create(['name' => 'admin']);
        $mentorRole = Role::create(['name' => 'mentor']);
        $muridRole = Role::create(['name' => 'murid']);

        // Assign permissions ke roles
        $adminRole->givePermissionTo([
            'view_admin_dashboard',
            'manage_all_users',
            'approve_mentors',
            'manage_content',
            'view_all_activities',
            'manage_soal_global',
        ]);

        $mentorRole->givePermissionTo([
            'view_mentor_dashboard',
            'manage_own_murids',
            'create_soal',
            'view_murid_progress',
            'approve_murid_requests',
        ]);

        $muridRole->givePermissionTo([
            'view_murid_dashboard',
            'play_games',
            'view_own_progress',
            'choose_mentor',
            'watch_videos',
            'study_modules',
        ]);
    }
}
