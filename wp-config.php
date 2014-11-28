<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root123');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '|el5`O+8fY!n|0+zJYxKLel)9gJ(GA4L:wIj[WaN&{YEaNJpN=@<B&[.hh!G>C8:');
define('SECURE_AUTH_KEY',  '@8)P*8I^nF>FvzQm@39,(Z-K6;YD(V3{Gr=R]u)v[wnt}K|q8UiCDv+)3I~1]+M-');
define('LOGGED_IN_KEY',    '@WtnNVr@co47(|[*i3!^N)<F+99e2XBpCD>7_!vGPTkl_:Zw1g&|-Hr$ltS2u_S5');
define('NONCE_KEY',        '!(9>;h:%9A>/03E-G^KQ8@pm/f&1%f,^[q;zi#uas=aCK9.|</chuy=L]%$?G/Z%');
define('AUTH_SALT',        'Y%jZ2qLbWOU=k3U+ h^my*|C%dlu?L%*S|5l>}w~=hxz2V<?#IYq2&qnaBXJlWz?');
define('SECURE_AUTH_SALT', 'r6E`G]8x32cY-ZWhE/j-8]+R>xH%E)p=K5kVDp]&h:GFULS X1{tL_pwX8+|)kIL');
define('LOGGED_IN_SALT',   ' c&[+l$U3DC*|!a~z,|B}WT|J/&!oha3x-qw.i8R-N8.p-&$WQcI(Lvt!,4>EHRZ');
define('NONCE_SALT',       'olGdFj0@JPu`TMTvK6ftwvw[+FIB_AJb(OrM-JSV82(EN#Ru+ogG]gu+jN@?v8D_');

/**#@-*/
define('FS_METHOD', 'direct');
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
