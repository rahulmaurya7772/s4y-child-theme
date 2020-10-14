<?php
/**
 * @package s4y child
 * @author Vikas Sahu
 * @license GPL-2.0+
 * @link    https:/sahu4you.com
 */
// Start the engine
include_once( get_template_directory() . '/lib/init.php' );

// Child theme (do not remove)
define('CHILD_THEME_NAME', __('s4y child', 's4y child'));
define('CHILD_THEME_URL', 'https:/sahu4you.com/');
define('CHILD_THEME_VERSION', '1.0');

// Add custom Viewport meta tag for mobile browsers
add_action('genesis_meta', 'sahu4you_chrome_theme_meta_tag');

function sahu4you_chrome_theme_meta_tag() {
    echo '<meta name="theme-color" content="#058" />';
}

//* Add HTML5 markup structure
add_theme_support('html5', array('search-form', 'comment-form', 'comment-list'));

// Add viewport meta tag for mobile browsers
add_theme_support('genesis-responsive-viewport');

// Remove query string from static files
add_filter('style_loader_src', 'sahu4you_remove_styles_scripts_query_string', 10, 2);
add_filter('script_loader_src', 'sahu4you_remove_styles_scripts_query_string', 10, 2);

function sahu4you_remove_styles_scripts_query_string($src) {
    if (strpos($src, '?ver='))
        $src = remove_query_arg('ver', $src);
    return $src;
}

// Enqueue Scripts
add_action('wp_enqueue_scripts', 'sahu4you_genesis_enqueue_scripts');

function sahu4you_genesis_enqueue_scripts() {
    wp_enqueue_script('sahu4you-js', get_stylesheet_directory_uri() . '/lib/js/main.js', array('jquery'), '1.0.0', true);
}


// Enqueue Styles
add_action('wp_enqueue_scripts', 'sahu4you_genesis_enqueue_styles');

function sahu4you_genesis_enqueue_styles() {
    wp_enqueue_style('fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array());
}

// Customize the Gravatar size in the author box
add_filter('genesis_author_box_gravatar_size', 'sahu4you_author_box_gravatar_size');

function sahu4you_author_box_gravatar_size($size) {
    return '100';
}

// Modify the size of the Gravatar in comments
add_filter('genesis_comment_list_args', 'sahu4you_comments_gravatar_size');

function sahu4you_comments_gravatar_size($args) {
    $args['avatar_size'] = 50;
    return $args;
}



// Add Read More button for articles on Archive pages
add_filter('excerpt_more', 'sahu4you_read_more_button');

function sahu4you_read_more_button() {
    return '...&nbsp;<a class="read-more" href="' . get_permalink() . '">Read More »</a>';
}

// Display Featured Image on top of the post
//add_action('genesis_entry_content', 'sahu4you_featured_post_image', 8);
function sahu4you_featured_post_image($content) {
    if (!is_singular('post')) {
        return;
    }
    the_post_thumbnail('post-image');
    echo $content;
}


// Remove Entry footer
remove_action('genesis_entry_footer', 'genesis_post_meta');

// Add custom thumbmails sizes
add_image_size('post-thumb', 640, 340, TRUE);
add_image_size('post-thumb', 360, 195, TRUE);
add_image_size('attachment-thumb', 100, 53, TRUE);
add_image_size('attachment-thumb', 700, 394, TRUE);

// Adding social media buttons settings
add_filter('genesis_theme_settings_defaults', 'sahu4you_social_defaults');

function sahu4you_social_defaults($defaults) {
    $list = sahu4you_get_social_media_list();
    foreach ($list as $key => $val) {
        $defaults[$key . "_url"] = "";
    }
    return $defaults;
}

add_action('genesis_settings_sanitizer_init', 'sahu4you_register_social_sanitization_filters');

function sahu4you_register_social_sanitization_filters() {
    $settings_array = array();
    $list = sahu4you_get_social_media_list();
    foreach ($list as $key => $val) {
        array_push($settings_array, $key . "_url");
    }
    genesis_add_option_filter('no_html', GENESIS_SETTINGS_FIELD, $settings_array);
}

add_action('genesis_theme_settings_metaboxes', 'sahu4you_register_social_settings_box');

function sahu4you_register_social_settings_box($_genesis_theme_settings_pagehook) {
    add_meta_box('sahu4you-social-settings', 'Social Icons', 'sahu4you_social_settings_box', $_genesis_theme_settings_pagehook, 'main', 'high');
}

function sahu4you_social_settings_box() {
    ?>
    <table class="form-table">
        <tbody>
    <?php
    $list = sahu4you_get_social_media_list();
    foreach ($list as $key => $val) {
        $url_slug = $key . "_url";
        ?>
                <tr>
                    <td><p><?php _e($val . ' URL', 'sahu4you-genesis-child'); ?></td>
                    <td><input class="regular-text" type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[<?php echo $url_slug; ?>]" value="<?php echo esc_url(genesis_get_option($url_slug)); ?>"/></td>
                </tr>
    <?php } ?>
        </tbody>
    </table>
    <?php
}

function sahu4you_get_social_media_list() {
    $social_media['facebook'] = "Facebook";
    $social_media['twitter'] = "Twitter";
    $social_media['google-plus'] = "Google +";
    $social_media['youtube'] = "Youtube";
    $social_media['instagram'] = "Instagram";
    $social_media['reddit'] = "Reddit";
    $social_media['pinterest'] = "Pinterest";
    $social_media['email'] = "Email";
    $social_media['rss'] = "RSS Feed";
    return $social_media;
}


// Add Footer Menu; removing Primary and Secondary Menus
/* add_theme_support('genesis-menus', array(
    'footer' => __('Footer Navigation Menu', 'genesis')
)); */

// Add social share button in entry footer
add_action('off-genesis_entry_footer', 'off-s4y_social_share_icons');
function s4y_social_share_icons() {
    $url = urlencode(get_permalink());
    // Get current page title
    $title = str_replace(' ', '%20', get_the_title());
    // Get Post Thumbnail for pinterest
    $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
    $blog_title = get_bloginfo('name');
    ?>
    <div id="social-share">
        <strong><span></span></strong> <i class="fa fa-share-alt"></i>&nbsp;&nbsp;
        <a href="https://www.facebook.com/sharer.php?u=<?php echo $url; ?>" target="_blank" class="facebook"><i class="fa fa-facebook"></i> <span></span></a>
        <a href="https://plus.google.com/share?url=<?php echo $url; ?>" target="_blank" class="gplus"><i class="fa fa-google-plus"></i> <span></span></a>
        <a href="https://twitter.com/intent/tweet?text=<?php echo $title; ?>&amp;url=<?php echo $url; ?>&amp;via=sahu4you" target="_blank" class="twitter"><i class="fa fa-twitter"></i> <span></span></a>
        <a href="#" target="_blank" class="gplus"><i class="fa fa-pinterest-p"></i> <span></span></a>
        <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $title; ?>" target="_blank" class="linkedin"><i class="fa fa-linkedin"></i> <span></span></a>
        <a href="whatsapp://send?text=<?php echo $title . ' ' . $url; ?>" target="_blank" class="whatsapp"><i class="fa fa-whatsapp"></i> <span></span></a>
    </div>
    <?php
}

add_filter('genesis_comment_form_args', 'sahu4you_remove_url_from_comment');
add_filter('comment_form_default_fields', 'sahu4you_remove_url_from_comment');

function sahu4you_remove_url_from_comment($fields) {

    if (isset($fields['url']))
        unset($fields['url']);

    if (isset($fields['fields']['url']))
        unset($fields['fields']['url']);

    return $fields;
}

//* Remove Gravatar in the wp comments
function disable_comment_avatar($avatar, $id_or_email, $size, $default, $alt){
global $in_comment_loop;
if(isset($in_comment_loop))
{
if($in_comment_loop == true){
return "";
}
else{
return $avatar;
}}
else{
return $avatar;}}
add_filter("get_avatar" , "disable_comment_avatar" , 1, 5);



// pagintion //

add_filter( 'genesis_prev_link_text', 'modify_previous_link_text' );
function modify_previous_link_text($text) {
        $text = '«';
        return $text;
}

add_filter( 'genesis_next_link_text', 'modify_next_link_text' );
function modify_next_link_text($text) {
        $text = '»';
        return $text;
}


//* Modify the length of post excerpts
add_filter( 'excerpt_length', 'sp_excerpt_length' );
function sp_excerpt_length( $length ) {
	return 30; // pull first 50 words
}

// Remove read more
//function new_excerpt_more( $more ) {
	//return '';
//}
//add_filter('excerpt_more', 'new_excerpt_more');




//* Post Meta With FA

add_filter('genesis_post_info', 'sp_post_info_filter');

function sp_post_info_filter($post_info) {
    if (!is_page()) {
        //$post_info = 'By: [post_author_posts_link before=""] | In: [post_categories before=""]| Last Updated: [post_date format="d/m/Y" before=""] | [post_comments][post_edit]';
        $post_info = '[post_author_posts_link before="<i class=\'fa fa-user\'></i> "] | [post_categories before="<i class=\'fa fa-folder-open\'></i> "] | [post_date format="d/m/Y" before="<i class=\'fa fa-calendar\'></i> "] | [post_comments before="<i class=\'fa fa-comment\'></i> "][post_edit]';
        return $post_info;
    }
}


remove_action('genesis_entry_footer', 'genesis_post_meta');

// Displays custom logo.
add_theme_support( 'custom-logo', array(
	'width'       => 196,
	'height'      => 36,
	'flex-width' => true,
	'flex-height' => true,
	'header-text' => array( '.site-title', '.site-description' ),
) );

// Display custom logo
add_action( 'genesis_site_title', 'the_custom_logo', 0 );


//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );


//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 600,
	'height'          => 160,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

/* Add a social sharing buttons **/
function s4yss_social_sharing_buttons($content) {
 global $post;
 if(is_singular()){
 $s4yssURL = urlencode(get_permalink());
 $s4yssTitle = str_replace( ' ', '%20', get_the_title());
 $s4yssThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
 $twitterURL = 'https://twitter.com/intent/tweet?text='.$s4yssTitle.'&amp;url='.$s4yssURL.'&amp;via=sahu4you';
 $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$s4yssURL;
 $googleURL = 'https://plus.google.com/share?url='.$s4yssURL;
 $linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$s4yssURL.'&amp;title='.$s4yssTitle;
 $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$s4yssURL.'&amp;media='.$s4yssThumbnail[0].'&amp;description='.$s4yssTitle;
 $content .= '<div class="s4yss-social">';
 $content .= '<h5>Sharing is Sexy:</h6><div class="s4yss-link s4yss-facebook"><a href="'.$facebookURL.'" target="_blank"><i class="fa fa-facebook"></i><span class="sshare_share"> Share</span></a></div>';
 $content .= '<div class="s4yss-link s4yss-twitter"><a href="'. $twitterURL .'" target="_blank"><i class="fa fa-twitter"></i><span class="sshare_share"> Tweet</span></a></div>';
 $content .= '<div class="s4yss-link s4yss-googleplus"><a href="'.$googleURL.'" target="_blank"><i class="fa fa-google-plus"></i><span class="sshare_share"> +1</span></a></div>';
 $content .= '<div class="s4yss-link s4yss-linkedin"><a href="'.$linkedInURL.'" target="_blank"><i class="fa fa-linkedin"></i><span class="sshare_share"> Share</span></a></div>';
 $content .= '<div class="s4yss-link s4yss-pinterest"><a href="'.$pinterestURL.'" data-pin-custom="true" target="_blank"><i class="fa fa-pinterest"></i><span class="sshare_share"> Pin it</span></a></div>';
 $content .= '</div>';
 return $content;
 }else{
 return $content;
 }
};
add_filter( 'the_content', 's4yss_social_sharing_buttons');


//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Change the footer text
add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
	$creds = '[footer_copyright] &middot; '  . get_bloginfo('name') . ' &middot; <a href="https://sahu4you.com/about-us/" rel="noopener" target="_blank">About Me</a> &middot <a href="https://sahu4you.com/contact-us/" rel="noopener" target="_blank">Contact Us</a> &middot <a href="https://sahu4you.com/privacy-policy/" rel="noopener" target="_blank">Privacy Policy</a> &middot <a href="https://sahu4you.com/" rel="" target="_blank">Designer</a> &middot ';
	return $creds;
}
