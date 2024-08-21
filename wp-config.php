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
define( 'DB_NAME', 'yeslovec_wp763' );

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
define( 'AUTH_KEY',         's5RcM=w&ho>7_n~A<&4&cp?aI$])V8zYh5%!X&Tc F 6I]SGJq:n)egFB1P{e{73' );
define( 'SECURE_AUTH_KEY',  '0~^L`,hnj13]Jsxvn%[|SSJGwnWO_x{V&>/8!Uz3=yk{Q=R)Vy-=cxB^1N]f]c$W' );
define( 'LOGGED_IN_KEY',    'h|4[Ye(44nj&v8p?$_*%HENnF.XgG&u/_D>n|$}ufCnKSk([ov(rdIpXrHGw0w0 ' );
define( 'NONCE_KEY',        '_ol/ua@MzosB`XKKZR>On!t_Ws`[q[-?>,G7#$0o0;lGSj>s/(E24?v^l{iAxJlO' );
define( 'AUTH_SALT',        'f[%,; JrFRuhNam+wKHF*[M_w7oLd(4<0vWH2ud-zoy$a4% kbF-7ZaeSz4D/#)^' );
define( 'SECURE_AUTH_SALT', '3nSuD0Kg.93*?jHC0__SSTxezjV6]x8cup73ivX4$qlJ-_x;$DN a,abhH$):d?V' );
define( 'LOGGED_IN_SALT',   'J?/cRnNyb-$=nV7;=g7^8(dB~wtO+D4#zm0_P,AL@3n= d8G/U_!.|Oy[`G&*I6z' );
define( 'NONCE_SALT',       'U~-Km|,M1;;|{s=^OY=j0umesHhJ}+(E^).,]J@qWjNTI, EKimN*&%$rpn z$g|' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpzo_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
