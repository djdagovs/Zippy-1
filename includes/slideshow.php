<?php
 add_action('init', 'zippy_slider_register');
 function zippy_slider_register() {
 
	$labels = array(
		'name' => __('Zippy Sliders',"zippy"),
		'singular_name' => 'Slider',
		'add_new_item' => __('Add New Slider',"zippy"),
	);
 
	$args = array(
		'labels' => $labels,
		'public' => false,
		'show_ui' => true,
		'menu_icon' => get_template_directory_uri().'/images/slideshow.png',
		'can_export' => true,
		'exclude_from_search' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 6,
		'rewrite' => array('slug' => 'slider'),
		'supports' => array('title')
	  ); 
 	   
	register_post_type( 'zippy_slider' , $args );
   }

	add_action("admin_init", "zippy_slider_init");
	 
 function zippy_slider_init(){
	  add_meta_box("zippy_slider_slides", "Slides", "zippy_slider_slides", "zippy_slider", "normal", "high");
	}
	 
	function zippy_slider_slides(){
	global $post;
	if(!isset($post->ID)) return;
	$custom = get_post_custom($post->ID);
	$custom["_magee_custom_slider"][0] = isset($custom["_magee_custom_slider"][0])?$custom["_magee_custom_slider"][0]:"";
	$slider = unserialize($custom["_magee_custom_slider"][0] );
  
	wp_enqueue_script( 'zippy-admin-slider' );  
	wp_print_scripts('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
    wp_register_style('options_ui', get_template_directory_uri() . '/styles/slideshow.css', false, '', 'all');
    wp_enqueue_style('options_ui');
  ?>
  <script>
  jQuery(document).ready(function() {
  
	jQuery(function() {
		jQuery( "#zippy-slider-items" ).sortable({placeholder: "ui-state-highlight"});
		jQuery( "#zippy-slider-items" ).disableSelection();
	});

	function custom_slider_uploader(field) {
		var button = "#upload_"+field;
		jQuery(button).click(function() {
			window.restore_send_to_editor = window.send_to_editor;
			tb_show('', 'media-upload.php?referer=zippy-settings&amp;type=image&amp;TB_iframe=true&amp;post_id=0');
			zippy_set_slider_img(field);
			return false;
		});

	}
	function zippy_set_slider_img(field) {
		window.send_to_editor = function(html) {
			imgurl = jQuery('img',html).attr('src');
			
			if(typeof imgurl == 'undefined') 
				imgurl = jQuery(html).attr('src');
				
			classes = jQuery('img', html).attr('class');
			if(typeof classes != 'undefined')
				id = classes.replace(/(.*?)wp-image-/, '');
			
			if(typeof classes == 'undefined'){ 
				classes = jQuery(html).attr('class');
				if(typeof classes != 'undefined')
					id = classes.replace(/(.*?)wp-image-/, '');
			}
				
	jQuery('#zippy-slider-items').append('<li id="listItem_'+ nextCell +'" class="ui-state-default"><div class="widget-content option-item"><div class="slider-img"><img src="'+imgurl+'" alt=""></div><label for="custom_slider['+ nextCell +'][title]"><span>Slide Title :</span><input id="custom_slider['+ nextCell +'][title]" name="custom_slider['+ nextCell +'][title]" value="" type="text" /></label><label for="custom_slider['+ nextCell +'][link]"><span>Slide Link :</span><input id="custom_slider['+ nextCell +'][link]" name="custom_slider['+ nextCell +'][link]" value="" type="text" /></label><label for="custom_slider['+ nextCell +'][caption]"><span style="float:left" >Slide Caption :</span><textarea name="custom_slider['+ nextCell +'][caption]" id="custom_slider['+ nextCell +'][caption]"></textarea></label><input id="custom_slider['+ nextCell +'][id]" name="custom_slider['+ nextCell +'][id]" value="'+id+'" type="hidden" /><a class="del-item"></a></div></li>');
    jQuery(".ui-state-default .widget-content input").click(function(){jQuery(this).focus();});
	jQuery(".ui-state-default .widget-content textarea").click(function(){jQuery(this).focus();});
			nextCell ++ ;
			tb_remove();
			window.send_to_editor = window.restore_send_to_editor;
		}
	};
	
	custom_slider_uploader("add_slide");
	
	jQuery(".ui-state-default .widget-content input").click(function(){jQuery(this).focus();});
	jQuery(".ui-state-default .widget-content textarea").click(function(){jQuery(this).focus();});

	jQuery(".del-item").live("click" , function() {
		jQuery(this).parent().parent().addClass('removered').fadeOut(function() {
			jQuery(this).remove();
		});
	});
	
});

  </script>
  
 <input id="upload_add_slide" type="button" class="options-save button-primary" value="Add New Slide">

	<ul id="zippy-slider-items">
	<?php
	$i=0;
	if( isset($slider) && is_array($slider) ){
	foreach( $slider as $slide ):
		$i++; ?>
		<li id="listItem_<?php echo $i ;?>"  class="ui-state-default">
			<div class="widget-content option-item">
				<div class="slider-img"><?php echo wp_get_attachment_image( $slide['id'] , 'thumbnail' );  ?></div>
				<label for="custom_slider[<?php echo $i ;?>][title]"><span><?php _e("Slide Title","zippy");?> :</span><input id="custom_slider[<?php echo $i; ?>][title]" name="custom_slider[<?php echo $i ;?>][title]" value="<?php  echo stripslashes( $slide['title'] )  ?>" type="text" /></label>
				<label for="custom_slider[<?php echo $i ;?>][link]"><span><?php _e("Slide Link","zippy");?> :</span><input id="custom_slider[<?php echo $i ;?>][link]" name="custom_slider[<?php echo $i;?>][link]" value="<?php  echo stripslashes( $slide['link'] )  ?>" type="text" /></label>
				<label for="custom_slider[<?php echo $i; ?>][caption]"><span style="float:left" ><?php _e("Slide Caption","zippy");?> :</span><textarea name="custom_slider[<?php echo $i ;?>][caption]" id="custom_slider[<?php echo $i;?>][caption]"><?php echo stripslashes($slide['caption']) ; ?></textarea></label>
				<input id="custom_slider[<?php echo $i ;?>][id]" name="custom_slider[<?php echo $i; ?>][id]" value="<?php  echo $slide['id'] ; ?>" type="hidden" />
				<a class="del-item"></a>
			</div>
		</li>
	<?php endforeach; 
	}else{
		echo '<p>'.__("Use the button above to add Slides !","zippy").'</p>';
	}
	echo '<script>var nextCell = '.($i+1).';</script>';
}
	
	add_action('save_post', 'save_slide');
	function save_slide(){
	  global $post;
	  if(isset($post->ID)){
		if( isset($_POST['custom_slider']) && $_POST['custom_slider'] != "" ){
			update_post_meta($post->ID, '_magee_custom_slider' , $_POST['custom_slider']);		
		}
		else{ 
			delete_post_meta($post->ID, '_magee_custom_slider' );
		}
		}
	}
	
	add_filter("manage_edit-zippy_slider_columns", "zippy_slider_edit_columns");
	function zippy_slider_edit_columns($columns){
	  $columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => __("Title","zippy"),
		"slides" => __("Number of Slides","zippy"),
		"date" => __("Date","zippy"),
	  );
	 
	  return $columns;
	}

	add_action("manage_zippy_slider_posts_custom_column",  "zippy_slider_custom_columns");
	function zippy_slider_custom_columns($column){
		global $post;
		switch ($column) {
			case "slides":
				$custom_slider_args = array( 'post_type' => 'zippy_slider', 'p' => $post->ID );
				$custom_slider = new WP_Query( $custom_slider_args );
				while ( $custom_slider->have_posts() ) {
					$number =0;
					$custom_slider->the_post();
					$custom = get_post_custom($post->ID);
					if( !empty($custom["_magee_custom_slider"][0])){
						$slider = unserialize( $custom["_magee_custom_slider"][0] );
						echo $number = count($slider);
					}
					else echo 0;
				}
			break;
		}
	}
	
add_filter("attribute_escape", "zippy_change_button_text", 10, 2);
function zippy_change_button_text($safe_text, $text) {
    return str_replace(__('Insert into Post','zippy'), __('Use this image','zippy'), $text);
}
