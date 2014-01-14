<?php
/**
 * The template for displaying 404 pages (Not Found).
 * @package WordPress
 */

get_header(); ?>

<div class="row-fluid">
<div class="nav-molu">
  <div class="container">
    <?php new zippy_breadcrumb;?>
  </div>
</div>
<div class="main_content page_404">
  <div class="border-top"></div>
  <div class="title-404 width600"> <img src="<?php echo get_template_directory_uri();?>/images/404.png"  class="left m-r30"/>
    <h1>
      <?php _e('Whoops!', 'zippy'); ?>
    </h1>
    <h2>
      <?php _e('There is nothing here.', 'zippy'); ?>
    </h2>
    <p>
      <?php _e('Perhaps you were given the wrong URL?', 'zippy'); ?>
    </p>
  </div>
  <div class="border-top"></div>
  <div class="title-404 width600">
    <p>
      <?php _e('You could try searching for what you want here:', 'zippy'); ?>
    </p>
    <div class="search_form">
      <form id="searchform_404" class="searchform_404" action="<?php echo home_url(); ?>/" method="get" role="search">
        <input type="text" value="Search" onFocus="if(this.value=='Search'){this.value=''}" onBlur="if(this.value==''){this.value='Search'}" name="s" id="s" class="search_text">
        <input name="gy" type="submit" class="search-button">
      </form>
      <div class="clear"></div>
    </div>
    <p>
      <?php _e('Or check the url you typed is spelled correctly.<br>Or go to', 'zippy'); ?>
      <a href="<?php echo esc_url(home_url('/')); ?>">
      <?php _e('Homepage', 'zippy'); ?>
      </a></p>
  </div>
  <div class="clear"></div>
</div>
<!--main_content-->
<div class="main_content">
  <div class="border-top"></div>
</div>
<!--main_content-->
<?php get_footer(); ?>
