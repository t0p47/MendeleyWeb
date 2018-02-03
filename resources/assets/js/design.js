$(document).ready(function(){	

	$(".top_menu_button").click(function(){
		$(".top_menu").slideToggle();
	});

	$(".search_panel_button").click(function(){
		$('.search_panel').toggle('slow');
	});

	$(".top-user-toggler a").click(function(){
		$(".top-user-menu").slideToggle();
	});

	liactive('.search_bar');

	liactive('.search_panel');

	function liactive(parenttag){
		$(parenttag+" ul li").click(function(){
			$(this).siblings().removeClass('active-tab')
			$(this).addClass('active-tab');
		});
	}

});