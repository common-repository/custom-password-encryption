<?php
/*
  Plugin Name: Custom password encryption
  Plugin URI: http://www.ontimedesign.net/plugins/custom-password-encryption-wordpress/
  Description: Enable to login for imported users with other password encryption then the default md5 encryption
  Version: 0.2
  Author: OTD
  Author URI: http://www.ontimedesign.net
 */


add_action('wp_authenticate', 'custom_password_encryption_authentication', 100, 3);
add_action('plugins_loaded', 'custom_password_encryption_init');

function custom_password_encryption_init() {
  load_plugin_textdomain( 'custom_password_encryption', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}


function custom_password_encryption_authentication($username, $password) {
    global $wpdb;

    if (!username_exists($username)) {
        return;
    }

    $cust_auth = get_option('custom_password_encryption_mysql');

    $user = $wpdb->get_row("SELECT * FROM $wpdb->users WHERE user_login  = '$username' AND user_pass = $cust_auth('$password')");

    if (count($user) == 1) {
        wp_set_auth_cookie($user->ID);
        wp_set_current_user($user->ID);
        header("Location:" . get_page_link(MY_PROFILE_PAGE));
        exit();
    }
}

function custom_password_encryption_option() {
    if (false === get_option('custom_password_encryption_mysql')) {
        add_option("custom_password_encryption_mysql", "OLD_PASSWORD");
    }



    if (isset($_POST['action'])) {
        update_option("custom_password_encryption_mysql", $_POST["custom_password_encryption_mysql"]);
    }

    $custom_password_encryption_mysql = get_option('custom_password_encryption_mysql');



    echo "<h3>"._e('Custom password encryption option', 'custom_password_encryption')."</h3>";
    ?>
    <div class="wrap">
        <form action='' method='POST' id='custom_password_encryption'>
            <p><?php echo _e('Mysql encryption option', 'custom_password_encryption'); ?>
                <select name='custom_password_encryption_mysql' id='custom_password_encryption_mysql' >
                    <option value="OLD_PASSWORD" <?php echo $custom_password_encryption_mysql == 'OLD_PASSWORD' ? 'selected' : ''; ?> ><?php echo _e('Mysql OLD_PASSWORD()', 'custom_password_encryption'); ?></option>
                    <option value="PASSWORD" <?php echo $custom_password_encryption_mysql == 'PASSWORD' ? 'selected' : ''; ?> ><?php echo _e('Mysql PASSWORD()'); ?></option>
                    <option value="" <?php echo $custom_password_encryption_mysql == '' ? 'selected' : ''; ?> ><?php echo _e('None', 'custom_password_encryption'); ?></option>
                </select>
                <br /><input type='submit' name='action' id='save' value='<?php echo _e('Save', 'custom_password_encryption'); ?>' /></p>
        </form>
    </div><?
}

function custom_auth_method_menu() {
    add_options_page("Custom password encryption", "Custom password encryption", "manage_options", "custom-password-encryption", "custom_password_encryption_option");
}

if (is_admin()) {
    add_action('admin_menu', 'custom_auth_method_menu');
}