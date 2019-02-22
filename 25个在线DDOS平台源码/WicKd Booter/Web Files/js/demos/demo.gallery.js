$(function () {
	
	var timeout = '';
	
	$('.gallery').find ('.frame').append ('<img src="./img/gallery/frame.png" alt="Frame" />');
	
	$('.gallery li').live ('mouseenter', function (e) {	
		var $this = $(this);
		
		timeout = setTimeout (function () {
			$this.find ('.actions').fadeIn ();		
			$this.find ('.img img').animate ({ opacity: '.35' });			
		}, 550);
		
	}).live ('mouseleave', function (e) {	
		clearTimeout (timeout);	
		
		$(this).find ('.actions').hide ();		
		$(this).find ('.img img').animate ({ opacity: '1' });			
	});
	
});