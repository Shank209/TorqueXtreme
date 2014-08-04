$('#navLinks a, #left p a, #editPicture').hover(function() {
	$(this).css('color','#c92828');
}, function() {
	$(this).css('color','#f2f2f2');
});

$('#editPicture').click(function() {
	$('#uploadControls').slideDown();
});

$('#right a').hover(function(){
	$(this).css('color', 'black');
}, function(){
	$(this).css('color', '#c92828');
});