function showJob(str)
{
	var xmlhttp;
	var job = document.getElementById("job");
	console.debug(str);
	if (str == "NULL")
	{
		job.disabled = true;
		for(var i=job.length; i>0; i--)
				job.remove(i);
		return;
	}
	else
	{
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
				job.disabled = false;
				
				var opt = xmlhttp.responseText.split(",");
				console.debug(opt);
				for(var i=job.length; i>=0; i--)
					job.remove(i);
				
				for(var i=0; i<opt.length;)
				{
					var obj = document.createElement("OPTION");
					
					if(i == 0)
					{
						obj.value = "NULL";
						obj.selected = true;
					}
					obj.text = opt[i++];
					job.add(obj);
				}
			}
		}
		xmlhttp.open("GET","upload.php?dir="+str,true);
		xmlhttp.send();
	}
}

function changeDir(str)
{
	var xmlhttp;
	var dir = document.getElementById("direction");
	
	if (str == "NULL")
	{
		dir.disabled = true;
		for(var i=dir.length; i>0; i--)
				dir.remove(i);
		return;
	}
	else
	{
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
				dir.disabled = false;
				
				var opt = xmlhttp.responseText.split(",");
				for(var i=dir.length; i>=0; i--)
					dir.remove(i);
				
				for(var i=0; i<opt.length;)
				{
					var obj = document.createElement("OPTION");
					
					if(i == 0)
					{
						obj.value = "NULL";
						obj.selected = true;
					}
					else
						obj.value = opt[i++]
					obj.text = opt[i++];
					dir.add(obj);
				}
			}
		}
		xmlhttp.open("GET","upload.php?route="+str,true);
		xmlhttp.send();
	}
}