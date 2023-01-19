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

namespace Buttonizer\Legacy\Api\Utils;

use Buttonizer\Utils\PermissionCheck;

/**
 * Reset API
 * 
 * @endpoint /wp-json/buttonizer/reset
 * @methods POST
 */
class ApiReset
{
    /**
     * Register route
     */
    public function registerRoute()
    {
        register_rest_route('buttonizer', '/reset', [
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
                'callback' => [$this, 'reset'],
                'permission_callback' => function () {
                    return PermissionCheck::hasPermission(true);
                }
            ]
        ]);
    }

    /**
     * Reset buttons
     */
    public function reset()
    {
        // Current settings
        update_option('buttonizer_buttons', []);

        // Current Settings
        update_option('buttonizer_settings', [
            'migration_version' => BUTTONIZER_LAST_MIGRATION,
            'welcome' => true,
            "import_icon_library" => true,
            "no_ajax" => true
        ]);
        delete_option('buttonizer_rules');
        delete_option('buttonizer_schedules');

        // Published
        delete_option('buttonizer_buttons_published');
        delete_option('buttonizer_rules_published');
        delete_option('buttonizer_schedules_published');

        delete_option('buttonizer_has_changes');

        // Also delete the settings
        delete_option('buttonizer_times_loaded');

        return [
            'status' => 'success'
        ];
    }
}
