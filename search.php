<?php
/**
 * The search template file.
 
 */
 get_header(); ?>
<?php zippy_get_breadcrumb();?>

<div class="main_content">
  <div class="content_left ">
    <?php if (have_posts()) :?>
    <div class="post_author_timeline">
      <?php
	while ( have_posts() ) : the_post();
	$comments = get_comments_number(get_the_ID());
   $comment_unit = $comments <= 1?__("Comment","themetify"):__("Comments","zippy");
   $comment_str = $comments." ".$comment_unit;
	?>
      <div class="blog_item">
        <div class="post-date"><span><?php echo get_the_time("M");echo " ";echo get_the_time("d"); ?></span></div>
        <div class="blog_item_content">
          <h1><a href="<?php the_permalink();?>">
            <?php the_title();?>
            </a></h1>
          <div class="Directory">
            <?php _e("By","zippy");?>
            : <?php echo get_the_author_link();?><span class="text-sep-date">/</span>
            <?php _e("Tags","zippy");?>
            : <?php echo get_the_tag_list('',', ');?><span class="text-sep-date">/</span>
            <?php _e("Category","zippy");?>
            :
            <?php the_category(', '); ?>
            <span class="text-sep-date">/</span> <?php echo $comment_str;?></div>
          <?php the_excerpt();?>
          <div class="meta_info">
            <div class="alignright"><a href="<?php the_permalink();?>">
              <?php _e("Read More »","zippy");?>
              </a></div>
            <div class="clear"></div>
          </div>
        </div>
      </div>
      <?php endwhile;?>
      <div class="clear"></div>
    </div>
    <!--post_author_timeline-->
    <div class="patt border">
      <?php if(function_exists("zippy_native_pagenavi")){zippy_native_pagenavi("echo",$wp_query);}?>
    </div>
    <?php else : ?>
    <header class="page-header">
      <h1 class="page-title">
        <?php _e( 'Nothing Found', 'zippy' ); ?>
      </h1>
    </header>
    <div class="page-content page_404">
      <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
      <p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'zippy' ), admin_url( 'post-new.php' ) ); ?></p>
      <?php elseif ( is_search() ) : ?>
      <p>
        <?php _e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'zippy' ); ?>
      </p>
      <div class="search_form">
        <form id="searchform_404" class="searchform_404" action="<?php echo home_url(); ?>/" method="get" role="search">
          <input type="text" value="Search" onFocus="if(this.value=='Search'){this.value=''}" onBlur="if(this.value==''){this.value='Search'}" name="s" id="s" class="search_text">
          <input name="gy" type="submit" class="search-button">
        </form>
        <div class="clear"></div>
      </div>
      <?php else : ?>
      <p>
        <?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'zippy' ); ?>
      </p>
      <div class="search_form">
        <form id="searchform_404" class="searchform_404" action="<?php echo home_url(); ?>/" method="get" role="search">
          <input type="text" value="Search" onFocus="if(this.value=='Search'){this.value=''}" onBlur="if(this.value==''){this.value='Search'}" name="s" id="s" class="search_text">
          <input name="gy" type="submit" class="search-button">
        </form>
        <div class="clear"></div>
      </div>
      <?php endif; ?>
    </div>
    <?php endif;?>
    <div class="clear"></div>
  </div>
  <div class="content_right">
    <?php zippy_get_sidebar(6); ?>
  </div>
  <div class="clear"></div>
</div>
<!--main_content-->
<div class="main_content">
  <div class="border-top"></div>
</div>
<!--main_content-->
<?php get_footer(); ?>
