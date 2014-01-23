<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option(ZIPPY_OPTIONS_PREFIXED.'optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option(ZIPPY_OPTIONS_PREFIXED.'optionsframework', $optionsframework_settings);

	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */

function optionsframework_options() {

	// Background Defaults
	
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );
	//Breadcrumb Navigation Background
	$breadcrumb_background_defaults = array(
		'color' => '',
		'image' => ZIPPY_THEME_BASE_URL."/images/nav.jpg",
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'normal',
		'color' => '#666666' );
      
	  //Tagline Typography Defaults
	$tagline_typography_defaults = array(
		'size' => '13px',
		'face' => 'georgia',
		'style' => 'normal',
		'color' => '#666666' );
		
	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  ZIPPY_THEME_BASE_URL . '/images/';

	$options = array();
/// HEADER
	$options[] = array(
		'name' => __('Header Settings', 'zippy'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Upload Logo', 'zippy'),
		'desc' => __('Upload a logo image, or enter the URL to an image if its already uploaded. The themes default logo gets applied if the input field is left blank .  Logo Dimension: 240px * 75px (if your logo is larger you might need to modify style.css to align it perfectly).', 'zippy'),
		'id' => 'logo',
		'std' =>ZIPPY_THEME_BASE_URL.'/images/logo.png',
		'type' => 'upload');
		
		$options[] = array( 'name' => __('Tagline Typography', 'zippy'),
		'desc' => __('Tagline typography (Site description below logo image).', 'zippy'),
		'id' => "tagline_typography",
		'std' => $tagline_typography_defaults,
		'type' => 'typography' );
		

    $options[] = array(
		'name' => __('Favicon', 'zippy'),
		'desc' => __('An icon associated with a URL that is variously displayed, as in a browser\'s address bar or next to the site name in a bookmark list. Learn more about <a href="'.esc_url("http://en.wikipedia.org/wiki/Favicon").' target="_blank">Favicon</a>', 'zippy'),
		'id' => 'favicon',
		'type' => 'upload');
		
		$options[] = array(
		'name' =>  __('Breadcrumb Navigation Background', 'zippy'),
		'desc' => __('Change the breadcrumb navigation background CSS.', 'zippy'),
		'id' => 'breadcrumb_background',
		'std' => $breadcrumb_background_defaults,
		'type' => 'background' );
	
		
		$options[] = array(
		'name' => __('Custom CSS', 'zippy'),
		'desc' => __('The following css code will add to the header before the closing &lt;/head&gt; tag.', 'zippy'),
		'id' => 'header_code',
		'std' => 'body{margin:0px;}',
		'type' => 'textarea');
		$options[] = array(
		'name' => __('Facebook url', 'zippy'),
		'desc' => __('Your facebook url', 'zippy'),
		'id' => 'social_facebook',
		'std' => esc_url('#'),
		'type' => 'text');
		$options[] = array(
		'name' => __('Twitter url', 'zippy'),
		'desc' => __('Your Twitter url', 'zippy'),
		'id' => 'social_twitter',
		'std' => esc_url('#'),
		'type' => 'text');
		$options[] = array(
		'name' => __('Google plus url', 'zippy'),
		'desc' => __('Your Google plus url', 'zippy'),
		'id' => 'social_google_plus',
		'std' => esc_url('#'),
		'type' => 'text');
		$options[] = array(
		'name' => __('Youtube url', 'zippy'),
		'desc' => __('Your Youtube Url', 'zippy'),
		'id' => 'social_youtube',
		'std' => esc_url('#'),
		'type' => 'text');
		$options[] = array(
		'name' => __('Pinterest url', 'zippy'),
		'desc' => __('Your Pinterest Url', 'zippy'),
		'id' => 'social_pinterest',
		'std' => '#',
		'type' => 'text');
		$options[] = array(
		'name' => __('Rss url', 'zippy'),
		'desc' => __('Your Rss feed Url', 'zippy'),
		'id' => 'social_rss',
		'std' => '#',
		'type' => 'text');
		
	////	BODY
		
		$options[] = array(
		'name' => __('Body Style', 'zippy'),
		'type' => 'heading');
		
        $options[] = array(
		'name' =>  __('Body Background', 'zippy'),
		'desc' => __('Change the body background CSS.', 'zippy'),
		'id' => 'body_background',
		'std' => $background_defaults,
		'type' => 'background' );
		$options[] = array( 'name' => __('Content Typography', 'zippy'),
		'desc' => __('Content typography.', 'zippy'),
		'id' => "content_typography",
		'std' => $typography_defaults,
		'type' => 'typography' );
		
		////FOOTER
		$options[] = array(
		'name' => __('Footer', 'zippy'),
		'type' => 'heading');

		
		$options[] = array(
		'name' => __('Enable Footer Service', 'zippy'),
		'desc' => __('Active Footer Service Widget.', 'zippy'),
		'id' => 'enable_footer_service',
		'std' => '1',
		'type' => 'checkbox');
		
		$options[] = array(
		'name' => __('Footer Service Icon(Area #1)', 'zippy'),
		'id' => 'footer_service_icon_1',
		'std' =>ZIPPY_THEME_BASE_URL.'/images/about-us-icon.png',
		'type' => 'upload');
		$options[] = array(
		'name' => __('Footer Service Title(Area #1)', 'zippy'),
		'id' => 'footer_service_title_1',
		'std' => 'Service Title #1',
		'type' => 'text');		
		$options[] = array(
		'name' => __('Footer Service Link(Area #1)', 'zippy'),
		'desc' => __('Footer Service Title Link.', 'zippy'),
		'id' => 'footer_service_link_1',
		'std' => 'http://',
		'type' => 'text');
		$options[] = array(
		'name' => __('Footer Service Description(Area #1)', 'zippy'),
		'id' => 'footer_service_description_1',
		'std' => 'Nullam dignissim convallis est. In hac habitasse platea dictumst. Ut aut reiciendis voluptatibus, tortor!',
		'type' => 'textarea');
		$options[] = array(
		'name' => __('Footer Service Icon(Area #2)', 'zippy'),
		'id' => 'footer_service_icon_2',
		'std' =>ZIPPY_THEME_BASE_URL.'/images/contact-us-icon.png',
		'type' => 'upload');
		$options[] = array(
		'name' => __('Footer Service Title(Area #2)', 'zippy'),
		'id' => 'footer_service_title_2',
		'std' => 'Service Title #2',
		'type' => 'text');		
		$options[] = array(
		'name' => __('Footer Service Link(Area #2)', 'zippy'),
		'desc' => __('Footer Service Title Link.', 'zippy'),
		'id' => 'footer_service_link_2',
		'std' => 'http://',
		'type' => 'text');
		
		$options[] = array(
		'name' => __('Footer Service Description(Area #2)', 'zippy'),
		'id' => 'footer_service_description_2',
		'std' => 'Nullam dignissim convallis est. In hac habitasse platea dictumst. Ut aut reiciendis voluptatibus, tortor!',
		'type' => 'textarea');
		$options[] = array(
		'name' => __('Footer Service Icon(Area #3)', 'zippy'),
		'id' => 'footer_service_icon_3',
		'std' =>ZIPPY_THEME_BASE_URL.'/images/recent-commentd-icon.png',
		'type' => 'upload');
		$options[] = array(
		'name' => __('Footer Service Title(Area #3)', 'zippy'),
		'id' => 'footer_service_title_3',
		'std' => 'Service Title #3',
		'type' => 'text');		
		$options[] = array(
		'name' => __('Footer Service Link(Area #3)', 'zippy'),
		'desc' => __('Footer Service Title Link.', 'zippy'),
		'id' => 'footer_service_link_3',
		'std' => 'http://',
		'type' => 'text');
		$options[] = array(
		'name' => __('Footer Service Description(Area #3)', 'zippy'),
		'id' => 'footer_service_description_3',
		'std' => 'Nullam dignissim convallis est. In hac habitasse platea dictumst. Ut aut reiciendis voluptatibus, tortor!',
		'type' => 'textarea');
		$options[] = array(
		'name' => __('Footer Service Icon(Area #4)', 'zippy'),
		'id' => 'footer_service_icon_4',
		'std' =>ZIPPY_THEME_BASE_URL.'/images/recent-posts-icon.png',
		'type' => 'upload');
		$options[] = array(
		'name' => __('Footer Service Title(Area #4)', 'zippy'),
		'id' => 'footer_service_title_4',
		'std' => 'Service Title #4',
		'type' => 'text');		
		$options[] = array(
		'name' => __('Footer Service Link(Area #4)', 'zippy'),
		'desc' => __('Footer Service Title Link.', 'zippy'),
		'id' => 'footer_service_link_4',
		'std' => 'http://',
		'type' => 'text');
		$options[] = array(
		'name' => __('Footer Service Description(Area #4)', 'zippy'),
		'id' => 'footer_service_description_4',
		'std' => 'Nullam dignissim convallis est. In hac habitasse platea dictumst. Ut aut reiciendis voluptatibus, tortor!',
		'type' => 'textarea');
		

		
		////HOME PAGE
		$options[] = array(
		'name' => __('Home Page', 'zippy'),
		'type' => 'heading');
		
		$options[] = array(
		'name' => __('Enable Home Page', 'zippy'),
		'desc' => __('Active custom home page.  The standardized way of creating Static Front Pages: <a href="'.esc_url('http://codex.wordpress.org/Creating_a_Static_Front_Page').'" target="_blank">Creating a Static Front Page</a>', 'zippy'),
		'id' => 'enable_home_page',
		'std' => '1',
		'type' => 'checkbox');
		
		//HOME PAGE SLIDER
		$options[] = array('name' => __('Slideshow', 'zippy'),'id' => 'group_title','type' => 'title');
		
		$options[] = array('name' => __('Slide 1', 'zippy'),'id' => 'slide_group_start_1','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'zippy'),'id' => 'zippy_slide_image_1','type' => 'upload','std'=>ZIPPY_THEME_BASE_URL.'/images/zippy-banner-1.jpg');
		$options[] = array('name' => __('Title', 'zippy'),'id' => 'zippy_slide_title_1','type' => 'text','std'=>'Title 1');
		$options[] = array('name' => __('Text', 'zippy'),'id' => 'zippy_slide_text_1','type' => 'textarea','std'=>'Hic modo aliquid, ut infra ius textus amet tincidunt imago sedere involvent opportune. Usque essent omnia spatiosa satis sedeat. Yeah ... Sic. Nunquam tanta esse bonum est.');
		$options[] = array('name' => __('Link', 'zippy'),'id' => 'zippy_slide_link_1','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_1','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 2', 'zippy'),'id' => 'slide_group_start_2','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'zippy'),'id' => 'zippy_slide_image_2','type' => 'upload','std'=>ZIPPY_THEME_BASE_URL.'/images/zippy-banner-2.jpg');
		$options[] = array('name' => __('Title', 'zippy'),'id' => 'zippy_slide_title_2','type' => 'text','std'=>'Title 2');
		$options[] = array('name' => __('Text', 'zippy'),'id' => 'zippy_slide_text_2','type' => 'textarea','std'=>'Hic modo aliquid, ut infra ius textus amet tincidunt imago sedere involvent opportune. Usque essent omnia spatiosa satis sedeat. Yeah ... Sic. Nunquam tanta esse bonum est.');
		$options[] = array('name' => __('Link', 'zippy'),'id' => 'zippy_slide_link_2','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_2','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 3', 'zippy'),'id' => 'slide_group_start_3','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'zippy'),'id' => 'zippy_slide_image_3','type' => 'upload');
		$options[] = array('name' => __('Title', 'zippy'),'id' => 'zippy_slide_title_3','type' => 'text');
		$options[] = array('name' => __('Text', 'zippy'),'id' => 'zippy_slide_text_3','type' => 'textarea');
		$options[] = array('name' => __('Link', 'zippy'),'id' => 'zippy_slide_link_3','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_3','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 4', 'zippy'),'id' => 'slide_group_start_4','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'zippy'),'id' => 'zippy_slide_image_4','type' => 'upload');
		$options[] = array('name' => __('Title', 'zippy'),'id' => 'zippy_slide_title_4','type' => 'text');
		$options[] = array('name' => __('Text', 'zippy'),'id' => 'zippy_slide_text_4','type' => 'textarea');
		$options[] = array('name' => __('Link', 'zippy'),'id' => 'zippy_slide_link_4','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_4','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 5', 'zippy'),'id' => 'slide_group_start_5','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'zippy'),'id' => 'zippy_slide_image_5','type' => 'upload');
		$options[] = array('name' => __('Title', 'zippy'),'id' => 'zippy_slide_title_5','type' => 'text');
		$options[] = array('name' => __('Text', 'zippy'),'id' => 'zippy_slide_text_5','type' => 'textarea');
		$options[] = array('name' => __('Link', 'zippy'),'id' => 'zippy_slide_link_5','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_5','type' => 'end_group');
		
		
		//END HOME PAGE SLIDER
		$options[] = array(
		'name' => __('Short Description of The Top', 'zippy'),
		'id' => 'homepage_short_description',
		'std' => '"description words for the wordpress blog."',
		'type' => 'textarea');
		
		$options[] = array(
		'name' => __('Key Feature Title(Area #1)', 'zippy'),
		'id' => 'key_feature_title_1',
		'std' => 'Key Feature #1',
		'type' => 'text');
		$options[] = array(
		'name' => __('Key Feature Image(Area #1)', 'zippy'),
		'desc'=>__('Image Dimension: 260px * 150px ','zippy'),
		'id' => 'key_feature_image_1',
		'std' =>ZIPPY_THEME_BASE_URL.'/images/keyfeature.jpg',
		'type' => 'upload');
	  $options[] = array(
		'name' => __('Key Feature Link(Area #1)', 'zippy'),
		'desc' => __('Learn More Link.', 'zippy'),
		'id' => 'key_feature_link_1',
		'std' => 'http://',
		'type' => 'text');

	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);

	$options[] = array(
		'name' => __('Key Feature Description(Area #1)', 'zippy'),
		'id' => 'key_feature_description_1',
		'type' => 'editor',
		'std' =>'Hic modo aliquid, ut infra ius textus amet tincidunt imago sedere involvent opportune. Usque essent omnia spatiosa satis sedeat. Yeah ... Sic. Nunquam tanta esse bonum est.',
		'settings' => $wp_editor_settings );
  
    
	$options[] = array(
		'name' => __('Key Feature Title(Area #2)', 'zippy'),
		'id' => 'key_feature_title_2',
		'std' => 'Key Feature #2',
		'type' => 'text');
		$options[] = array(
		'name' => __('Key Feature Image(Area #2)', 'zippy'),
		'id' => 'key_feature_image_2',
		'std' =>ZIPPY_THEME_BASE_URL.'/images/keyfeature.jpg',
		'type' => 'upload');
		
		$options[] = array(
		'name' => __('Key Feature Link(Area #2)', 'zippy'),
		'desc' => __('Learn More Link.', 'zippy'),
		'id' => 'key_feature_link_2',
		'std' => 'http://',
		'type' => 'text');
	$options[] = array(
		'name' => __('Key Feature Description(Area #2)', 'zippy'),
		'id' => 'key_feature_description_2',
		'type' => 'editor',
		'std' =>'Hic modo aliquid, ut infra ius textus amet tincidunt imago sedere involvent opportune. Usque essent omnia spatiosa satis sedeat. Yeah ... Sic. Nunquam tanta esse bonum est.',
		'settings' => $wp_editor_settings );
    
		
		
		$options[] = array(
		'name' => __('Key Feature Title(Area #3)', 'zippy'),
		'id' => 'key_feature_title_3',
		'std' => 'Key Feature #3',
		'type' => 'text');
		$options[] = array(
		'name' => __('Key Feature Image(Area #3)', 'zippy'),
		'id' => 'key_feature_image_3',
		'std' =>ZIPPY_THEME_BASE_URL.'/images/keyfeature.jpg',
		'type' => 'upload');
     $options[] = array(
		'name' => __('Key Feature Link(Area #3)', 'zippy'),
		'desc' => __('Learn More Link.', 'zippy'),
		'id' => 'key_feature_link_3',
		'std' => 'http://',
		'type' => 'text');
	$options[] = array(
		'name' => __('Key Feature Description(Area #3)', 'zippy'),
		'id' => 'key_feature_description_3',
		'type' => 'editor',
		'std' =>'Hic modo aliquid, ut infra ius textus amet tincidunt imago sedere involvent opportune. Usque essent omnia spatiosa satis sedeat. Yeah ... Sic. Nunquam tanta esse bonum est.',
		'settings' => $wp_editor_settings );
    

	return $options;
}