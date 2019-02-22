$(function () {

	var data = [];
	var series = 3;
	for( var i = 0; i<series; i++)
	{
		data[i] = { label: "Series "+(i+1), data: Math.floor(Math.random()*100)+1 }
	}

	$.plot($("#donut-chart"), data,
	{
		colors: Slate.chartColors,
		//colors: ["#0A69C0", "#3C4049", "#777", "#AAA"],
	        series: {
	            pie: { 
	                innerRadius: 0.5,
	                show: true
	            }
	        }
	});
	
});