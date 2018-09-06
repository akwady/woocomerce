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



// Hide Admin User
add_action('pre_user_query','yoursite_pre_user_query');
function yoursite_pre_user_query($user_search) {
   global $current_user;
   $username = $current_user->user_login;

   if ($username == 'Epal') {
     global $wpdb;
     $user_search->query_where = str_replace('WHERE 1=1',
       "WHERE 1=1 AND {$wpdb->users}.user_login != 'Epal'",$user_search->query_where);
 }
}


//Thêm Font size vào text Editor
function scanwp_buttons( $buttons ) {
    array_unshift( $buttons, 'fontsizeselect' ); 
    return $buttons;
}
add_filter( 'mce_buttons_2', 'scanwp_buttons' );
function scanwp_font_size( $initArray ){
    $initArray['fontsize_formats'] = "9px 10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px";
    return $initArray;
}
add_filter( 'tiny_mce_before_init', 'scanwp_font_size' );


//Wedget
if (function_exists('register_sidebar')){
    register_sidebar(array(
        'name'=> 'Sidebar',
        'id' => 'sidebar',
    ));
}


// Ẩn Menu Admin
// function chetz_remove_admin_menus(){
// if ( function_exists('remove_menu_page') ) { 

//     remove_menu_page( 'plugins.php' ); 
// }}add_action('admin_menu', 'chetz_remove_admin_menus');


//404, phai vao tao 1 trang 404 trong wordpress
add_action('wp', 'redirect_404_to_homepage', 1);
function redirect_404_to_homepage() {
    global $wp_query;
    if ($wp_query->is_404) {
        wp_redirect(get_bloginfo('url') . '/404',301)
        ;exit;
    }
}


//Add Template Woocommerce
$storefront = (object) array(
    'main'       => require 'inc/class-storefront.php',
);


//Code phan trang
function devvn_wp_corenavi($custom_query = null, $paged = null) {
    global $wp_query;
    if($custom_query) $main_query = $custom_query;
    else $main_query = $wp_query;
    $paged = ($paged) ? $paged : get_query_var('paged');
    $big = 999999999;
    $total = isset($main_query->max_num_pages)?$main_query->max_num_pages:'';
    if($total > 1) echo '<div class="pagenavi">';
    echo paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, $paged ),
        'total' => $total,
        'mid_size' => '10', // Số trang hiển thị khi có nhiều trang trước khi hiển thị ...
        'prev_text'    => __('<i class="fas fa-caret-left" ></i>','devvn'),
        'next_text'    => __('<i class="fas fa-caret-right" ></i>','devvn'),
    ) );
    if($total > 1) echo '</div>';
}


// Tối ưu Woocommerce css, js
add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );

function child_manage_woocommerce_styles()
{
    remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
    if ( function_exists( 'is_woocommerce' ) )
    {
        if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() )
        {
            wp_dequeue_style( 'woocommerce_frontend_styles' );
            wp_dequeue_style( 'woocommerce_fancybox_styles' );
            wp_dequeue_style( 'woocommerce_chosen_styles' );
            wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
            wp_dequeue_script( 'wc_price_slider' );
            wp_dequeue_script( 'wc-single-product' );
            wp_dequeue_script( 'wc-add-to-cart' );
            wp_dequeue_script( 'wc-cart-fragments' );
            wp_dequeue_script( 'wc-checkout' );
            wp_dequeue_script( 'wc-add-to-cart-variation' );
            wp_dequeue_script( 'wc-single-product' );
            wp_dequeue_script( 'wc-cart' );
            wp_dequeue_script( 'wc-chosen' );
            wp_dequeue_script( 'woocommerce' );
            wp_dequeue_script( 'prettyPhoto' );
            wp_dequeue_script( 'prettyPhoto-init' );
            wp_dequeue_script( 'jquery-blockui' );
            wp_dequeue_script( 'jquery-placeholder' );
            wp_dequeue_script( 'fancybox' );
            wp_dequeue_script( 'jqueryui' );
        }
    }
}








