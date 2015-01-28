jQuery(function() {
	
	jQuery("ul.themes_list li a").each(function() {
		var self = jQuery(this);
		var data =  self.data("1theme-info");
		data.color = (typeof data.color != "undefined") ? "style='background-color:"+data.color+";color:#fff'" : false;
		data.screen = (typeof data.screen != "undefined") ? "<img src='"+ data.screen +"' alt='' width='390' height='300' class='screen_1theme' />" : false;
		data.category = (typeof data.category != "undefined") ? "<span class='category_item' "+data.color+">" + data.category + "</span>" : false;
		
		self.append( data.category );
		self.append( data.screen );
	});
	
	
	function frameHeight()
	{
		jQuery('#frame').css('height' , (jQuery(window).height() - jQuery('#bar_1theme').height()) + 'px' );
	}
	jQuery(window).resize( frameHeight );
	frameHeight();
	
	
	jQuery('#bar_1theme .themes_list li a').on('click', function() {
		var data = jQuery(this).data("1theme-info");
		
		window.location.href = data.href +  "/?iframe=true";
		
		
	
	});

});

