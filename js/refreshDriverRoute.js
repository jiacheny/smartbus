function clearNode(str)
{
	var obj = document.getElementById(str);
	var childs = obj.childNodes;
	for (var i = childs.length-1; i >= 0; i--) {
		obj.removeChild(childs[i]);
	}
}

function focusJob()
{
	var obj = document.getElementById("JobList");
	var time = new Date();

}

function timeDiff(start,end)
{
	var mmSec = end.getTime() - start.getTime();
	return mmSec/1000/60;
}

function toDate(str)
{
	var obj = new Date();
	var hrs = str.replace(/[:]\d\d/,"");
	var min = str.replace(/\d\d[:]/,"");
	obj.setHours(hrs,min);
	return obj;
}

function changeBack()
{
	var obj=$("td").siblings();
	var time = new Date();
	for (var i = 0; i < obj.length; i++) {
		var str = obj[i].innerHTML;
		if (str.match(":") != null) {

			str = toDate(str);

			var diff = timeDiff(time,str);
			if (diff < 5 && diff > 0) {
				obj[i].style.background="#FF0000";
				obj[i-1].style.background="#FF0000";
			}
		}
	}
}

function loadJob(str)
{
	var xmlhttp;
	var obj = document.getElementById("JobList");

	if (str == "false") {
		obj.innerHTML = "No job avaliable today!";
	} 
	else{

		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				clearNode("JobList");

				var result = xmlhttp.responseText.split(",");
				if(result == "No job avaliable today!")
					document.getElementById("JobList").innerHTML = result;
				else {				

					var tb = document.createElement("TABLE");
					tb.setAttribute("border","1");

					document.getElementById("JobList").appendChild(tb);


					for (var j = 0; j < result.length;) {
						if (j == 0) {
							var cap = tb.createCaption();
							cap.innerHTML = result[j++];
						}
						else
						{
							var row = document.createElement("tr");
							tb.appendChild(row);
							var cell1 = document.createElement("td");
							row.appendChild(cell1);
							var cell2 = document.createElement("td");
							row.appendChild(cell2);
							cell1.innerHTML = result[j++];
							cell2.innerHTML = result[j++];
						}
					}
					changeBack();
				}
			}
		}
		xmlhttp.open("GET","Driver_Function.php?refresh="+str,true);
		xmlhttp.send();
	}
}

function refreshJob(str)
{
	setInterval(function(){loadJob(str)},4*1000);
}