<?php
/*
 *  GLOBAL VARIABLES
 */
define('THEME_DIR', get_stylesheet_directory());
define('THEME_URL', get_stylesheet_directory_uri());

/*
 *  INCLUDED FILES
 */

$file_includes = [
    'inc/theme-assets.php',                 // Style and JS
    'inc/theme-setup.php',                  // General theme setting
    'inc/acf-options.php',                  // ACF Option page
    'inc/theme-shortcode.php'              // Theme Shortcode
];

foreach ($file_includes as $file) {
    if (!$filePath = locate_template($file)) {
        trigger_error(sprintf(__('Missing included file'), $file), E_USER_ERROR);
    }

    require_once $filePath;
}

unset($file, $filePath);

//Giới Hạn Ký Tự
function catchuoi($chuoi, $gioihan){
    if (strlen($chuoi) <= $gioihan) {
        return $chuoi;
    } else {
        if (strpos($chuoi, " ", $gioihan) > $gioihan) {
            $new_gioihan = strpos($chuoi, " ", $gioihan);
            $new_chuoi = substr($chuoi, 0, $new_gioihan) . "...";
            return $new_chuoi;
        }
        $new_chuoi = substr($chuoi, 0, $gioihan) . "...";
        return $new_chuoi;
    }
}

//Add SVG Vào WP-admin
function dvb_custom_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'dvb_custom_mime_types');




//Add Css Thay Đổi Trang wp-login wordpress
function login_css() {
    wp_enqueue_style( 'login_css', get_template_directory_uri() . '/wp-admin/login.css' );
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
}
add_action('login_head', 'login_css');



//404, phai vao tao 1 trang 404 trong wordpress
add_action('wp', 'redirect_404_to_homepage', 1);
function redirect_404_to_homepage() {
    global $wp_query;
    if ($wp_query->is_404) {
        wp_redirect(get_bloginfo('url') . '/404',301)
        ;exit;
    }
}









?>