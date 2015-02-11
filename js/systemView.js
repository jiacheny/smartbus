// wriiten by Jiachen Yan
$(document).ready(function(){
	
	$("#selectLine").change(function(){
		$("#selectDirection").empty();
		$("#selectRunDate").empty();
		document.getElementById("selectRunDate").disabled = true;
		$("#runs").empty();
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
		var lineID = $("#selectLine").val();
		var dirID = $("#selectDirection").val();
		$("#runs").empty();
		
		$.ajax({
		    url: "./systemView_Function.php",
		    type: "POST",
		    data: {"selectDate": [lineID, dirID]},
		    dataType: "JSON",
		    success: function(data) { 
				$("#selectRunDate").html(data);
				document.getElementById("selectRunDate").disabled = false;
			}
		});		
		
	})
	
	$("#getRunsBtn").click(function(){
		var lineID = $("#selectLine").val();
		var dirID = $("#selectDirection").val();
		var runDate = $("#selectRunDate").val();
		$.ajax({
		    url: "./systemView_Function.php",
		    type: "POST",
		    data: {"getRuns": [runDate, lineID, dirID]},
		    dataType: "JSON",
		    success: function(data) { 
				$("#runs").html(data);
			}
		});	
	})
	
	$("#runs").on("click", ".pure-button", function() {
		
		var runID = $(this).attr("name");
		console.log(runID);
		
	})
	
	
	
	
})