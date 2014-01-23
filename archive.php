<?php
/**
 * The archive template file.
 *
 
 */

get_header(); ?>
<?php zippy_get_breadcrumb();?>
<div class="main_content">
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
<?php zippy_get_sidebar(5); ?>
 </div>
<div class="clear"></div>
</div><!--main_content-->
<div class="main_content"><div class="border-top"></div></div><!--main_content-->
<?php get_footer(); ?>