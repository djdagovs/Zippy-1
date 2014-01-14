<?php
/**
 * The template for displaying all pages.
 * @package WordPress
 */

get_header(); ?>
<?php zippy_get_breadcrumb_slider();?>
<div id="post-<?php the_ID(); ?>" <?php post_class("clear"); ?>>
<div class="main_content">
<?php
 if (have_posts()) :	while ( have_posts() ) : the_post();
   $enable_home_page = zippy_of_get_option('enable_home_page');
   if($enable_home_page == 1 && (is_home() || is_front_page())){
   get_template_part("content","home");
   }else{
?>
<div class="content_left ">
<div class="page_content_wrapper">
<h1 class="title-h1 post-title p_b20"><?php the_title();?></h1>
<div class="page_content the_content">
 <?php the_content();?>
 <?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'zippy' ),
				'after'  => '</div>',
			) );
		?>
   <?php 
echo '<div class="comment-wrapper">';
comments_template(); 
echo '</div>';
	?>	
 </div>
 <?php edit_post_link( __( 'Edit', 'zippy' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
</div>
</div>

<div class="content_right">
<?php zippy_get_sidebar(3); ?>
</div>
<?php
}
?>
<?php endwhile;endif;?>

</div>

</div>
<?php get_footer(); ?>