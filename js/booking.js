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
	
	$("#searchBtn").click(function(){
		var lineID = $("#selectLine").val();
		var dirID = $("#selectDirection").val();
		var optID = $("#selectStops").val();
		var date = $("#selectDate").val();
		var hour = $("#selectHour").val();
		var minute = $("#selectMinute").val();
		var bookingTime = date+"T"+hour+":"+minute+":00Z";
		console.log(lineID, dirID, optID, bookingTime);
		$.ajax({
		    url: "./Booking_Function.php",
		    type: "POST",
		    data: {"displayTimetable": [lineID, dirID, optID, bookingTime]},
		    dataType: "JSON",
		    async: false,
		    success: function(data) { 
			    $("#timetable").empty();
				$("#timetable").append(data);
			}
		});	
		console.log("END");
	})
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
})