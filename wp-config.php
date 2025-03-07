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
define( 'DB_NAME', 'test_posts_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '0aH}H+?J$0+qO_dZ?+w7[<}V&+&D6j flF6GNVxXZWXVPqn1,MNe_yW4*(mUkOVo' );
define( 'SECURE_AUTH_KEY',  ';X7swy2d`IX4`R,gflGi`Y;+J:6negG<s@eir>G2vkc^?Yg,3P_uLGzuYWBQ=tZh' );
define( 'LOGGED_IN_KEY',    '?4Y^<d}fxvWIU+dngI~~W^I%{:fNqXKhl;6-Ce@4%0&tt>BN2I:ROJx:_]`hd|ks' );
define( 'NONCE_KEY',        '9)*I3;WC&Z|x%M1~,Kgd#))UBmB^]``Lyy.(,<IIae5?BkLIGlSt1^/8T-8O|kJf' );
define( 'AUTH_SALT',        '*x[!t)|PTQIFVQ:EhAUgX,}*P3v HX[)HEC0F^wP<$Z;wXf8zMn8$t;s*h qcc</' );
define( 'SECURE_AUTH_SALT', '?/MV2C7GLL#K)q.Z=.F*g3hU^3kgxAZL3m`9hvzg}xn;/J]JEk>hwT{n7nQNI+Fg' );
define( 'LOGGED_IN_SALT',   ',9Q4j-$VOuA3M(,#iT?wNtyqje5aO^*?r&mZ(R&%dRt`S[EM,Y}F&0Q4;Nqle&hf' );
define( 'NONCE_SALT',       '1#X[C+Ki$8[&dUFECR-XNG1`26] oo9D?egGyQHM(<B%O$f#dQT$-rw582fyJ8kN' );

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
