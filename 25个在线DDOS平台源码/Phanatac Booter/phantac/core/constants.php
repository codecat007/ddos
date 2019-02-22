<?php
/**
 * Constants.php
 *
 * This file is intended to group all constants to
 * make it easier for the site administrator to tweak
 * the login script.
 *
 * Written by: Xbl Blue a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 19, 2004
 */
 
/**
 * Database Constants - these constants are required
 * in order for there to be a successful connection
 * to the MySQL database. Make sure the information is
 * correct.
 */
define("DB_SERVER", "127.0.0.1");
define("DB_USER", "root");
define("DB_PASS", "poiupoiu");
define("DB_NAME", "phantacdb");

/**
 * Database Table Constants - these constants
 * hold the names of all the database tables used
 * in the script.
 */
define("TBL_USERS", "users");
define("TBL_LOGS", "logs");
define("TBL_ACTIVE_USERS",  "active_users");
define("TBL_ACTIVE_GUESTS", "active_guests");
define("TBL_BANNED_USERS",  "banned_users");

/**
 * Special Names and Level Constants - the admin
 * page will only be accessible to the user with
 * the admin name and also to those users at the
 * admin user level. Feel free to change the names
 * and level constants as you see fit, you may
 * also add additional level specifications.
 * Levels must be digits between 0-9.
 */
define("ADMIN_NAME", "John");
define("GUEST_NAME", "Guest");
define("ADMIN_LEVEL", 2);
define("USER_LEVEL",  1);
define("GUEST_LEVEL", 0);

/**
 * This boolean constant controls whether or
 * not the script keeps track of active users
 * and active guests who are visiting the site.
 */
define("TRACK_VISITORS", true);

/**
 * Timeout Constants - these constants refer to
 * the maximum amount of time (in minutes) after
 * their last page fresh that a user and guest
 * are still considered active visitors.
 */
define("USER_TIMEOUT", 10);
define("GUEST_TIMEOUT", 5);

/**
 * Cookie Constants - these are the parameters
 * to the setcookie function call, change them
 * if necessary to fit your website. If you need
 * help, visit www.php.net for more info.
 * <http://www.php.net/manual/en/function.setcookie.php>
 */
define("COOKIE_EXPIRE", 60*60*24*100);  //100 days by default
define("COOKIE_PATH", "/");  //Avaible in whole domain

/**
 * Email Constants - these specify what goes in
 * the from field in the emails that the script
 * sends to users, and whether to send a
 * welcome email to newly registered users.
 */
define("EMAIL_FROM_NAME", "admin");
define("EMAIL_FROM_ADDR", "xblblue@phantacbooter.com");
define("EMAIL_WELCOME", false);

/**
 * This constant forces all users to have
 * lowercase usernames, capital letters are
 * converted automatically.
 */
define("ALL_LOWERCASE", false);

/**
 * this constant is the admincode
 * if it returns wrong the account
 * will not be registered.
 * CANNOT BE OVER 15 CHARS
 **/
define("ADMIN_CODE", "xblblue550316");
?>
