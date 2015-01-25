$(document).ready(function(){
	
	$(".pure-button").click(function(){
		
		$("#directioninfo").empty();
		
		var routeNumber = $(this).text();
		
		$.ajax({
		    url: "./systemView_Function.php",
		    type: "post",
		    data: {"getDirectionInfo": routeNumber},
		    dataType: "text",
		    success: function(data) {  
				console.log(data);
			}
		});
		
		
		
	})
})