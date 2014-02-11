<?php
if( ! defined('ZIPPY_THEME_BASE_URL' ) ) 	 { 	define( 'ZIPPY_THEME_BASE_URL', get_template_directory_uri()); }
if( ! defined('ZIPPY_OPTIONS_FRAMEWORK' ) ) 	 { 	define( 'ZIPPY_OPTIONS_FRAMEWORK', get_template_directory().'/options-framework/' ); }
if( ! defined('ZIPPY_OPTIONS_FRAMEWORK_URI' ) ){	define( 'ZIPPY_OPTIONS_FRAMEWORK_URI',  ZIPPY_THEME_BASE_URL. '/options-framework/'); }
if( ! defined('ZIPPY_OPTIONS_PREFIXED' ) ){    define('ZIPPY_OPTIONS_PREFIXED' ,'zippy_');}
require_once( 'options-framework/options-framework.php' );
require_once( 'includes/metabox-options.php' );
require_once( 'includes/register-widget.php' );
require_once( 'includes/class-breadcrumb.php' );
if ( ! isset( $content_width ) ) $content_width = 1000;
/* 
 * Helper function to return the theme option value. If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 */

if ( ! function_exists( 'zippy_setup' ) ) :
function zippy_setup(){
$lang = ZIPPY_THEME_BASE_URL. '/lang';
load_theme_textdomain('zippy', $lang);
add_theme_support( 'post-thumbnails' ); 
$args = array();
add_theme_support( 'custom-header', $args );
add_theme_support( 'custom-background', $args );
add_theme_support( 'automatic-feed-links' );
add_theme_support('nav_menus');
register_nav_menus( array('primary' => __( 'Primary Menu', 'zippy' )));
add_editor_style("editor-style.css");
}
endif; // zippy_setup
add_action( 'after_setup_theme', 'zippy_setup' );
add_action( 'after_setup_theme', 'zippy_on_switch_theme' );

if ( !function_exists( 'zippy_of_get_option' ) ) {
function zippy_of_get_option($name, $default = false) {
	
	$optionsframework_settings = get_option(ZIPPY_OPTIONS_PREFIXED.'optionsframework');
	
	// Gets the unique option id
	$option_name = $optionsframework_settings['id'];
	
	if ( get_option($option_name) ) {
		$options = get_option($option_name);
	}
		
	if ( isset($options[$name]) ) {
		return $options[$name];
	} else {
		return $default;
	}
}
}

if ( !function_exists( 'zippy_of_get_options' ) ) {
function zippy_of_get_options($default = false) {
	
	$optionsframework_settings = get_option(ZIPPY_OPTIONS_PREFIXED.'optionsframework');
	
	// Gets the unique option id
	$option_name = $optionsframework_settings['id'];
	
	if ( get_option($option_name) ) {
		$options = get_option($option_name);
	}
		
	if ( isset($options) ) {
		return $options;
	} else {
		return $default;
	}
}
}
global $zippy_options;
$zippy_options = zippy_of_get_options();

function zippy_options_array($name){
	global $zippy_options;
	if(isset($zippy_options[$name]))
	return $zippy_options[$name];
	else
	return "";
}

// set default options
function zippy_on_switch_theme(){
 $optionsframework_settings = get_option( ZIPPY_OPTIONS_PREFIXED.'optionsframework' );
 if(!get_option($optionsframework_settings['id'])){
 $config = array();
 $output = array();
 $location = apply_filters( 'options_framework_location', array('admin-options.php') );
	        if ( $optionsfile = locate_template( $location ) ) {
	            $maybe_options = require_once $optionsfile;
	            if ( is_array( $maybe_options ) ) {
					$options = $maybe_options;
	            } else if ( function_exists( 'optionsframework_options' ) ) {
					$options = optionsframework_options();
				}
	        }
	    $options = apply_filters( 'of_options', $options );
		$config  =  $options;
		foreach ( (array) $config as $option ) {
			if ( ! isset( $option['id'] ) ) {
				continue;
			}
			if ( ! isset( $option['std'] ) ) {
				continue;
			}
			if ( ! isset( $option['type'] ) ) {
				continue;
			}
				$output[$option['id']] = apply_filters( 'of_sanitize_' . $option['type'], $option['std'], $option );
		}
		add_option($optionsframework_settings['id'],$output);
}
}
add_action('after_switch_theme', 'zippy_on_switch_theme');

/* 
 * This is an example of how to add custom scripts to the options panel.
 * This one shows/hides the an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'zippy_optionsframework_custom_scripts');

function zippy_optionsframework_custom_scripts() { 

}


add_filter('options_framework_location','zippy_options_framework_location_override');

function zippy_options_framework_location_override() {
	return array('/includes/admin-options.php');
}

add_action('wp_head', 'zippy_style_wp_head');
function zippy_style_wp_head() {
    global $content_width;
	echo "\n <style type='text/css'>\n ";
	
	
	//// tagline typography
	$tagline_typography = zippy_options_array('tagline_typography');
	if ($tagline_typography) { 
	echo '.logo div.tagline {font-family: ' . $tagline_typography['face']. '; font-size:'.$tagline_typography['size'] . '; font-style: ' . $tagline_typography['style'] . '; color:'.$tagline_typography['color'].';font-weight:'.$tagline_typography['style'] . '}';
	}
	
	//// breadcrumb background
	
	$breadcrumb_background = zippy_options_array('breadcrumb_background');
	if ($breadcrumb_background) {
	if (isset($breadcrumb_background['image']) && $breadcrumb_background['image']!="") {
	echo ".row-fluid .nav-molu{background:url(".$breadcrumb_background['image']. ")  ".$breadcrumb_background['repeat']." ".$breadcrumb_background['position']." ".$breadcrumb_background['attachment']."}\n";
	}
	else
	{
	if(isset($breadcrumb_background['color']) && $breadcrumb_background['color'] !=""){
	echo ".row-fluid .nav-molu{ background:".$breadcrumb_background['color'].";}\n";
	}
	}
	}
	//// body background
	$body_background = zippy_options_array('body_background');
	if ($body_background) {
	if (isset($body_background['image']) && $body_background['image']!="") {
	echo "body{background:url(".$body_background['image']. ")  ".$body_background['repeat']." ".$body_background['position']." ".$body_background['attachment']."}\n";
	}else
	{
	if(isset($body_background['color']) && $body_background['color'] !=""){
	echo "body{ background:".$body_background['color'].";}\n";
	}}}
	//// content typography
	$content_typography = zippy_options_array('content_typography');
	if ($content_typography) { 
	echo 'div.blog_item_content,div.the_content {font-family: ' . $content_typography['face']. '; font-size:'.$content_typography['size'] . '; font-style: ' . $content_typography['style'] . '; color:'.$content_typography['color'].';font-weight:'.$content_typography['style'] . ';}';
	}
	////
	if(is_numeric($content_width)){echo "body div.main_content{width:".$content_width."px;}";}
echo "</style>\n \n ";
}

// Add custom css
function zippy_add_custom_css_header(){
  $custom_css = zippy_options_array('header_code');
  if(isset($custom_css) && $custom_css != ""){echo "<style type='text/css'>".$custom_css."</style>"; }
 } 

add_action('wp_head', 'zippy_add_custom_css_header');


/* 
 * Change the menu title name and slug
 */
 
 
function zippy_optionscheck_options_menu_params( $menu ) {
	$menu['page_title'] = __( 'Zippy Options', 'zippy');
	$menu['menu_title'] = __( 'Zippy Options', 'zippy');
	$menu['menu_slug'] = 'zippy-options';
	return $menu;
}

add_filter( 'optionsframework_menu', 'zippy_optionscheck_options_menu_params' );


function zippy_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'zippy' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'zippy_wp_title', 10, 2 );

add_action( 'wp_head', 'zippy_favicon' );
if(!function_exists('zippy_favicon'))
{
	function zippy_favicon()
	{
	    $url =  zippy_options_array('favicon');
		$icon_link = "";
		if($url)
		{
			$type = "image/x-icon";
			if(strpos($url,'.png' )) $type = "image/png";
			if(strpos($url,'.gif' )) $type = "image/gif";
		
			$icon_link = '<link rel="icon" href="'.esc_url($url).'" type="'.$type.'">';
		}
		
		echo $icon_link;
	}
}


  function zippy_custom_scripts(){
 
    wp_enqueue_script('jquery');
 	wp_register_script( 'zippy-default', ZIPPY_THEME_BASE_URL.'/js/zippy.js', false, '', false );
	wp_enqueue_script('zippy-default');
	if ( is_singular() ){
	wp_enqueue_script( 'comment-reply' );}

 }
 function zippy_custom_style(){

	wp_register_style( 'main_css', ZIPPY_THEME_BASE_URL.'/style.css', false, '', false );
	wp_enqueue_style('main_css');
	
	wp_register_style( 'media_css', ZIPPY_THEME_BASE_URL.'/styles/media.css', false, '', false );
	wp_enqueue_style('media_css');
 }
   if (!is_admin()) {
   add_action('wp_print_scripts', 'zippy_custom_scripts');
   add_action('wp_print_styles', 'zippy_custom_style');
  }

  
  	/*-------------------------------------------------------------------------------------------*/
/* Thumbnail Create */
/*-------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'zippy_new_thumb_resize' ) ){
			function zippy_new_thumb_resize( $thumbnail, $width, $height, $alt='', $forstyle = false ){
				global $themeslug;
					
				$new_method = true;
				$new_method_thumb = '';
				$external_source = false;
					
				$allow_new_thumb_method = !$external_source && $new_method;
				
				if ( $allow_new_thumb_method && $thumbnail <> '' ){
					$zippy_crop = true;
					$new_method_thumb = zippy_resize_image( $thumbnail, $width, $height, $zippy_crop );
					if ( is_wp_error( $new_method_thumb ) ) $new_method_thumb = '';
				}
				
				$thumb = esc_attr( $new_method_thumb );
				
				$output = '<img src="' . esc_url( $thumb ) . '" alt="' . esc_attr( $alt ) . '" width =' . esc_attr( $width ) . ' height=' . esc_attr( $height ) . ' />';
				if($thumb == ""){$output = get_the_post_thumbnail();}
				return ( !$forstyle ) ? $output : $thumb;
			}
		}

if ( ! function_exists( 'zippy_resize_image' ) ){
			function zippy_resize_image( $thumb, $new_width, $new_height, $crop ){
			
			if (is_numeric($thumb)) {
			$image_src = wp_get_attachment_image_src( $thumb, 'full' );
		    $thumb = isset($image_src[0])?$image_src[0]:"";
		} 
				if ( is_ssl() ) $thumb = preg_replace( '#^http://#', 'https://', $thumb );
				$info = pathinfo($thumb);
				$ext = $info['extension'];
				$name = wp_basename($thumb, ".$ext");
				$is_jpeg = false;
				$site_uri = apply_filters( 'zippy_resize_image_site_uri', site_url() );
				$site_dir = apply_filters( 'zippy_resize_image_site_dir', ABSPATH );
				
				#get main site url on multisite installation 
				if ( is_multisite() ){
					switch_to_blog(1);
					$site_uri = site_url();
					restore_current_blog();
				}
				
				if ( 'jpeg' == $ext ) {
					$ext = 'jpg';
					$name = preg_replace( '#.jpeg$#', '', $name );
					$is_jpeg = true;
				}
				
				$suffix = "{$new_width}x{$new_height}";
				
				$destination_dir = '' != get_option( 'zippy_images_temp_folder' ) ? preg_replace( '#\/\/#', '/', get_option( 'zippy_images_temp_folder' ) ) : null;
				
				$matches = apply_filters( 'zippy_resize_image_site_dir', array(), $site_dir );
				if ( !empty($matches) ){
					preg_match( '#'.$matches[1].'$#', $site_uri, $site_uri_matches );
					if ( !empty($site_uri_matches) ){
						$site_uri = str_replace( $matches[1], '', $site_uri );
						$site_uri = preg_replace( '#/$#', '', $site_uri );
						$site_dir = str_replace( $matches[1], '', $site_dir );
						$site_dir = preg_replace( '#\\\/$#', '', $site_dir );
					}
				}
				
				#get local name for use in file_exists() and get_imagesize() functions
				$localfile = str_replace( apply_filters( 'zippy_resize_image_localfile', $site_uri, $site_dir, zippy_multisite_thumbnail($thumb) ), $site_dir, zippy_multisite_thumbnail($thumb) );
				
				$add_to_suffix = '';
				if ( file_exists( $localfile ) ) $add_to_suffix = filesize( $localfile ) . '_';
				
				#prepend image filesize to be able to use images with the same filename
				$suffix = $add_to_suffix . $suffix;
				$destfilename_attributes = '-' . $suffix . '.' . $ext;
				
				$checkfilename = ( '' != $destination_dir && null !== $destination_dir ) ? path_join( $destination_dir, $name ) : path_join( dirname( $localfile ), $name );
				$checkfilename .= $destfilename_attributes;
				
				if ( $is_jpeg ) $checkfilename = preg_replace( '#.jpeg$#', '.jpg', $checkfilename );
				
				$uploads_dir = wp_upload_dir();
				$uploads_dir['basedir'] = preg_replace( '#\/\/#', '/', $uploads_dir['basedir'] );
				
				if ( null !== $destination_dir && '' != $destination_dir && apply_filters('zippy_enable_uploads_detection', true) ){
					$site_dir = trailingslashit( preg_replace( '#\/\/#', '/', $uploads_dir['basedir'] ) );
					$site_uri = trailingslashit( $uploads_dir['baseurl'] );
				}
				

				#check if we have an image with specified width and height
				
				if ( file_exists( $checkfilename ) ) return str_replace( $site_dir, trailingslashit( $site_uri ), $checkfilename );

				$size = @getimagesize( $localfile );
				if ( !$size ) return new WP_Error('invalid_image_path', __('Image doesn\'t exist'), $thumb);
				list($orig_width, $orig_height, $orig_type) = $size;
				
				#check if we're resizing the image to smaller dimensions
				if ( $orig_width > $new_width || $orig_height > $new_height ){
					if ( $orig_width < $new_width || $orig_height < $new_height ){
						#don't resize image if new dimensions > than its original ones
						if ( $orig_width < $new_width ) $new_width = $orig_width;
						if ( $orig_height < $new_height ) $new_height = $orig_height;
						
						#regenerate suffix and appended attributes in case we changed new width or new height dimensions
						$suffix = "{$add_to_suffix}{$new_width}x{$new_height}";
						$destfilename_attributes = '-' . $suffix . '.' . $ext;
						
						$checkfilename = ( '' != $destination_dir && null !== $destination_dir ) ? path_join( $destination_dir, $name ) : path_join( dirname( $localfile ), $name );
						$checkfilename .= $destfilename_attributes;
						
						#check if we have an image with new calculated width and height parameters
						if ( file_exists($checkfilename) ) return str_replace( $site_dir, trailingslashit( $site_uri ), $checkfilename );
					}
					
					#we didn't find the image in cache, resizing is done here
					if ( ! function_exists( 'wp_get_image_editor' ) ) {
						// compatibility with versions of WordPress prior to 3.5.
						$result = wp_get_image_editor( $localfile, $new_width, $new_height, $crop, $suffix, $destination_dir );
						
					} else {
						$zippy_image_editor = wp_get_image_editor( $localfile );
						
						if ( ! is_wp_error( $zippy_image_editor ) ) {
							$zippy_image_editor->resize( $new_width, $new_height, $crop );
							
							// generate correct file name/path
							$zippy_new_image_name = $zippy_image_editor->generate_filename( $suffix, $destination_dir );
							
							do_action( 'zippy_resize_image_before_save', $zippy_image_editor, $zippy_new_image_name );
							
							$zippy_image_editor->save( $zippy_new_image_name );
							
							// assign new image path
							$result = $zippy_new_image_name;
						} else {
							// assign a WP_ERROR ( WP_Image_Editor instance wasn't created properly )
							$result = $zippy_image_editor;
						}
					}
						
					if ( ! is_wp_error( $result ) ) {
						#transform local image path into URI
						
						if ( $is_jpeg ) $thumb = preg_replace( '#.jpeg$#', '.jpg', $thumb);
						
						$site_dir = str_replace( '\\', '/', $site_dir );
						$result = str_replace( '\\', '/', $result );
						$result = str_replace( '//', '/', $result );
						$result = str_replace( $site_dir, trailingslashit( $site_uri ), $result );
					}
					
					#returns resized image path or WP_Error ( if something went wrong during resizing )
					return $result;
				}
				
				#returns unmodified image, for example in case if the user is trying to resize 800x600px to 1920x1080px image
				return $thumb;
			}
		}

if ( ! function_exists( 'zippy_create_images_temp_folder' ) ){
			add_action( 'init', 'zippy_create_images_temp_folder' );
			function zippy_create_images_temp_folder(){
				#clean zippy_temp folder once per week
				if ( false !== $last_time = get_option( 'zippy_schedule_clean_images_last_time'  ) ){
					$timeout = 86400 * 7;
					if ( ( $timeout < ( time() - $last_time ) ) && '' != get_option( 'zippy_images_temp_folder' ) ) zippy_clean_temp_images( get_option( 'zippy_images_temp_folder' ) );
				}
				
				if ( false !== get_option( 'zippy_images_temp_folder' ) ) return;
				
				$uploads_dir = wp_upload_dir();
				$destination_dir = ( false === $uploads_dir['error'] ) ? path_join( $uploads_dir['basedir'], 'zippy_temp' ) : null;
					
				if ( ! wp_mkdir_p( $destination_dir ) ) update_option( 'zippy_images_temp_folder', '' );
				else { 
					update_option( 'zippy_images_temp_folder', preg_replace( '#\/\/#', '/', $destination_dir ) );
					update_option( 'zippy_schedule_clean_images_last_time', time() );
				}
			}
		}

if ( ! function_exists( 'zippy_clean_temp_images' ) ){
			function zippy_clean_temp_images( $directory ){
				$dir_to_clean = @ opendir( $directory );
				
				if ( $dir_to_clean ) {
					while (($file = readdir( $dir_to_clean ) ) !== false ) {
						if ( substr($file, 0, 1) == '.' )
							continue;
						if ( is_dir( $directory.'/'.$file ) )
							zippy_clean_temp_images( path_join( $directory, $file ) );
						else
							@ unlink( path_join( $directory, $file ) );
					}
					closedir( $dir_to_clean );
				}
				
				#set last time cleaning was performed
				update_option( 'zippy_schedule_clean_images_last_time', time() );
			}
		}

if ( ! function_exists( 'zippy_multisite_thumbnail' ) ){
			function zippy_multisite_thumbnail( $thumbnail = '' ) {
				// do nothing if it's not a Multisite installation or current site is the main one
				if ( is_main_site() ) return $thumbnail;
				
				# get the real image url
				preg_match( '#([_0-9a-zA-Z-]+/)?files/(.+)#', $thumbnail, $matches );
				if ( isset( $matches[2] ) ){
					$file = rtrim( BLOGUPLOADDIR, '/' ) . '/' . str_replace( '..', '', $matches[2] );
					if ( is_file( $file ) ) $thumbnail = str_replace( ABSPATH, get_site_url( 1 ), $file );
					else $thumbnail = '';
				}

				return $thumbnail;
			}
		}

if ( ! function_exists( 'zippy_update_uploads_dir' ) ){
			add_filter( 'update_option_upload_path', 'zippy_update_uploads_dir' );
			function zippy_update_uploads_dir( $upload_path ){
				$uploads_dir = wp_upload_dir();
				$destination_dir = ( false === $uploads_dir['error'] ) ? path_join( $uploads_dir['basedir'], 'zippy_temp' ) : null;
				
				update_option( 'zippy_images_temp_folder', preg_replace( '#\/\/#', '/', $destination_dir ) );

				return $upload_path;
			}
		}	

/*
*  page navigation
*
*/
function zippy_native_pagenavi($echo,$wp_query){
    if(!$wp_query){global $wp_query;}
    global $wp_rewrite;      
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
    $pagination = array(
    'base' => @add_query_arg('paged','%#%'),
    'format' => '',
    'total' => $wp_query->max_num_pages,
    'current' => $current,
    'prev_text' => '« ',
    'next_text' => ' »'
    );
 
    if( $wp_rewrite->using_permalinks() )
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg('s',get_pagenum_link(1) ) ) . 'page/%#%/', 'paged');
 
    if( !empty($wp_query->query_vars['s']) )
        $pagination['add_args'] = array('s'=>get_query_var('s'));
    if($echo == "echo"){
    echo '<p class="page_navi">'.paginate_links($pagination).'</p>'; 
	}else
	{
	
	return '<p class="page_navi">'.paginate_links($pagination).'</p>';
	}
}

//// get breadcrumb wrapper and slider

   function zippy_get_breadcrumb(){
   global $post;
   $show_breadcrumb = "";
   
   if(isset($post->ID) && is_numeric($post->ID)){
    $show_breadcrumb = get_post_meta( $post->ID, '_zippy_show_breadcrumb', true );
	}
	if($show_breadcrumb == 1 || $show_breadcrumb==""){
	echo  '<div class="row-fluid">
       <div class="nav-molu">
         <div class="container">';
 new zippy_breadcrumb;
echo '</div></div></div>';
	}
	}
	
	function zippy_get_slider(){
	$top_slider = "";
    
	$return = '<div class="banner"><div class="camera_wrap camera_azure_skin" id="camera_wrap_banner">';
	 for($i=1;$i<=5;$i++){
	 $title = zippy_options_array('zippy_slide_title_'.$i);
	 $text = zippy_options_array('zippy_slide_text_'.$i);
	 $image = zippy_options_array('zippy_slide_image_'.$i);
	 $link = zippy_options_array('zippy_slide_link_'.$i);
	 
	 if(isset($image) && strlen($image)>10){

	$thumb = zippy_new_thumb_resize( $image, 100, 75, $title,  true );
	if($link!=""){$title = '<a href="'.esc_url($link).'">'.$title.'</a>';}
	$return .= '<div data-thumb="'.$thumb.'" data-src="'.$image.'">
                <div class="camera_caption fadeFromBottom">
				<div class="slide-title">'.$title.'</div><p>'.$text.'</p></div>
            </div>';
	$top_slider = "active";
			}

	}
		$return .= '</div></div><!--banner-->';
		
		$slide_time = zippy_options_array("slide_time");
		$easing     = zippy_options_array("easing");
		$effect     = zippy_options_array("effect");
		
		$return .= '<script type="text/javascript">jQuery(document).ready(function(){
           if(jQuery("div.banner").length>0){
			jQuery("#camera_wrap_banner").camera({
				thumbnails: true,
				height: "500px",
				easing: "'.($easing?$easing:"easeInOutExpo").'",
				fx: "'.($effect?$effect:"random").'",
				time: '.($slide_time?$slide_time:"4000").'
			});
		   }});
		   </script>';
		   
	if($top_slider == "active"){
	
	wp_register_script( 'camera', ZIPPY_THEME_BASE_URL.'/js/camera.min.js', false, '', false );
	wp_enqueue_script('camera');
	wp_register_script( 'easing', ZIPPY_THEME_BASE_URL.'/js/jquery.easing.1.3.js', false, '', false );
	wp_enqueue_script('easing');	
	wp_register_script( 'mobile', ZIPPY_THEME_BASE_URL.'/js/jquery.mobile.customized.min.js', false, '', false );
	wp_enqueue_script('mobile');
	 wp_register_style( 'camera_css', ZIPPY_THEME_BASE_URL.'/styles/camera.css', false, '', false );
	wp_enqueue_style('camera_css');
	echo $return;
	
	} 
   }
   
   //// Get header social network icon list 
   
   function zippy_get_social_network($args){
   $return = "";
   if(is_array($args)){
   $return = '<ul class="follow">';
   foreach($args as $social){
   $social_link = zippy_options_array('social_'.$social);
   if($social_link!=""){
    $return .=  '<li><a href="'.$social_link.'" target="_blank" title="'.ucwords(str_replace("_"," ",$social)).'"><img src="'.ZIPPY_THEME_BASE_URL.'/images/social/'.$social.'.png" /></a></li>';
	}
   }
   $return .= '</ul>';
   }
   return $return;
   }
   // Get sidebar
   function zippy_get_sidebar($sidebar){
   if ( function_exists('dynamic_sidebar')){
if(is_active_sidebar($sidebar)){
   dynamic_sidebar($sidebar);
}
else{
dynamic_sidebar(1) ;

}
}else{wp_link_pages(); } 
   }
   
   //// Custom comments list
   
   function zippy_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ;?>">
     <div id="comment-<?php comment_ID(); ?>">
	 
	 <div class="comment-avatar"><?php echo get_avatar($comment,'52','' ); ?></div>
			<div class="comment-info">
			<div class="reply-quote">
             <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ;?>
			</div>
      <div class="comment-author vcard">
        
			<span class="fnfn"><?php printf(__('%s </cite><span class="says">says:</span>',"zippy"), get_comment_author_link()) ;?></span>
								<span class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ;?>">
<?php printf(__('%1$s at %2$s','zippy'), get_comment_date(), get_comment_time()) ;?></a>
<?php edit_comment_link(__('(Edit)','zippy'),'  ','') ;?></span>
				<span class="comment-meta">
					<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ;?>">-#<?php echo $depth?></a>				</span>

      </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.','zippy') ;?></em>
         <br />
      <?php endif; ?>

     

      <?php comment_text() ;?>
</div>
   
     </div>
<?php
        }