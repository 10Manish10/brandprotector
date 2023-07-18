<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'my_dashboard_access',
            ],
            [
                'id'    => 18,
                'title' => 'channel_create',
            ],
            [
                'id'    => 19,
                'title' => 'channel_edit',
            ],
            [
                'id'    => 20,
                'title' => 'channel_show',
            ],
            [
                'id'    => 21,
                'title' => 'channel_delete',
            ],
            [
                'id'    => 22,
                'title' => 'channel_access',
            ],
            [
                'id'    => 23,
                'title' => 'client_create',
            ],
            [
                'id'    => 24,
                'title' => 'client_edit',
            ],
            [
                'id'    => 25,
                'title' => 'client_show',
            ],
            [
                'id'    => 26,
                'title' => 'client_delete',
            ],
            [
                'id'    => 27,
                'title' => 'client_access',
            ],
            [
                'id'    => 28,
                'title' => 'email_template_create',
            ],
            [
                'id'    => 29,
                'title' => 'email_template_edit',
            ],
            [
                'id'    => 30,
                'title' => 'email_template_show',
            ],
            [
                'id'    => 31,
                'title' => 'email_template_delete',
            ],
            [
                'id'    => 32,
                'title' => 'email_template_access',
            ],
            [
                'id'    => 33,
                'title' => 'report_access',
            ],
            [
                'id'    => 34,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 35,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 36,
                'title' => 'subscription_create',
            ],
            [
                'id'    => 37,
                'title' => 'subscription_edit',
            ],
            [
                'id'    => 38,
                'title' => 'subscription_show',
            ],
            [
                'id'    => 39,
                'title' => 'subscription_delete',
            ],
            [
                'id'    => 40,
                'title' => 'subscription_access',
            ],
            [
                'id'    => 41,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
