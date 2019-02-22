var page,
	navLinks;

	
$(document).ready(function() {
	$('html').removeClass('no-js'); // Remove this if using Modernizr

	var isMobile,
		isAndroid = (/android/gi).test(navigator.appVersion),
		isIDevice = (/iphone|ipad|ipod/gi).test(navigator.appVersion),
		isPlaybook = (/playbook/gi).test(navigator.appVersion),
		isTouchPad = (/hp-tablet/gi).test(navigator.appVersion);
	
	isMobile = (isAndroid || isIDevice || isPlaybook || isTouchPad);

	if (isMobile) {
		$("html").addClass("mobile");
		page = $('html,body');
	} else {
		page = $('#main');
	}
	
	navLinks = $('nav a[href^="#"]');
		
	checkNavIntegrity(); // This checks if there aren't any broken links in the menu (you can remove this line)

	// Change all articles ID to avoid interference with browser's own scrollTo#hash
	navLinks.each(function(){
		var target = $(this).attr('href').replace(/#/, '');
			$('#'+target).attr('id', target+'_modified'); // Change ID
	});
	

	scroll_handler();	// Set menu according to scroll position
	page.bind('scroll', scroll_handler);
	
	var hash_update_timer;
	
	// Top navigation links
	navLinks.mousedown(function() {
		// Change current active link
		$('nav a.active').removeClass('active');
		$(this).addClass('active');
		
		// Scroll the page!
		var target = $(this).attr('href'),
			targetPosition = page.scrollTop() + $(target+'_modified').position().top;
			targetPosition = (targetPosition == 0) ? targetPosition : targetPosition + 20; // Remove some padding

		clearTimeout(hash_update_timer); // Cancel any pending hash update 

		page.unbind('scroll', scroll_handler); // Turn off scroll_handler
		page.stop().animate({scrollTop: targetPosition}, 500, function() {
			clearTimeout(hash_update_timer); // Cancel any previous hash update again
			if (window.location.hash !== target) { // Update #hash in URL only if the new differs from the current one
				hash_update_timer = setTimeout(function(){location.hash = target;}, 10);
			}
			page.bind('scroll', scroll_handler); // Turn scroll_handler back on when animate complete
		});
	}).click(function(){
		return false;
	});


	// Make the logo points to the homepage
	$('.logo a').mousedown(function() {
		$('nav a:first').trigger('mousedown');
	//	$('nav a[href=#contact]').trigger('mousedown'); // Use this instead if you want the logo to points somewhere else
	}).click(function(){
		return false;
	});
	
	// Internal links outside the <nav> which have the .animate class
	$('a.animate[href*=#]:not(nav a)').click(function(){
		var target = $(this).attr('href');
		if ($('nav a[href='+target+']').length > 0){ // Target is part of the main navigation? (for which we altered the IDs)
			$('nav a[href='+target+']').trigger('mousedown');
		} else { // Target is outside main navigation: just scroll to target, no history management (which is good if you just want to scroll back to top using "#")
			targetPosition = target != '#' ? $(target).offset().top + page.scrollTop() - page.position().top : 0;
			page.unbind('scroll', scroll_handler); // Turn off the scroll_handler
			page.stop().animate({scrollTop: targetPosition}, 500, function() {
				page.bind('scroll', scroll_handler); // Turn scroll_handler back on when animate complete
			});
		}
		return false;
	});


	/* External links (just add the "targetblank" class to any link you want) */
	$('a.targetblank').click(function(e) {
		e.preventDefault();
		e.stopPropagation();
		window.open(this.href, '_blank');
	});

	
	// Set menu and scroll position according to #hash in URL
	hash_handler();
	
	 
	// Tabs (part of Skeleton)
	var tabs = $('ul.tabs');
	tabs.each(function(i) {
		//Get all tabs
		var tab = $(this).find('> li > a');
		tab.mousedown(function(e) {
			//Get Location of tab's content
			var contentLocation = $(this).attr('href');
			//Let go if not a hashed one
			if(contentLocation.charAt(0)=="#") {
				e.preventDefault();
				//Make Tab Active
				tab.removeClass('active');
				$(this).addClass('active');
				//Show Tab Content & add active class
				$(contentLocation).show().addClass('active').siblings().hide().removeClass('active');
			}
		}).click(function(e){
			e.preventDefault();
		});
	});
	

	// Forms: Submit through Ajax
	$("form.send-with-ajax").submit(function(e) {
	/* Add the class "send-with-ajax" to any form you want to have it handled here 
	  (don't forget the div with class="ajax-response" inside the <form> tag!) */
		e.preventDefault();
		var form = $(this),
			validationErrors = false;
		
		// Reset all messages
		$('.form-error-msg').remove();

		// Client-side validation for old browsers
		form.find("input[type='email'], input[required]").each(function(index){
			var inputValue = $(this).val(),
				inputRequired = $(this).attr('required'),
				inputType = $(this).attr('type');

				$(this).removeClass('form-error');
			
			if(inputRequired && inputValue == '') {
				$(this).after('<div class="form-error-msg">Please fill out this field.</div>');
				$(this).addClass('form-error');
				validationErrors = true;
			} else if(inputType == 'email' && !isValidEmail(inputValue)) {
				$(this).after('<div class="form-error-msg">Please enter an email address.</div>');
				$(this).addClass('form-error');
				validationErrors = true;
			}
		});

		if (!validationErrors) {
			form.find('button:submit, input:submit').html('Sending...');
			form.find('.ajax-response').empty();
			$.post(form.attr('action'), form.serialize(),
				function(data) {
					if (data.bFormSent) {
						form.find('.ajax-response').empty().html(data.aResults[0]);
						form.find('button:submit, input:submit').html('Submit Form');
						form.find('#form-email, #form-name, #form-message').val('');
					} else {
						form.find('.ajax-response').empty().wrapInner('<div class="form-error-msg"></div>');
						form.find('.ajax-response div').html(data.aErrors[0]);
						form.find('button:submit, input:submit').html('Try Again');
					}
				}, 'json');
		}
	});
	
}); // <-- document ready


$(window).hashchange(function(){
	// Set menu and scroll position according to #hash in URL
	hash_handler();
})


$(window).load(function() {

//	hash_handler(); // Re-call once page is fully loaded to correctly position the 	scroll

	// Main slider options
	$('.flexslider').find('.slides').removeClass('notloaded');
	$('.flexslider').flexslider({
		animation: "fade",              //String: Select your animation type, "fade" or "slide"
		slideshow: true,                //Boolean: Animate slider automatically
		slideshowSpeed: 3000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
		animationDuration: 600,         //Integer: Set the speed of animations, in milliseconds
		directionNav: false,             //Boolean: Create navigation for previous/next navigation? (true/false)
		controlNav: true,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
		keyboardNav: true,              //Boolean: Allow slider navigating via keyboard left/right keys
		mousewheel: false,              //Boolean: Allow slider navigating via mousewheel
		slideToStart: 0,                //Integer: The slide that the slider should start on. Array notation (0 = first slide)
		animationLoop: true,            //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
		pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
		pauseOnHover: false            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
    });
});



/* Functions */
function checkNavIntegrity(){
	// Debug function that checks that all navigation links have appropriate <article> with corresponding ID.
	// You can remove this once you finihed working on the site.
	navLinks.each(function(){
		var linkHref = $(this).attr('href'),
			correspondingArticle = $(linkHref);
			
			if(correspondingArticle.length == 0) {
				var linkValue = $(this).html(),
					targetId = linkHref.replace(/#/, '');
				alert('Navigation Broken: The menu link "'+linkValue+'" points to a nonexistent ID "'+linkHref+'". \n'
					 +'To solve this, add the ID "'+targetId+'" to a tag, for example: <article id="'+targetId+'">');
			}
	});
}

function hash_handler() { // Set menu link and page position according to #hash value in URL
	var hash = window.location.hash;
	
	if(hash) {
		$('a[href='+hash+']').trigger('mousedown');
	} else {
		$('nav a.active').removeClass('active');
		$('nav a:first').addClass('active');
		
		page.unbind('scroll', scroll_handler); // Turn off scroll_handler
		page.stop().animate({scrollTop: 0}, 500, function() {
			page.bind('scroll', scroll_handler); // Turn scroll_handler back on when animate complete
		});
	}
}

function scroll_handler() { // Set menu link according to scroll position
	navLinks.each(function(){
		var target = $(this).attr('href'),
			pagePosition = page.scrollTop() + $(target+'_modified').position().top;

			if(page.scrollTop() > pagePosition - 320) {
				$('nav a.active').removeClass('active');
				$(this).addClass('active');
			}
			if($(this).is(':last-child') // Fix for last page on large displays and/or last page's height too small
			   && page.scrollTop() + page.height() > page[0].scrollHeight - 50) {
				$('nav a.active').removeClass('active');
				$(this).addClass('active');
			}
	});
}

function isValidEmail(email) {
    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    return pattern.test(email);
};

