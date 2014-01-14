<?php
// global $wp_registered_sidebars;
#########################################

if ( function_exists('register_sidebar') )
{	
	
			register_sidebar(array(
				'name' => 'Displayed Everywhere',
				'before_widget' => '<div id="%1$s" class="widget %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
			));
		
			register_sidebar(array(
				'name' => 'Sidebar Blog Post',
				'before_widget' => '<div id="%1$s" class="widget %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
			));
		
			register_sidebar(array(
				'name' => 'Sidebar Pages',
				'before_widget' => '<div id="%1$s" class="widget %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
			));
		
			register_sidebar(array(
				'name' => 'Sidebar Category',
				'before_widget' => '<div id="%1$s" class="widget %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
			));
			register_sidebar(array(
				'name' => 'Sidebar Archive',
				'before_widget' => '<div id="%1$s" class="widget %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
			));
		
			register_sidebar(array(
				'name' => 'Sidebar Search',
				'before_widget' => '<div id="%1$s" class="widget %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
			));
			register_sidebar(array(
				'name' => 'Sidebar Tags',
				'before_widget' => '<div id="%1$s" class="widget %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
			));
		
	

}

	/********************  Recent Post*************************************/

 register_widget('zippy_recentPost');
 class zippy_recentPost extends WP_Widget {

	function zippy_recentPost() {
		$widget_ops = array( 'classname' => 'recentpost-widget', 'description' => __('Display the recent posts on your website.', 'zippy') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'recentpost-widget' );
		$this->WP_Widget( 'recentpost-widget', __('(zippy) Recent Posts', 'zippy'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $zippy_options;
		extract( $args );
		$title = apply_filters('Recent Posts', $instance['title'] );
		$post_cat = $instance['post_cat'];
		if($post_cat == "All"){ $post_cat = ''; }
		$show_num = $instance['show_num'];
		echo $before_widget;
		if($title)
		echo $before_title . $title . $after_title;
		$custom_posts = get_posts('showposts='.$show_num.'&cat='.get_cat_ID($post_cat));
		if( !empty($custom_posts) ){ 
			echo "<div class='zippy-recent-post-widget'><ul>";
			foreach($custom_posts as $custom_post) { 
				?>
				
				<li>
							<?php
								$thumbnail_id = get_post_thumbnail_id( $custom_post->ID );	
								if(isset($thumbnail_id) && is_numeric($thumbnail_id)){			
								$thumbnail = wp_get_attachment_image_src( $thumbnail_id , 'full' );	
								$alt_text = get_post_meta($thumbnail_id , '_wp_attachment_image_alt', true);
								$thumb = zippy_new_thumb_resize($thumbnail[0], '60', '45', '', true );
								if( !empty($thumbnail[0]) ){
									echo '<div class="image"> <a href="'.get_permalink( $custom_post->ID ).'"><img src="' . $thumb . '" alt="'. $alt_text .'"/></a></div>';
								}
								}
							?>
						
<div class="post-holder"><a href="<?php echo get_permalink( $custom_post->ID ); ?>"><?php echo $custom_post->post_title; ?> </a><div class="meta"> <?php echo get_the_time("M dS, Y", $custom_post->ID);?></div></div></li>

				
				<?php 
				
			}
			echo "</ul></div>";
		}
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['post_cat'] = strip_tags( $new_instance['post_cat'] );
		$instance['show_num'] = strip_tags( $new_instance['show_num'] );

		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'title' => __('Recent Posts', 'zippy'), 'post_cat' => __('All', 'zippy'), 'show_num' => '4');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title :', 'zippy'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'post_cat' ); ?>"><?php _e('Category :', 'zippy'); ?></label>		
			<select name="<?php echo $this->get_field_name( 'post_cat' ); ?>" id="<?php echo $this->get_field_id( 'post_cat' ); ?>">
				<option value="" <?php if (  $instance['post_cat'] == "" ) echo ' selected="selected"'; ?>>All Categories</option>	
			<?php 	
			$category_list = get_categories('taxonomy=category'); 
			if($category_list){
			foreach($category_list as $category ){
			?>
				<option value="<?php echo $category->cat_name; ?>" <?php if (  $instance['post_cat'] == $category->cat_name ) echo ' selected="selected"'; ?>><?php echo $category->cat_name; ?></option>				
			<?php } }?>	
			</select> 
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show_num' ); ?>"><?php _e('Show Count :', 'zippy'); ?></label>
			<input id="<?php echo $this->get_field_id( 'show_num' ); ?>" name="<?php echo $this->get_field_name( 'show_num' ); ?>" value="<?php echo $instance['show_num']; ?>" class="" />
		</p>

	<?php
	}
}

    /********************  Popular post *************************************/
	
   register_widget('zippy_popular_post');
  class zippy_popular_post extends WP_Widget {

	function  zippy_popular_post() {
		$widget_ops = array( 'classname' => 'popularpost-widget', 'description' => __('Display the popular posts on your website.', 'zippy') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'popularpost-widget' );
		$this->WP_Widget( 'popularpost-widget', __('(zippy) Popular Posts', 'zippy'), $widget_ops, $control_ops );
	}
	function widget( $args, $instance ) {
	    global $zippy_options;
		extract( $args );
		$title = apply_filters('Most Popular', $instance['title'] );
		$show_num = $instance['show_num'];
		echo $before_widget;
		if($title){
			echo $before_title . $title . $after_title;
		}

		$custom_posts = get_posts('showposts='.$show_num.'&orderby=comment_count');
		if( !empty($custom_posts) ){ 
			echo "<div class='zippy-recent-post-widget'><ul>";
			foreach($custom_posts as $custom_post) { 	
				?>
				
				<li>
							<?php
								$thumbnail_id = get_post_thumbnail_id( $custom_post->ID );	
								if(isset($thumbnail_id) && is_numeric($thumbnail_id)){			
								$thumbnail = wp_get_attachment_image_src( $thumbnail_id , 'full' );	
								$alt_text = get_post_meta($thumbnail_id , '_wp_attachment_image_alt', true);
								$thumb = zippy_new_thumb_resize($thumbnail[0], '60', '45', '', true );
								if( !empty($thumbnail[0]) ){
									echo '<div class="image"> <a href="'.get_permalink( $custom_post->ID ).'"><img src="' . $thumb . '" alt="'. $alt_text .'"/></a></div>';
								}
								}
							?>
						
<div class="post-holder"><a href="<?php echo get_permalink( $custom_post->ID ); ?>"><?php echo $custom_post->post_title; ?> </a><div class="meta"> <?php echo get_the_time("M dS, Y", $custom_post->ID);?></div></div></li>

										
				<?php 
				
			}
			echo "</ul></div>";
		}
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['show_num'] = strip_tags( $new_instance['show_num'] );
		
		return $instance;
	}
	function form( $instance ) {
		$defaults = array( 'title' => __('Popular Posts', 'zippy'), 'post_cat' => __('0', 'zippy'), 'show_num' => '3');
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		?>
     <ul>
		<li><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'zippy'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"/>
		</li>
		<li>
			<label for="<?php echo $this->get_field_id( 'show_num' ); ?>"><?php _e('Show Count', 'zippy'); ?></label>
			<input id="<?php echo $this->get_field_id( 'show_num' ); ?>" name="<?php echo $this->get_field_name( 'show_num' ); ?>" value="<?php echo $instance['show_num']; ?>" />
		</li>
		
		
		</ul>

	<?php
	}
}
