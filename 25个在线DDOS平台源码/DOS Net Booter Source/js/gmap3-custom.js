	 $(document).ready(function(){
		 
		/* Demo 1 */ 
		$("#gmap-1").gmap3({ 
		    action:'init',
			options:{
				center:[40.711614, -73.995323],
				zoom: 15
				}
			}
		);
		
		/* Demo 2 */
		$("#gmap-2").gmap3({ 
		    action:'init',
			options:{
				center:[40.724755, -74.002705],
				zoom: 13
				}
			},
			{ 
				action: 'addMarker',
				latLng:[40.7255,-74.006739]
			},
			{ 
				action: 'addMarker',
				latLng:[40.721988,-74.007425]
			},
			{ 
				action: 'addMarker',
				latLng:[40.724069,-73.997812]
			}
		);

        /* Demo 3 */
		$('#gmap-3').gmap3(
			{ 
			action : 'geoLatLng',
			callback : function(latLng){
				if (latLng){
					//$(this).parent().html('localised !');
					$(this).gmap3({
						action: 'addMarker', 
						latLng:latLng,
						map:{
							center: true,
							zoom: 10
            			}
					});
				} else {
					$(this).html('not localised !');
				}
			}
		});

		/* Demo 4 */
		$("#gmap-4").gmap3({ 
            action: 'addInfoWindow',
            address: "2 Elizabeth St, Melbourne",
            map:{
              center: true,
            },
            infowindow:{
              options:{
                size: new google.maps.Size(50,50),
                content: '<h3>Envato</h3>Level 13, 2 Elizabeth St, Melbourne <br/> Victoria 3000 Australia'
              },
              events:{
                closeclick: function(infowindow){
                  alert('closing : ' + $(this).attr('id') + ' : ' + infowindow.getContent());
                }
              }
            }
            },
		    { 
				action: 'addMarker',
				latLng:[-37.817917,144.965065]
			},		  
            { 
		    	action: 'setOptions', args:[{scrollwheel:true}]
			}
		);	
		
		/* Demo 5 */
		$("#gmap-5").gmap3();
  
        $('#gmap-search-1-submit').click(function(){
			var addr = $('#gmap-search-1').val();
			if ( !addr || !addr.length ) return;
				$("#gmap-5").gmap3({
					action:'getlatlng',
					address:  addr,
					callback: function(results){
					if ( !results ) return;
						$(this).gmap3({
							action:'addMarker',
							latLng:results[0].geometry.location,
							map:{
								center: true,
								zoom: 10
							}
						});
					}
				});
		});
        $('#gmap-search-1').keypress(function(e){
          if (e.keyCode == 13){
            $('#gmap-search-1-submit').click();
          }
        });
		
		/* Demo 6 */
		$("#gmap-6").gmap3({ 
		    action:'init',
			options:{
				center:[40.724755, -74.002705],
				zoom: 13
				}
			},
			{ 
				action: 'addMarker',
				latLng:[40.7255,-74.006739]
			},
			{ 
				action: 'addMarker',
				latLng:[40.721988,-74.007425]
			},
			{ 
				action: 'addMarker',
				latLng:[40.724069,-73.997812]
			},
			{ action: 'addTrafficLayer' }
		);			
	 });
