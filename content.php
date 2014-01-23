<?php
/**
 * Posts loop
 *
 
 */
   $comments = get_comments_number(get_the_ID());
   $comment_unit = $comments <= 1?__("Comment","zippy"):__("Comments","zippy");
   $comment_str = $comments." ".$comment_unit;
	?>
<div class="blog_item">
<div class="post-date"><span><?php echo get_the_time("M");echo " ";echo get_the_time("d"); ?></span></div>
<div class="blog_item_content">
<a href="<?php the_permalink();?>">
<h1 class="post-title"><?php the_title();?></h1></a>
<div class="Directory"><?php _e("By","zippy");?> : <?php echo get_the_author_link();?><span class="text-sep-date">/</span>
<?php _e("Tags","zippy");?> : <?php echo get_the_tag_list('',', ');?><span class="text-sep-date">/</span><?php _e("Category","zippy");?> : <?php the_category(', '); ?><span class="text-sep-date">/</span><a href="<?php the_permalink();?>#comments"><?php echo $comment_str;?></a></div>
  <?php
if ( has_post_thumbnail() && ! post_password_required()) { 
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); 
          if($image[0] !="" ){
                $img_url = zippy_new_thumb_resize($image[0],580,276,'',true);
				echo "<div class='blog-item1-image'><a href='".get_permalink()."'><img width='580' src='".$img_url."'  alt='".get_the_title()."'  /></a></div>";
				}

} 
  ?>
  <?php if ( is_single() ) : ?>
<?php the_content();
 wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'zippy' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
 
echo '<div class="comment-wrapper">';
comments_template(); 
echo '</div>';
?>
<?php else: // is_single() ?>
<?php the_excerpt();?>
<?php endif;?>
<?php if ( is_search() || is_home()) : ?>
<div class="meta_info">
<div class="alignright"><a href="<?php the_permalink();?>"><?php _e("Read More »","zippy");?></a></div>
<div class="clear"></div>
</div>

<?php endif;?>
</div>
</div>