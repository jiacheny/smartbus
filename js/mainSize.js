$(document).ready(function(){
	
	var winHeight = $(window).innerHeight();
	var footerHeight = $("#footer").height();
	var mainHeight = winHeight-footerHeight;
	$("main").css({ "height":mainHeight+"px"});
	
})