jQuery(document).ready(function(){
  jQuery('.nav_menu ul li').hover(function(){
	jQuery(this).find('ul:first').slideDown(100);
	jQuery(this).addClass("hover");
	},function(){
	jQuery(this).find('ul').css('display','none');
	jQuery(this).removeClass("hover");
	});
  jQuery('.nav_menu li ul li:has(ul)').find("a:first").append(" <span class='menu_more'>»</span> ");
   var menu_width = 0;
		jQuery('.nav_menu ul:first > li').each(function(){
       menu_width = jQuery(this).outerWidth()+menu_width;
		if(menu_width > jQuery(this).parents("ul").innerWidth()){
			jQuery(this).prev().addClass("menu_last_item");
			menu_width = jQuery(this).outerWidth();
			}						   
});

//// camera slider
           if(jQuery("div.banner").length>0){
			jQuery('#camera_wrap_banner').camera({
				thumbnails: true,
				height: '500px'
			});
		   }
/*!
/* Mobile Menu
*/
(function($) {

	var current = $('#nav .nav_menu li.current-menu-item a').html();
	if( $('span').hasClass('custom-mobile-menu-title') ) {
		current = $('span.custom-mobile-menu-title').html();
	}
	else if( typeof current == 'undefined' || current === null ) {
		if( $('body').hasClass('home') ) {
			if( $('.logo span').hasClass('site-name') ) {
				current = $('.logo .site-name').html();
			}
			else {
				current = $('.logo .logo_pic img').attr('alt');
			}
		}
		else{
			if( $('body').hasClass('woocommerce') ) {
				current = $('h1.page-title').html();
			}
			else if( $('body').hasClass('archive') ) {
				current = $('h6.title-archive').html();
			}
			else if( $('body').hasClass('search-results') ) {
				current = $('h6.title-search-results').html();
			}
            else if( $('body').hasClass('page-template-blog-excerpt-php') ) {
                current = $('.current_page_item').text();
            }
            else if( $('body').hasClass('page-template-blog-php') ) {
                current = $('.current_page_item').text();
            }
			else {
				current = $('h1.post-title').html();
			}
		}
	};
	
    if(typeof current == 'undefined' || current === null){current = "GO TO";}
	$('#nav .nav_menu').append('<a id="responsive_menu_button"></a>');
	$('#nav .nav_menu').prepend('<div id="responsive_current_menu_item">' + current + '</div>');
	$('a#responsive_menu_button, #responsive_current_menu_item').click(function(){												
		$('body #nav .nav_menu ul').slideToggle( function() {
			if( $(this).is(':visible') ) {
				$('a#responsive_menu_button').addClass('responsive-toggle-open');
			}
			else {
				$('a#responsive_menu_button').removeClass('responsive-toggle-open');
				$('body #nav .nav_menu ul').removeAttr('style'); 
			}
		});
});

})(jQuery);

			
});
