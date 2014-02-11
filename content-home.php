<?php
 	/*	
	*	The Template for displaying custom home page.
	*   @package WordPress
	*/


?>

<div class="title"><?php echo zippy_options_array('homepage_short_description');?></div>
<div class="border-top"></div>

<div class="box">

<div class="columns-3 left last33">
<h2><?php echo zippy_options_array('key_feature_title_1');?></h2>
<?php 
$key_feature_image = zippy_options_array('key_feature_image_1');
if($key_feature_image !=""){?>
<div class="img"><img width="260" src="<?php echo zippy_options_array('key_feature_image_1');?>" alt="" /></div>
<?php }?>
<p class="text"><?php echo zippy_options_array('key_feature_description_1');?></p>
<span class="more right"><a href="<?php echo esc_url(zippy_options_array('key_feature_link_1'));?>" target=""><?php _e("Learn More »","zippy");?></a></span>
</div>
<div class="columns-3 left">
<h2><?php echo zippy_options_array('key_feature_title_2');?></h2>
<?php 
$key_feature_image = zippy_options_array('key_feature_image_2');
if($key_feature_image !=""){?>
<div class="img"><img width="260" src="<?php echo zippy_options_array('key_feature_image_2');?>" alt="" /></div>
<?php }?>
<p class="text"><?php echo zippy_options_array('key_feature_description_2');?></p>
<span class="more right"><a href="<?php echo esc_url(zippy_options_array('key_feature_link_2'));?>" target=""><?php _e("Learn More »","zippy");?></a></span>

</div>

<div class="columns-3 left last3">
<h2><?php echo zippy_options_array('key_feature_title_3');?></h2>
<?php 
$key_feature_image = zippy_options_array('key_feature_image_3');
if($key_feature_image !=""){?>
<div class="img"><img  width="260" src="<?php echo zippy_options_array('key_feature_image_3');?>" alt="" /></div>
<?php }?>
<p class="text"><?php echo zippy_options_array('key_feature_description_3');?></p>
<span class="more right"><a href="<?php echo esc_url(zippy_options_array('key_feature_link_3'));?>" target=""><?php _e("Learn More »","zippy");?></a></span>

</div>
<div class="clear"></div>
</div>
<div class="border-top"></div>
