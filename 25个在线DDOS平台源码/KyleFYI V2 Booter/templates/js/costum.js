$(document).ready(function(){ 
	
	$(function() {
		if (window.innerWidth < 850 && window.innerHeight < 850) {} else {
			$("#menu ul").supersubs({
				minWidth: 15,
				maxWidth: 100
			}).superfish({
				autoArrows: false,
				dropShadows: false
			});
		}
	});
	
	// HIDE LEFT PANEL
	$(".hide-btn").click(function(){
		if($("#left").css("width") == "0px"){
			$("#left").animate({width:"230px"}, 500);
			$("#right").animate({marginLeft:"250px"}, 500);
			$("#wrapper, #container").animate({backgroundPosition:"0 0"}, 500);
			$(".hide-btn.top, .hide-btn.center, .hide-btn.bottom").animate({left: "223px"}, 500, function() { $(window).trigger("resize");});
			$(this).attr("original-title", "Close sidebar");
		}
		else{
			$("#left").animate({width:"0px"}, 500);
			$("#right").animate({marginLeft:"20px"}, 500);
			$("#wrapper, #container").animate({backgroundPosition:"-230px 0px"}, 500);
			$(".hide-btn.top, .hide-btn.center, .hide-btn.bottom").animate({left: "-7px"}, 500, function() { $(window).trigger("resize");});
			$(this).attr("original-title", "Open sidebar");
		}
	});
	
	// HIDE BOXES	
		$(function() {
		$('.title .hide').showContent();
	});
	
	$.fn.showContent = function() {
		return this.each(function() {
			var box = $(this);
			var content = $(this).parent().next('.content');
	
			box.toggle(function() {
				content.slideUp(500);
				$(this).css('background-position', 'right bottom');
			}, function() {
				content.slideDown(500);
				$(this).css('background-position', 'right top');
			});
	
		});
	};
	
	$(function() {
		$('.title .show').hideContent();
	});
	
	$.fn.hideContent = function() {
		return this.each(function() {
			var box = $(this);
			var content = $(this).parent().next('.content');
			
			box.toggle(function() {
				content.slideDown(500);
				$(this).css('background-position', 'right top');
			}, function() {
				content.slideUp(500);
				$(this).css('background-position', 'right bottom');
			});
	
		});
	};
	
	// MESSAGE BOX
	$('#wrapper #container #top #labels ul li.subnav').click(function() {
		$('#wrapper #container #top #labels ul ul').slideToggle(400);
		return false
	});
	
	$(document).bind('click', function(e) {
		var $clicked = $(e.target);
		if (! $clicked.parents().hasClass("#wrapper #container #top #labels ul li.subnav"))
			$("#wrapper #container #top #labels ul ul").slideUp(200);
	});
	
	// SIDE PANEL TOGGLE MENU
	$(".togglemenu ul").accordion({ 
		header: 'li.title',
		autoHeight: false
	});
	
	// TABS
	$(".tabs").tabs();
	
	// WIZARD    
    $('.wizard').smartWizard({
        transitionEffect:'fade'
    });
	
	// TOOLTIPS
	$(".tip-n").tipsy({gravity: 'n'});
	$(".tip-w").tipsy({gravity: 'w'});
	$(".tip-e").tipsy({gravity: 'e'});
	$(".tip-s").tipsy({gravity: 's'});
	
	// MODAL WINDOW
	$('.modalopen').each(function() {  
		$.data(this, 'dialog', 
		  $(this).next('.modal').dialog({
            autoOpen: false,
            closeText: '',
            resizable: false,
			modal: true,
			show: "fade",
			hide: "fade",
            width: 700,
			height: 392
		  })
		);  
	}).click(function() {  
		$.data(this, 'dialog').dialog('open');  
		return false;  
	});  
	
	$(window).resize(function() {
		$(".modal").dialog("option", "position", "center");
	});
	
	// BREADCRUMBS
	jQuery("#breadcrumbs").jBreadCrumb({easing:'swing'});
	
	// SYSTEM MESSAGES
	$(".message").click(function () {
      $(this).fadeOut();
    });
	
	// PROGRESSBAR
	$(".progressbar-normal").each(function() {
		$(this).progressbar({
			value: parseInt($(this).attr("value"))
		});
	});
	
	jQuery.ease = function(start, end, duration, easing, callback) {
		var easer = $("<div>");
		var stepIndex = 0;
		var estimatedSteps = Math.ceil(duration / 13);

		easer.css("easingIndex", start);
		easer.animate({
			easingIndex: end
		}, {
			easing: easing,
			duration: duration,
			step: function(index) {
				callback(
				index, stepIndex++, estimatedSteps, start, end);
			}
		});
	};
	
	$(".progressbar-count").each(function() {
		var $self = $(this),targetVal = parseInt($self.attr("value"));
		$self.progressbar({
			value: 0
		});
		$self.prev(".percent").text("0%");
		$.ease(0,targetVal,3500,"swing",function(i){
			$self.progressbar("option","value",parseInt(i));
			$self.prev(".percent").text(parseInt(i) + "%");
		});
	});
	
	// CALENDAR
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	
	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next',
			center: 'title',
			right: 'month,basicWeek,basicDay'
		},
		editable: true,
		height: 550,
		events: [
			{
				title: 'All Day Event',
				start: new Date(y, m, 1)
			},
			{
				title: 'Long Event',
				start: new Date(y, m, d-5),
				end: new Date(y, m, d-2)
			},
			{
				id: 999,
				title: 'Repeating',
				start: new Date(y, m, 7, 16, 0),
				allDay: false
			},
			{
				id: 999,
				title: 'Repeating',
				start: new Date(y, m, d+4, 16, 0),
				allDay: false
			},
			{
				title: 'Meeting',
				start: new Date(y, m, d, 10, 30),
				allDay: false
			},
			{
				title: 'Lunch',
				start: new Date(y, m, d, 12, 0),
				end: new Date(y, m, d, 14, 0),
				allDay: false
			},
			{
				title: 'Birthday Party',
				start: new Date(y, m, d+1, 19, 0),
				end: new Date(y, m, d+1, 22, 30),
				allDay: false
			},
			{
				title: 'Click for ThemeForest',
				start: new Date(y, m, 28),
				end: new Date(y, m, 29),
				url: 'http://www.themeforest.net'
			}
		]
	});
	
	// SLIDERS
	$(".single-slide div.slide").each(function() {
        value = $(this).attr('value').split(',');
        firstVal = value;

        rangeSpan = $(this).siblings('input.amount');

        $(this).slider({
            value: [firstVal],
            min: parseInt($(this).attr('min'), 0),
            max: parseInt($(this).attr('max'), 0),
            slide: function(event, ui) {
                $(this).siblings('input.amount').val("" + ui.value);
            }
        });
        rangeSpan.val("" + $(this).slider("value"));
    });
	
    $(".range-slide div.slide").each(function() {
        values = $(this).attr('value').split(',');
        firstVal = values[0];
        secondVal = values[1];

        rangeInputfirst = $(this).siblings('input.amount-first');
        rangeInputsecond = $(this).siblings('input.amount-second');

        $(this).slider({
            values: [firstVal, secondVal],
            min: parseInt($(this).attr('min'), 0),
            max: parseInt($(this).attr('max'), 0),
            range: true,
            slide: function(event, ui) {
                $(this).siblings('input.amount-first').val("" + ui.values[0]);
                $(this).siblings('input.amount-second').val("" + ui.values[1]);
            }
        });
        rangeInputfirst.val("" + $(this).slider("values", 0));
        rangeInputsecond.val("" + $(this).slider("values", 1));
    });
	
    $(".snap-slide div.slide").each(function() {
        value = $(this).attr('value').split(',');
        firstVal = value;

        rangeSpan = $(this).siblings('input.amount');

        $(this).slider({
            value: [firstVal],
            min: parseInt($(this).attr('min'), 0),
            max: parseInt($(this).attr('max'), 0),
			step: parseInt($(this).attr('step'), 0),
            slide: function(event, ui) {
                $(this).siblings('input.amount').val("" + ui.value);
            }
        });
        rangeSpan.val("" + $(this).slider("value"));
    });
	
	$(".single-vert-slide div.slide").each(function() {
        value = $(this).attr('value').split(',');
        firstVal = value;

        rangeSpan = $(this).siblings('input.amount');

        $(this).slider({
			orientation: "vertical",
            value: [firstVal],
            min: parseInt($(this).attr('min'), 0),
            max: parseInt($(this).attr('max'), 0),
            slide: function(event, ui) {
                $(this).siblings('input.amount').val("" + ui.value);
            }
        });
        rangeSpan.val("" + $(this).slider("value"));
    });
	
	// SPINNERS
	$(".spin").spinner({ 
		places: 2
	});
	
	$(".spin-dec").spinner({ 
		places: 2,
		step: 0.25
	});
	
	$(".spin-cur").spinner({ 
		places: 2,
		step: 0.01,
		prefix: '$ '
	});
	
	// PIROBOX
	$(".gallery .pirobox").piroBox_ext({
        piro_speed : 700,
        bg_alpha : 0.5,
        piro_scroll : true
    });
	
	// FORM VALIDATION
	$.validator.addMethod('require-one', function(value) {
		return $('.require-one:checked').size() > 0;
	}, 'Please, check at least one box.');

	var checkboxes = $('.right .require-one');
	var checkbox_names = $.map(checkboxes, function(e, i) {
		return $(e).attr("name")
	}).join(" ");

	$('.valid').each( function(){
		$(this).validate({
			meta: "validate",
			ignore: [],
			groups: {
				checks: checkbox_names
			},
			errorPlacement: function(error, element) {
				if (element.attr("type") == "checkbox") error.insertAfter(element.parent().siblings().last());
				else if (element.is("select")) {
					error.insertAfter(element.next("a.ui-selectmenu"))
				}
				else error.insertAfter(element);
			}
		});
	});
	
	// INPUT PLACEHOLDER
	$('input[placeholder], textarea[placeholder]').placeholder();
	
	// SELECTBOXES
	$(function() {
		$('.dataTables_length input, select').not("select.multiple").selectmenu({
			style: 'dropdown',
			transferClasses: true,
			width: null,
			change: function() {
				$(".valid").validate().element(this);
			}
		});
	});
	
	// RADIOBUTTONS & CHECKBOXES
	$("input[type=radio], input[type=checkbox]").each(function() {
        if ($(this).parents("table").length === 0) {
            $(this).customInput();
        }
    });
	
	// FILE INPUT STYLE
    $("input[type=file]").filestyle({
        imageheight: 28,
        imagewidth: 85,
        width: 150
    });
	
	// DATEPICKER
	$(".datepicker").datepicker({
		dateFormat: 'mm.dd.yy'
	});
	
	// WYSIWYG EDITOR
	$('.wysiwyg').wysiwyg({
        css: "css/wysiwyg-editor.css",
        plugins: {
            rmFormat: {
                rmMsWordMarkup: true
            }
        }
    });
	
	// AUTOGROW TEXTAREA
	jQuery('.grow').elastic();
	
	// INPUT FILTER
	$('.onlytext').filter_input({regex:'[a-zA-Z]'}); 
	$('.onlylow').filter_input({regex:'[a-z]'}); 
	$('.onlyup').filter_input({regex:'[A-Z]'}); 
	$('.onlynum').filter_input({regex:'[0-9]'}); 
	$('.onlyurl').filter_input({regex:'[a-zA-Z0-9_]'}); 
	
	// DATATABLE
    $('table.all').dataTable({
        "bInfo": false,
        "iDisplayLength": 10,
        "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
        "sPaginationType": "full_numbers",
        "bPaginate": true,
        "sDom": '<f>t<pl>'
    });
	
	$('table.pagesort').dataTable({
        "bInfo": false,
        "iDisplayLength": 10,
        "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
        "sPaginationType": "full_numbers",
        "bPaginate": true,
		"bFilter": false,
        "sDom": 't<pl>'
    });

    $('table.sortsearch').dataTable({
        "bInfo": false,
        "bPaginate": false,
        "sDom": 't<plf>'
    });

    $('table.sorting').dataTable({
        "bInfo": false,
        "bPaginate": false,
        "bFilter": false,
        "sDom": 't<plf>'
    });

    $(".dataTables_wrapper .dataTables_length select").addClass("entries");
	
	// CHARTS        
    $("table.chart").each(function() {
        var colors = [];
        $("table.chart thead th:not(:first)").each(function() {
            colors.push($(this).css("color"));
        });
        $(this).graphTable({
            series: 'columns',
            position: 'replace',
			width: '100%',
            height: '200px',
            colors: colors
        }, {
            xaxis: {
                tickSize: 1
            },
			yaxis: {
				max: null,
				autoscaleMargin: 0.02
            }
        });
    });

    $("table.chart-date").each(function() {
        var colors = [];
        var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        $("table.chart-date thead th:not(:first)").each(function() {
            colors.push($(this).css("color"));
        });
        $(this).graphTable({
            series: 'columns',
            position: 'replace',
            width: '100%',
            height: '250px',
            colors: colors,
            xaxisTransform: function(month) {
                var i = 0;
                while ((i < 12) && (month != months[i])) {
                    i++;
                }
                return i;
            }
        }, {
            xaxis: {
                tickSize: 1,
                tickFormatter: function(v, a) {
                    return months[v];
                }
            },
			yaxis: {
				max: null,
				autoscaleMargin: 0.02
            }
        });
    });
	
	$("table.chart-pie").each(function() {
        var colors = [];
        $("table.chart-pie thead th:not(:first)").each(function() {
            colors.push($(this).css("color"));
        });
        $(this).graphTable({
            series: 'columns',
            position: 'replace',
			width : '100%',
            height: '250px',
            colors: colors
        }, {
			series: {
				pie: {
					show: true,
					pieStrokeLineWidth: 0, 
					pieStrokeColor: '#FFF',
					radius: 100,
					label: {
						show: true,
						radius: 3/4,
						formatter: function(label, series){
							return '<div style="font-size:11px; padding:2px; color: #FFFFFF;"><b>'+label+'</b>: '+Math.round(series.percent)+'%</div>';
						},
						background: {
							opacity: 0.5,
							color: '#000'
						}
					}
				}
			},
			legend: {
				show: false
			},
			grid: {
				hoverable: false,
				autoHighlight: false
			}
        });
    });
	
	$("table.chart-square").each(function() {
        var colors = [];
        $("table.chart-square thead th:not(:first)").each(function() {
            colors.push($(this).css("color"));
        });
        $(this).graphTable({
            series: 'columns',
            position: 'replace',
			width : '100%',
            height: '250px',
            colors: colors
        }, {
			series: {
				pie: {
					show: true,
					pieStrokeLineWidth: 0, 
					pieStrokeColor: '#FFF',
					radius: 800,
					label: {
						show: true,
						radius: 3/4,
						formatter: function(label, series){
							return '<div style="font-size:11px; padding:2px; color: #FFFFFF;"><b>'+label+'</b>: '+Math.round(series.percent)+'%</div>';
						},
						background: {
							opacity: 0.5,
							color: '#000'
						}
					}
				}
			},
			legend: {
				show: false
			},
			grid: {
				hoverable: false,
				autoHighlight: false
			}
        });
    });
	
	$("table.chart-bars").each(function() {
        var colors = [];
        $("table.chart-bars thead th:not(:first)").each(function() {
            colors.push($(this).css("color"));
        });
        $(this).graphTable({
            series: 'columns',
            position: 'replace',
			width : '100%',
            height: '250px',
            colors: colors
        }, {
			xaxis: {
                tickSize: 1
            },
			series: {
				bars: {
					show: true,
					lineWidth: 1,
					barWidth: 0.7,
					fill: true,
					fillColor: null,
					align: "center",
					horizontal: false
				},
				lines: {
					show: false
				},
				points: {
					show: false
				}
			},
			yaxis: {
				max: null,
				autoscaleMargin: 0.02
            }
        });
    });
	
	$("table.chart-barsmulti").each(function() {
        var colors = [];
        $("table.chart-barsmulti thead th:not(:first)").each(function() {
            colors.push($(this).css("color"));
        });
        $(this).graphTable({
            series: 'columns',
            position: 'replace',
			width : '100%',
            height: '250px',
            colors: colors
        }, {
			xaxis: {
                tickSize: 1
            },
			series: {
				bars: {
					show: true,
					lineWidth: 1,
					barWidth: 0.4,
					fill: true,
					fillColor: null,
					align: "center",
					horizontal: false,
					multiplebars:true
				},
				lines: {
					show: false
				},
				points: {
					show: false
				}
			},
			yaxis: {
				max: null,
				autoscaleMargin: 0.02
            }
        });
    });

    $('.flot-graph').before('<div class="space"></div>');

    function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css({
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5
        }).appendTo("body").fadeIn("fast");
    }

    var previousPoint = null;
    $(".flot-graph").bind("plothover", function(event, pos, item) {
        $("#x").text(pos.x);
        $("#y").text(pos.y);

        if (item) {
            if (previousPoint != item.dataIndex) {
                previousPoint = item.dataIndex;

                $("#tooltip").remove();
                var x = item.datapoint[0],
                    y = item.datapoint[1];

                showTooltip(item.pageX, item.pageY, "<b>" + item.series.label + "</b>: " + y);
            }
        }
        else {
            $("#tooltip").remove();
            previousPoint = null;
        }
    });
	
});