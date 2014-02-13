$(document).ready(function() {
	var anim, link;

	$('.run-anim').click(function() {
		anim = $(this).attr('data-anim');
		link = $(this).attr('data-link');
		$('.' + anim).addClass('la-animate');
		$('.run-anim').delay(5000).queue(function(nxt) {
			$('.' + anim).removeClass('la-animate');
			
			nxt();
		});
		
		window.location.href=link;
	});
	$('.la-anim-1-mini').addClass('la-animate');
	

});