// wriiten by Jiachen Yan
$(document).ready(function(){
	
	$("#selectLine").change(function(){
		
		$("#selectDirection").empty();
		
		$("#selectStops").empty();
		$("#selectStops").append("<option> Select An Optional Stop </option>");
		
		var lineID = $("#selectLine").val();
		$.ajax({
		    url: "./Booking_Function.php",
		    type: "POST",
		    data: {"selectDirection": lineID},
		    dataType: "JSON",
		    success: function(data) {  	
				$("#selectDirection").html(data);
			}
		});	
	})
	
	$("#selectDirection").change(function(){
		
		$("#selectStops").empty();

		var lineID = $("#selectLine").val();
		var dirID = $("#selectDirection").val();
		
		$.ajax({
		    url: "./Booking_Function.php",
		    type: "POST",
		    data: {"selectStops": [lineID, dirID]},
		    dataType: "JSON",
		    success: function(data) {  	
				$("#selectStops").html(data);
			}
		});	
		
		
	})
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
})