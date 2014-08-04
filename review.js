$('#navLinks a, #left p a').hover(function() {
	$(this).css('color','#c92828');
}, function() {
	$(this).css('color','#f2f2f2');
});

$('#showReviewComments, .controls a').hover(function() {
	$(this).css('text-decoration', 'underline');
}, function() {
	$(this).css('text-decoration', 'none');
});

function positionAlertBox()
{
	var width, height, bWidth, bHeight; 
	
	width='300';
	
	height='185';
	
	bWidth=$(window).width();
	
	bHeight=$(window).height(); 
	
	var left=(bWidth/2)-(width/2)+($(window).scrollLeft())+"px";
	
	var top=(bHeight/2)-(height/2)+($(window).scrollTop())+"px";
	
	$('#alertBox').css('left',left).css('top',top);
}

function hideAlertBox()
{
	$("#dark").hide();

	$("#alertBox").hide();
}

function redirect()
{
	window.location="index.php";
}