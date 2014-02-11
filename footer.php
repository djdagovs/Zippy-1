<?php
/**
 * The template for displaying the footer.
 

 */

?>
<?php
 $enable_footer_service = zippy_options_array('enable_footer_service');
 
 if($enable_footer_service == 1){
?>
<div class="main_content footer">
<div class="box2">
<?php 
 for($i=1;$i<=4;$i++){
 $footer_service_icon        = zippy_options_array('footer_service_icon_'.$i);
 $footer_service_link        = zippy_options_array('footer_service_link_'.$i);
 $footer_service_title       = zippy_options_array('footer_service_title_'.$i);
 $footer_service_description = zippy_options_array('footer_service_description_'.$i);
 $footer_service_link        =($footer_service_link=="" || $footer_service_link=="http://")?"#":$footer_service_link;
?>
<div class="columns-4 left footer_service_<?php echo $i;?>">
<?php if(isset($footer_service_icon) && $footer_service_icon!=""){?>
<div class="images"><a target="_blank" href="<?php echo esc_url($footer_service_link);?>"><img src="<?php echo $footer_service_icon;?>" alt="" /></a></div>
<?php }?>
<h2><a href="<?php echo esc_url($footer_service_link);?>"><?php echo $footer_service_title;?></a></h2>
<p class="text"><?php echo $footer_service_description;?></p>
</div>
<?php }?>

<div class="clear"></div>
</div>
<div class="border-top"></div>
</div><!--main_content-->
<?php }?>

<div class="main_content copyright_wrap">
<div class="copyright">Copyright © <?php echo date("Y");?>. All Rights Reserved. Powered by <a href="<?php echo esc_url("http://wordpress.org");?>">WordPress</a>. Designed by <a href="<?php echo esc_url("http://www.mageewp.com/");?>">MageeWP Themes</a></div>
</div><!--main_content-->
<?php wp_footer(); ?>
</body>
</html>

