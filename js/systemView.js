// wriiten by Jiachen Yan
$(document).ready(function(){
	
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