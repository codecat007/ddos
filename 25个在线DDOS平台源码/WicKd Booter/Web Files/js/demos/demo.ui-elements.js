$(function () {
	
	/*--------------------------------------------------
	Plugin: Type Ahead
	--------------------------------------------------*/	
	$('#typeahead').typeahead ();
	
	
	/*--------------------------------------------------
	Plugin: Color Picker
	--------------------------------------------------*/	
	$('#colorpicker-component').colorpicker({ format: 'hex' });
	
	
	/*--------------------------------------------------
	Plugin: Time Picker
	--------------------------------------------------*/	
	$('#timepicker-basic').timepicker ({});
	
	
	/*--------------------------------------------------
	Plugin: Date Picker
	--------------------------------------------------*/	
	$("#datepicker-basic").datepicker();
	
	$("#datepicker-multi").datepicker({
		numberOfMonths: 3,
		showButtonPanel: true
	});
	
	
	/*--------------------------------------------------
	Plugin: Msg Growl
	--------------------------------------------------*/	
	$('.growl_type').live ('click', function (e) {
		$.msgGrowl ({
			type: $(this).attr ('data-type')
			, title: 'Header'
			, text: 'Lorem ipsum dolor sit amet, consectetur ipsum dolor sit amet, consectetur.'
		});
	});
	
	
	/*--------------------------------------------------
	Plugin: Msg Alert
	--------------------------------------------------*/	
	$('.alert_type').live ('click', function (e) {
		$.msgAlert ({
			type: $(this).attr ('data-type')
			, title: 'Title'
			, text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.'
		});
	});
	
	
	/*--------------------------------------------------
	Plugin: Slider
	--------------------------------------------------*/
		
	/* Increment Slider */
	$( "#incrementSlider" ).slider({
		range: "min",
		value:50,
		min: 0,
		max: 500,
		step: 50,
		slide: function( event, ui ) {
			$( "#incrementAmount" ).text ( "$" + ui.value );
		}
	});
		
	$( "#incrementAmount" ).text ( "$" + $( "#incrementSlider" ).slider( "value" ) );
		
		
	
	/* Min Value Slider */
	$( "#rangeMinSlider" ).slider({
		range: "min",
		value: 100,
		min: 50,
		max: 700,
		slide: function( event, ui ) {
			$( "#rangeMinAmount" ).text ( "$" + ui.value );
		}
	});
	
	$( "#rangeMinAmount" ).text ( "$" + $( "#rangeMinSlider" ).slider( "value" ) );
		
		
	/* Default Slider */
	$( "#defaultSlider" ).slider({ range: 'min' });
	
	
	
	/* Vertical Slider */	
	$("#eq > span").each(function() {
		var value = parseInt($(this).text());
		$(this).empty().slider({
			value: value,
			range: "min",
			animate: true,
			orientation: "vertical"
		});
	});
    

	/* Horizontal Slider */
	$( "#rangeSlider" ).slider({
		range: true,
		min: 0,
		max: 500,
		values: [ 75, 250 ],
		slide: function( event, ui ) {
			$( "#amount" ).text ( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
		}
	});
				
	$( "#amount" ).text( "$" + $( "#rangeSlider" ).slider( "values", 0 ) +
		" - $" + $( "#rangeSlider" ).slider( "values", 1 ) );
	
});