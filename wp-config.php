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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',          'qr-zMgdn<7QT01sF7cR+ad#kuw+=8r#M(I<N#-_*xG=FhrO^WBhsl110d9|xT6YM' );
define( 'SECURE_AUTH_KEY',   '# B?ejW@YJfP<[iA9{_(R!:lA`:jjv{xIGIPxdP>mxrOr?vTsew/2flr6}~vBWB ' );
define( 'LOGGED_IN_KEY',     'Q;GwSzNuL`ou3(DgkZkegPeVQ^O#2(a*CpYs/ngCc08R_k!*_Owcyj,`=I({,@Iq' );
define( 'NONCE_KEY',         'i@Me;EzqW%M1-r(=BF@>De8ghl6|y?Su%0 rT<nPh7dJOMj7eE|AJNF#3U]Va;QG' );
define( 'AUTH_SALT',         '*Wt;tv=tsj9bMWOTw1]{7I$eLp5bQt9q.4%Bm@=7C$a~%rEoino*lb`DLj%gM<66' );
define( 'SECURE_AUTH_SALT',  'h689wEjS?<L;lO2hV$r7cllhY[%,7*z-#9P18~9 &]pLA52`LHc8I9B0H@6vd8Q^' );
define( 'LOGGED_IN_SALT',    ']kA]x=/qHs.bC_h7e%DsaTt11?$BI4Oj*hEmddA51apc~0l`5YL)d@,3a1{@jJrG' );
define( 'NONCE_SALT',        'a r>{gAlT;Q/[%0`8$D31-0SqL|jKPA}=|uNwbv^$B5t#i0ojGKwH{e}7wWn>}9T' );
define( 'WP_CACHE_KEY_SALT', 'Db_{_v<l*Z/CG`B i5Sz98:n:7m7)>5wi<J& PD+5Fw&Iw}:#p}:G6jP>g%no_;f' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
