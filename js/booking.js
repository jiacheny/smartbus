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
		$.ajax({
		    url: "./Booking_Function.php",
		    type: "POST",
		    data: {"timetableWorkflow": [lineID, dirID, optID, bookingTime]},
		    dataType: "JSON",
		    async: false,
		    success: function(data) { 
			    $("#timetable").empty();
				$("#timetable").append(data);
			}
		});	
	})
	
	$("#timetable").on("click", "#bookChecked", function(){
		var lineID = $("#selectLine").val();
		var dirID = $("#selectDirection").val();
		var optID = $("#selectStops").val();
		console.log(lineID, dirID, optID);
		$(".optCheckbox:checked").each(function(){
			var runID = $(this).attr('name');
			var arrivaltime = $(this).val();
			console.log(runID, arrivaltime);
			$.ajax({
			    url: "./Booking_Function.php",
			    type: "POST",
			    data: {"createBooking": [lineID, dirID, optID, runID, arrivaltime]},
			    dataType: "JSON",
			    async: false,
			    success: function(data) { 
				    console.log("hellosdasdasds");
				    console.log(data);
					$("#timetable").append(data);
				}
			});	
			
		})		
	})
		
		
		
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
})