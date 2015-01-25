// wriiten by Jiachen Yan
$(document).ready(function(){
	
	//init the map on the page
	var map = new google.maps.Map(document.getElementById('map'), {
	    zoom: 13,
	    center: new google.maps.LatLng(-37.813611, 144.963056),
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	
	$(".pure-button").click(function(){
		
		$("#directioninfo").empty();
		
		var routeNumber = parseInt($(this).text());
		
		$.ajax({
		    url: "./systemView_Function.php",
		    type: "POST",
		    data: {"getDirectionInfo": routeNumber},
		    dataType: "JSON",
		    success: function(data) {  	
				$("#directioninfo").append(data);
			}
		});
	})
})