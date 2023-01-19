<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'i8535850_wp20' );

/** Database username */
define( 'DB_USER', 'i8535850_wp20' );

/** Database password */
define( 'DB_PASSWORD', 'Z.GsqBo5tcDB9uefx0y77' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '9ySGcMaKFr471w9HbHwexqxnST1pNSEXGiW4yXS9h8CZHKxqTsJTq3GzKXuEgCxf');
define('SECURE_AUTH_KEY',  'KUzYpUE4cRNaKchN66EBmEZYwsXwqDieJtaqY4zFMpnktit1IUacZ6UiSgXePX94');
define('LOGGED_IN_KEY',    'UNzsoui54rr3kJjrnnZBYUnN6QumEqGiPNrXnfOqSoDDUHoZ1YCyAS0rlKLITFAF');
define('NONCE_KEY',        'Ntxs5SAEUIqmdo5Krbv03RVuxGu9rPek8mhb4PwikxReQOQX0GEEizyV714Kl6WO');
define('AUTH_SALT',        '6goJz1x4dJvujEImWl2OjtCFgEmrsjSR7ka6GHBhL28petwPJ8HAcCEfV96CNQSV');
define('SECURE_AUTH_SALT', 'iuQkBUcs0eVI96lrVE10c9KYMFHo16OXymnWBYmEU8LaBDStHqV37EZd9Nu3CyfH');
define('LOGGED_IN_SALT',   'YBReqH8YBEEio3IOwGZD4r5JI1tleGbihtB1kg1shHKG47EXTYRs9jXDQx4gUSpm');
define('NONCE_SALT',       'lS2dIzDjVh7Y1cL3q1ZZnquFuPjc2HSyTp2WqNAEIc5m8b4iWbmIA6djW9dzHTri');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');
define('FS_CHMOD_DIR',0755);
define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
