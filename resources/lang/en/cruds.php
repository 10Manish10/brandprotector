<?php

return [
    'userManagement' => [
        'title'          => 'User management',
        'title_singular' => 'User management',
    ],
    'permission' => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'role' => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'title'              => 'Title',
            'title_helper'       => ' ',
            'permissions'        => 'Permissions',
            'permissions_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'user' => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                           => 'ID',
            'id_helper'                    => ' ',
            'name'                         => 'Name',
            'name_helper'                  => ' ',
            'email'                        => 'Email',
            'email_helper'                 => ' ',
            'email_verified_at'            => 'Email verified at',
            'email_verified_at_helper'     => ' ',
            'password'                     => 'Password',
            'password_helper'              => ' ',
            'roles'                        => 'Roles',
            'roles_helper'                 => ' ',
            'remember_token'               => 'Remember Token',
            'remember_token_helper'        => ' ',
            'created_at'                   => 'Created at',
            'created_at_helper'            => ' ',
            'updated_at'                   => 'Updated at',
            'updated_at_helper'            => ' ',
            'deleted_at'                   => 'Deleted at',
            'deleted_at_helper'            => ' ',
            'two_factor'                   => 'Two-Factor Auth',
            'two_factor_helper'            => ' ',
            'two_factor_code'              => 'Two-factor code',
            'two_factor_code_helper'       => ' ',
            'two_factor_expires_at'        => 'Two-factor expires at',
            'two_factor_expires_at_helper' => ' ',
            'approved'                     => 'Approved',
            'approved_helper'              => ' ',
            'verified'                     => 'Verified',
            'verified_helper'              => ' ',
            'verified_at'                  => 'Verified at',
            'verified_at_helper'           => ' ',
            'verification_token'           => 'Verification token',
            'verification_token_helper'    => ' ',
        ],
    ],
    'myDashboard' => [
        'title'          => 'Dashboard',
        'title_singular' => 'Dashboard',
    ],
    'channel' => [
        'title'          => 'Channels',
        'title_singular' => 'Channel',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'channel_name'             => 'Channel Name',
            'channel_name_helper'      => 'Channel Name',
            'created_at'               => 'Created at',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
            'subscription_plan'        => 'Subscription Plan',
            'subscription_plan_helper' => ' ',
        ],
    ],
    'client' => [
        'title'          => 'Clients',
        'title_singular' => 'Client',
        'fields'         => [
            'id'                     => 'ID',
            'id_helper'              => ' ',
            'name'                   => 'Client Name',
            'name_helper'            => ' ',
            'email'                  => 'Client Email',
            'email_helper'           => ' ',
            'logo'                   => 'Client Logo',
            'logo_helper'            => ' ',
            'channels'               => 'Channels',
            'channels_helper'        => ' ',
            'keywords'               => 'Keywords',
            'keywords_helper'        => 'Enter keywords Separated by comma',
            'website'                => 'Official Website',
            'website_helper'         => ' ',
            'brand_name'             => 'Brand Name',
            'brand_name_helper'      => ' ',
            'social_handle'          => 'Social Handle',
            'social_handle_helper'   => ' ',
            'company_name'           => 'Company Name',
            'company_name_helper'    => ' ',
            'multiple_emails'        => 'Multiple Emails',
            'multiple_emails_helper' => ' ',
            'created_at'             => 'Created at',
            'created_at_helper'      => ' ',
            'updated_at'             => 'Updated at',
            'updated_at_helper'      => ' ',
            'deleted_at'             => 'Deleted at',
            'deleted_at_helper'      => ' ',
            'document_proof'         => 'Document Proof',
            'document_proof_helper'  => ' ',
        ],
    ],
    'emailTemplate' => [
        'title'          => 'Email Templates',
        'title_singular' => 'Email Template',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'subject'           => 'Subject',
            'subject_helper'    => ' ',
            'email_body'        => 'Email Body',
            'email_body_helper' => ' ',
            'priority'          => 'Priority',
            'priority_helper'   => ' ',
            'clients'           => 'Clients',
            'clients_helper'    => ' ',
            'from_email'        => 'From Email',
            'from_email_helper' => ' ',
            'to_email'          => 'To Email',
            'to_email_helper'   => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'report' => [
        'title'          => 'Reports',
        'title_singular' => 'Report',
    ],
    'auditLog' => [
        'title'          => 'Audit Logs',
        'title_singular' => 'Audit Log',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => ' ',
            'description'         => 'Description',
            'description_helper'  => ' ',
            'subject_id'          => 'Subject ID',
            'subject_id_helper'   => ' ',
            'subject_type'        => 'Subject Type',
            'subject_type_helper' => ' ',
            'user_id'             => 'User ID',
            'user_id_helper'      => ' ',
            'properties'          => 'Properties',
            'properties_helper'   => ' ',
            'host'                => 'Host',
            'host_helper'         => ' ',
            'created_at'          => 'Created at',
            'created_at_helper'   => ' ',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => ' ',
        ],
    ],
    'subscription' => [
        'title'          => 'Subscription',
        'title_singular' => 'Subscription',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'name'               => 'Plan Name',
            'name_helper'        => ' ',
            'plan_amount'        => 'Plan Amount',
            'plan_amount_helper' => ' ',
            'features'           => 'Plan Features',
            'features_helper'    => 'comma separated values',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
            'role'               => 'Role Mapped',
            'role_helper'        => ' ',
        ],
    ],

];
