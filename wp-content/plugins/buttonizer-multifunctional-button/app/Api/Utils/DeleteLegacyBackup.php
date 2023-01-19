<?php
/*
 * SOFTWARE LICENSE INFORMATION
 *
 * Copyright (c) 2017 Buttonizer, all rights reserved.
 *
 * This file is part of Buttonizer
 *
 * For detailed information regarding to the licensing of
 * this software, please review the license.txt or visit:
 * https://buttonizer.pro/license/
 */

namespace Buttonizer\Api\Utils;

use Buttonizer\Utils\PermissionCheck;
use Buttonizer\Utils\Settings;

/**
 * Delete Legacy Backup API
 * Removes backup rows made from migrating
 *
 * @endpoint /wp-json/buttonizer/delete_legacy_backup
 * @methods POST
 */
class DeleteLegacyBackup
{
    /**
     * Register route
     */
    public function registerRoute()
    {
        register_rest_route('buttonizer', '/delete_legacy_backup', [
            [
                'methods'  => ['POST'],
                'args' => [
                    'nonce' => [
                        'validate_callback' => function ($value) {
                            return wp_verify_nonce($value, 'wp_rest');
                        },
                        'required' => true
                    ],
                ],
                'callback' => [$this, 'deleteBackup'],
                'permission_callback' => function () {
                    return PermissionCheck::hasPermission(true);
                }
            ]
        ]);
    }

    /**
     * Delete backup
     */
    public function deleteBackup()
    {
        // Delete backup
        delete_option('buttonizer_buttons_backup_30');
        delete_option('buttonizer_buttons_published_backup_30');
        delete_option('buttonizer_has_changes_backup_30');
        delete_option('buttonizer_rules_backup_30');
        delete_option('buttonizer_rules_published_backup_30');
        delete_option('buttonizer_schedules_backup_30');
        delete_option('buttonizer_schedules_published_backup_30');
        delete_option('buttonizer_settings_backup_30');

        // Remove has_migrated
        Settings::deleteSetting("has_migrated");

        // Save
        Settings::saveUpdatedSettings();

        return [
            'status' => 'success'
        ];
    }
}
