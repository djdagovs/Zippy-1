<?php
/**
 * The Header for our theme.
 *
 
 */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title('|', true, 'right'); ?></title>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="head">
<div class="head_content">
<div class="logo"><div class="logo_pic"><a href="<?php echo esc_url(home_url('/')); ?>"><?php if ( zippy_options_array('logo') ) { ?>
            <img src="<?php echo zippy_options_array('logo'); ?>" alt="<?php bloginfo('name'); ?>" />
            <?php }else{ ?><span class="site-name"><?php bloginfo('name'); ?></span><?php }?></a>
			</div>
			<div class="tagline"><?php echo  get_bloginfo( 'description' );?></div>
			</div>
<div id="nav">
<?php echo zippy_get_social_network(array("facebook",'twitter','google_plus','youtube','pinterest','rss'));?>
<div class="clear"></div>
   <div class="nav_menu">

        <?php
if(function_exists('wp_nav_menu')) {
wp_nav_menu(array('theme_location'=>'primary','depth'=>0,'container'=>'','container_class'=>'main-menu','menu_id'=>'menu-main','menu_class'=>'main-nav','link_before' => '<span>', 'link_after' => '</span>'));
}
?> </div>

</div>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div><!--head-->
