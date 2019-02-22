var Slate = function () {
	
	var chartColors, nav, navTop;
	
	chartColors = ["#263849", "#F90", "#666", "#BBB"];
	
	
	return { start: start, chartColors: chartColors };
	
	function start () {

		nav = $('#nav');
		navTop = nav.offset ().top;
	
		bindNavEvents ();
		
		bindWidgetEvents ();
		
		bindAccordionEvents ();
		
		enableAutoPlugins ();
	}
	
	function enableAutoPlugins () {
		if ($.fn.tooltip) { 
			$('.ui-tooltip').tooltip (); 			
		}	
		
		if ($.fn.popover) { 
			$('.ui-popover').popover (); 			
		}		
		
		if ($.fn.lightbox) { 
			$('.ui-lightbox').lightbox();			
		}
		
		if ($.fn.dataTable) {
			$('.data-table').dataTable( {
				sDom: "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
				sPaginationType: "bootstrap",
				oLanguage: {
					"sLengthMenu": "_MENU_ records per page"
				}
			});
		}
	}
	
	function bindNavEvents () {
		
		var msie8 = $.browser.version === '8.0' && $.browser.msie;
		
		if (!msie8) {
			$(window).bind ('scroll', navScroll);
		}
				
		$('#info-trigger').live ('click', function (e) {
			
			e.preventDefault ();
			
			$('#info-menu').toggleClass ('toggle-menu-show');
			
			$(document).bind ('click.info', function (e) {
				
				if ($(e.target).is ('#info-menu')) { return false; }
				
				if ($(e.target).parents ('#info-menu').length == 1) { return false; }
				
				$('#info-menu').removeClass ('toggle-menu-show');
				
				$(document).unbind ('click.info');
				
			});
			
		});
	}
	
	function navScroll () {
		var p = $(window).scrollTop ();
		
		((p)>navTop) ? $('body').addClass ('nav-fixed') : $('body').removeClass ('nav-fixed');
		
	}
	
	function bindWidgetEvents () {
		$('.widget-tabs .nav-tabs a').live ('click', widgetTabClickHandler);
	}
	
	function bindAccordionEvents () {
		$('.widget-accordion .accordion').on('show', function (e) {
	         $(e.target).prev('.accordion-heading').parent ().addClass('open');
	    });
	
	    $('.widget-accordion .accordion').on('hide', function (e) {
	        $(this).find('.accordion-toggle').not($(e.target)).parents ('.accordion-group').removeClass('open');
	    });
	    
	    $('.widget-accordion .accordion').each (function () {	    	
	    	$(this).find ('.accordion-body.in').parent ().addClass ('open');
	    });
	}
	
	function widgetTabClickHandler (e) {
		e.preventDefault();
		$(this).tab('show');
	}
	
}();




$(function () {

	Slate.start ();

});