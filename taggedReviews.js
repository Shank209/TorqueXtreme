$('#navLinks a, #left p a:not(#'+$("#sort").val()+')').hover(function() {
	$(this).css('color','#c92828');
}, function() {
	$(this).css('color','#f2f2f2');
});

$('#goToPage').click(function() {
	window.location="taggedReviews.php?name="+$('#tagName').val()+"&pn="+$('#pageNumInput').val()+'&sort='+$('#sort').val();
});