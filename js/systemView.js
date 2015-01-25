$(document).ready(function(){
	$(".pure-button").click(function(){
		
		$("#directioninfo").empty();
		
		$.ajax({
		    url: "./systemView_Function.php",
		    type: "post",
		    data: { "getDirectionInfo": $(this).text()},
		    success: function(response) { 
				$("#directioninfo").empty();
			}
		});
		
		
		
	})
})