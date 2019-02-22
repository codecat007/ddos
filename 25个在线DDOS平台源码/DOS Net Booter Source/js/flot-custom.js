$(document).ready(function ($) { 

    /**
	* Add the id of the chart that you 
	* want ot use with the tooltips.
	*/
	var tooltipto = "#chart_1"

    /* Tooltip part */
	function showTooltip(x, y, title, content) {
        $('<div id="flot-tooltip"><h3>'+ title+'</h3><p>' + content + '</p><span><span></span></span></div>').css({
            top: y  -70,
            left: x -66
        }).appendTo("body").fadeIn(200);
    }

    var previousPoint = null;
	
    $(tooltipto).bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));

		if (item) {
			if (previousPoint != item.dataIndex) {
				previousPoint = item.dataIndex;
				
				$("#tooltip").remove();
				var y = item.datapoint[1].toFixed(2);
				
				showTooltip(item.pageX, item.pageY, item.series.label, parseInt(y)+" Visitors");
			}
		}
		else {
			$("#flot-tooltip").remove();
			previousPoint = null;            
		}
    });
	
	/* Chart 1 */
	
    var d1 = [];
    for (var i = 1; i <= 14; i += 1)
    d1.push([i, parseInt(Math.random() * 18000)]);
	
    var d2 = [];
    for (var i = 1; i <= 14; i += 1)
    d2.push([i, parseInt(Math.random() * 22800)]);
	
    var d3 = [];
    for (var i = 1; i <= 14; i += 1)
    d3.push([i, parseInt(Math.random() * 14600)]);
	
    var d4 = [];
    for (var i = 1; i <= 14; i += 1)
    d4.push([i, parseInt(Math.random() * 20900)]);

	$.plot($("#chart_1"), 
		[
			{
				label: "ThemeForest",
				data: d1,
				lines: { show: true, fill: 0.4 },
				color: "#F22E55",
				hoverable: true
			},
			{
				label: "CodeCanyon",
				data: d2,
				lines: { show: true, lineWidth: 4 },
				color: "#17AACF"
			},
			{
				label: "GaphicRiver",
				data: d3,
				lines: { show: true, lineWidth: 2 },
				color: "#f85617"
			},
			{
				label: "PhotoDune",
				data: d4,
				lines: { show: true, lineWidth: 2 },
				color: "#42B61C"
			}
		], 
			
			{
				series	:	{ lines: { show: true }, points: { show: true }, curvedLines: { active: true } },
				grid	:	{ hoverable: true, clickable: false},
				legend	:	{ show: true },
				yaxis	:	{ position: "right"}
			}
	);

	/* Chart 2 */
	
    var d11 = [];
    for (var i = 1; i <= 31; i += 1)
    d11.push([i, parseInt(Math.random() * 45290)]);
	
    var d12 = [];
    for (var i = 1; i <= 31; i += 1)
    d12.push([i, parseInt(Math.random() * 6900)]);
	
	$.plot($("#chart_2"), 
		[
			{
				label: "Flash",
				data: d12,
				color: "#17AACF"
			},
			{
				label: "HTML5",
				data: d11,
				color: "#F22E55"
			}			
		], 
			
			{
				series	:	{ stack: false, bars: { show: true, barWidth: 0.5 }},
				legend	:	{ show: true },
				yaxis	:	{ position: "right"}
			}
	);

	/* Chart 3 */
	
    var d31 = [];
    for (var i = 1; i <= 7; i += 1)
    d31.push([i, parseInt(Math.random() * 139290)]);
	
    var d32 = [];
    for (var i = 1; i <= 7; i += 1)
    d32.push([i, parseInt(Math.random() * 45290)]);

    var d33 = [];
    for (var i = 1; i <= 7; i += 1)
    d33.push([i, parseInt(Math.random() * 49990)]);
	
    var d34 = [];
    for (var i = 1; i <= 7; i += 1)
    d34.push([i, parseInt(Math.random() * 12990)]);

    var d35 = [];
    for (var i = 1; i <= 7; i += 1)
    d35.push([i, parseInt(Math.random() * 14990)]);

    var d36 = [];
    for (var i = 1; i <= 7; i += 1)
    d36.push([i, parseInt(Math.random() * 72990)]);

    var d37 = [];
    for (var i = 1; i <= 7; i += 1)
    d37.push([i, parseInt(Math.random() * 98990)]);
					
    var datasets = {
        "www.google.com": {
            label: "www.google.com",
            data: d31,
			lines: { show: true},
			color: "#ea1a77"
        },        
        "www.microsoft.com": {
            label: "www.microsoft.com",
            data: d32,
			lines: { show: true},
			color: "#f85617"
        },
        "www.ebay.com": {
            label: "www.ebay.com",
            data: d33,
			lines: { show: true},
			color: "#17AACF"
        },
        "www.amazon.com": {
            label: "www.amazon.com",
            data: d34,
			lines: { show: true},
			color: "#F22E55",
        },
        "www.flickr.com": {
            label: "www.flickr.com",
            data: d35,
			lines: { show: true},
			color: "#8eb419",
        },
        "www.twitter.com": {
            label: "www.twitter.com",
            data: d36,
			lines: { show: true},
			color: "#192fb4",
        },
        "www.facebook.com": {
            label: "www.facebook.com",
            data: d37,
			lines: { show: true, lineWidth: 2 },
			color: "#dd2121",
        }						
    };

    // hard-code color indices to prevent them from shifting as
    // countries are turned on/off
	/*
    var i = 0;
    $.each(datasets, function(key, val) {
        val.color = i;
        ++i;
    });
	*/
	
    // insert checkboxes 
    var choiceContainer = $("#chart-checkbox");
	/* replace the class for an input element if you are not using the checkbox plugin */
    choiceContainer.find(".e-checkbox").click(plotAccordingToChoices);
    
    function plotAccordingToChoices() {
        var data = [];

        choiceContainer.find("input:checked").each(function () {
            var key = $(this).attr("name");
            if (key && datasets[key])
                data.push(datasets[key]);
        });

        if (data.length > 0)
            $.plot($("#chart_3"), data, {
				series	:	{ lines: { show: true }, points: { show: true }, curvedLines: { active: true } },
				grid	:	{ hoverable: true, clickable: false},
				legend	:	{ show: true },
                xaxis: { tickDecimals: 0 }
            });
    }

    plotAccordingToChoices();
});
