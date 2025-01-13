<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'vpnresellers' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define('DISABLE_WP_REST_API', false);
define('JWT_AUTH_SECRET_KEY', ']C)RGVNZxp*wxZm3<g)_2{Xq??koyfKLHQ#Jg*y729JM,h]]##bLJTU)#BBu||!7');
define('JWT_AUTH_CORS_ENABLE', true);
define( 'AUTH_KEY',         '5]*DO[+Fst9#SY{g<bx],[-z@LN/V1cI_ ?5{2D,5aBZ8#p{zo,V<F|& q!SSKP8' );
define( 'SECURE_AUTH_KEY',  'S6SW5$/MMf` i8T<Bv6ph7w*R~m((j_k4fgFDq!i^@DD()9Hk>7$`UR+}j>+|0g~' );
define( 'LOGGED_IN_KEY',    'Zj%~Cn,H;Jz[hM a0<xAN-U{#+yRS%Os-O#$(=gdc8#|Fqq>sAu1KU}pIB`]aIek' );
define( 'NONCE_KEY',        'JR}/xDhiOSr<Mc:K+:x(SjxK1I|F.fRHRp3Aw+;?(&Gq-M78trgz@xXv<OR.Kn+s' );
define( 'AUTH_SALT',        '8zg^ueDYFet3`bi;>(;*<l3JQiTXSOtm_iY%wE.^H|aS*3CRVR G&5YPB~,_k<~W' );
define( 'SECURE_AUTH_SALT', 'VbW1W -4e7#cj@/,j(n0jue{7XMQy@e(9j{EF+B5MQ<U=T|VwZt-UL&50oW,,ra,' );
define( 'LOGGED_IN_SALT',   ']C)RGVNZxp*wxZm3<g)_2{Xq??koyfKLHQ#Jg*y729JM,h]]##bLJTU)#BBu||!7' );
define( 'NONCE_SALT',       'Wy.#/<&9-ZLW_?^`UW|#X#p/t6PkcEo]_T@#lR38!IvSZ>o1y9sZYO+&ZYcWVuVG' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'vpn_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */


/* Add any custom values between this line and the "stop editing" line. */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors', 0);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

