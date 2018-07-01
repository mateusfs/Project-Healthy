$(function(){
	/*		
	$('ul.nav li:has(a)').click(function(e){
		$(this).siblings('.active').removeClass('active').end().addClass('active');

		if ($(this).parent('ul').hasClass('nav-pills')) {
			$('legend small').html($(this).children('a').text());
		}
		
	});
	 */
	$('.dropdown-toggle').dropdown();
});


function activeMenu(menu) {
	$('li[data-menu*="'+menu+'"]').addClass('active');
}

