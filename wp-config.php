<?php
define( 'FORCE_SSL_ADMIN', false );
define( 'FORCE_SSL_ADMIN', false );
// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
//define( 'FORCE_SSL_LOGIN', true ); // Force SSL for Dashboard - Security > Settings > Secure Socket Layers (SSL) > SSL for Dashboard
define( 'FORCE_SSL_ADMIN', true ); // Force SSL for Dashboard - Security > Settings > Secure Socket Layers (SSL) > SSL for Dashboard
// END iThemes Security - Do not modify or remove this line

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */

define('DB_NAME', 'operation-nehemiah');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'j)@CQ}+$W2N9az#egWS3@k13cK[mVHvTI^4*Z3C73Q7e,K4c;v|^W4>23Y2A1s(*');
define('SECURE_AUTH_KEY',  'U_fR5qCd`=;4eF:F-@$;N]HP0IGNWQttb}#&P(|r[OWY7VA.hC8M??gbk)De0Ztz');
define('LOGGED_IN_KEY',    '>|cby}wX-*e&ISw:36h),bgYvXv2~wXRq&x:[*g^z>:hB$[-{YcCO;@eM##pnpt8');
define('NONCE_KEY',        'n)bXpi|L>x33Y2(TA(Mxf;SOSqThu9,^Y|bHq/lDnm=NmDMyCp<^oOfMN$WkE[:6');
define('AUTH_SALT',        't+FJ1wqe8H^P$XKaQmvV[?=,L/+D|%KW%^p}@BEF:4$UxU7Q|5CdB5(^Uu==p!E/');
define('SECURE_AUTH_SALT', 'm5pjiR$8yMf.PB;&^32[}<bb=3&Hi}67H6W!)*TATr7qMQ2U lAy=BE`bb}Afb:e');
define('LOGGED_IN_SALT',   '4Mjmx[obIDwK=>v,e>/RJ/<kN38=mXjusBgRF9`$d-CkB>1FsNS&X0g/ rBNk)yp');
define('NONCE_SALT',       '%bpdSt(%o&;7<=R8|aO>7sY{GT nNDf87^nvkeBX5r_L/qAke0YZu6pYD$nT)_P/');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
