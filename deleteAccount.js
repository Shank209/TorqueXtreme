$('#navLinks a, #left p a').hover(function() {
	$(this).css('color','#c92828');
}, function() {
	$(this).css('color','#f2f2f2');
});

$("#right a").hover(function() {
	$(this).css('text-decoration','underline');
}, function() {
	$(this).css('text-decoration','none');
});