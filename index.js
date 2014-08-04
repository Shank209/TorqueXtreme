$('#signIn').click(function() {
	$('#dark').show();
	
	$('#signInBox').show();
	
	positionSignInBox();
});

$('.back').click(function() {
	$('#signInBox').hide();
	
	$('#signUpBox').hide();
	
	$('#dark').hide();
});

$('#signUp').click(function() {
	$('#dark').show();
	
	$('#signUpBox').show();
	
	positionSignUpBox();
});

function positionSignInBox()
{
	var width, height, bWidth, bHeight; 
	
	width='300';
	
	height='300';
	
	bWidth=$('body').width();
	
	bHeight=$('body').height();
	
	var left=(bWidth/2)-(width/2)+($(window).scrollLeft()/2)+"px";
	
	var top=(bHeight/2)-(height/2)+($(window).scrollTop()/2)+"px";
	
	$('#signInBox').css('left',left).css('top',top);
}

function positionSignUpBox()
{
	var width, height, bWidth, bHeight; 
	
	width='300';
	
	height='289';
	
	bWidth=$('body').width();
	
	bHeight=$('body').height();
	
	var left=(bWidth/2)-(width/2)+($(window).scrollLeft()/2)+"px";
	
	var top=(bHeight/2)-(height/2)+($(window).scrollTop()/2)+"px";
	
	$('#signUpBox').css('left',left).css('top',top);
}