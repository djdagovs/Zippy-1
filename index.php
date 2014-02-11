<?php
/**
 * The main template file.
 *
 
 */

get_header(); ?>
<?php 
 $enable_home_page = zippy_options_array('enable_home_page');
 if($enable_home_page == 1 && is_front_page() && !is_page()){
 zippy_get_slider();
 }else{
 zippy_get_breadcrumb();
 }
?>
<div class="main_content">
<?php
   
  if($enable_home_page == 1 && is_front_page() && !is_page()){
   get_template_part("content","home");
   }
   else{
?>
<div class="content_left ">
 <?php if (have_posts()) :?>
 <div class="post_author_timeline">
<?php while ( have_posts() ) : the_post();
   
	get_template_part("content",get_post_format());
	
	 endwhile;
 ?>
   <div class="clear"></div>
</div><!--post_author_timeline-->
 <div class="patt border"><?php if(function_exists("zippy_native_pagenavi")){zippy_native_pagenavi("echo",$wp_query);}?></div>
  <?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

<div class="clear"></div>
</div>
<div class="content_right">
<?php if ( function_exists('dynamic_sidebar')) : 
   if(is_active_sidebar(4)){
   dynamic_sidebar(4);
}
else{
dynamic_sidebar(1) ;

}
 endif; ?>
 </div>
<div class="clear"></div>
</div><!--main_content-->
<?php
	}
?>
<div class="main_content"><div class="border-top"></div></div><!--main_content-->
<?php get_footer(); ?>