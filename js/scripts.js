jQuery(function() {
	function frameHeight()
	{
		jQuery('#frame').css('height' , (jQuery(window).height() - jQuery('#header-bar').height()) + 'px' );
	}
	jQuery(window).resize( frameHeight );
	frameHeight();
});