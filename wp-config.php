<?php
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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'trp_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'hmNOSGBp1) r* hV{j~*;MS*%p8!;wrDeo^Gn+jDX1]]167pj[96@kC&3(Tf,K$c' );
define( 'SECURE_AUTH_KEY',  '#1lw`Dlr1<S$3_N.{UvPA00f~<,wX0#?r,7zAAeyyGP]PnF{,6&%xk|9B+ {|*Z*' );
define( 'LOGGED_IN_KEY',    '<s k;4PyCEZ/3D$+mV1%c%Yz]ebb B<?b-K,]^4-7[5<c^:]I1%b 2thErrM- JM' );
define( 'NONCE_KEY',        'envE=/@|b6.E|`%yD&?alAdc&B`2;ssObhwBcanX]Rc.5m*,edqt]Nk(3Ml;~v-Y' );
define( 'AUTH_SALT',        'M*D1#nuCT0?GM]&Ezh+{G01Bz* htltU`^,pL_(aMCeHJZuK{.K?J9Y>qO#F=`/*' );
define( 'SECURE_AUTH_SALT', '%OAwis/5])JP{%)$WzCo-Z8V%n~U#];tbCAk;&Tz;A=s[(c`EeQrron5jQIV=>`t' );
define( 'LOGGED_IN_SALT',   'Kzf+HRi{--/TA1nQnAgVu4WTM(3Zq0(.`*Vw]S67)NQuBiu;~AmAcJQXGeoH&G(S' );
define( 'NONCE_SALT',       'J6PJ/X1<o?5d~9~Ws>P.@>W&H#{V519 l2L-Q0Mm<Hpah$Us1o<[?wFbfh0sDK;p' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
