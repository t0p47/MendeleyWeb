$(document).ready(function(){

	function initialize(){
		//FileDrop
		var zone = new FileDrop('zone10');

		zone.event('send', function (files) {

		  files.each(function (file) {
		    // Reset the progress when a new upload starts:
		    file.event('sendXHR', function () {
		      fd.byID('bar_zone10').style.width = 0
		    })

		    // Update progress when browser reports it:
		    file.event('progress', function (current, total) {
		      var width = current / total * 100 + '%'
		      fd.byID('bar_zone10').style.width = width
		    })
		    //fd.byID('bar_zone10').style.width = 0
		    alert("Uploaded");
		    file.sendTo('upload.php')
		  })
		});
	}

	

	//Sliding tabs
	function makeTabsIntoSlidingTabs($tabs) {
		$tabs.find("div").wrapAll("<div style='display:none' />");
		$tabs.append("<div class='slidingTabs' />");
		$tabs.children("div").first().find("div").each(function(i) {
			$tabs.find(".slidingTabs").append($("<div />").addClass("tab").html($(this).html()));
		});

		$tabs.tabs({

			activate: function(event, ui) {
				var tab = $tabs.tabs("option", "active");
				console.log("Tabs: ",tab);
				$tabs.find(".slidingTabs div").first().animate({
					marginLeft: (tab * -100) + '%'
				}, 400, function() {});
				if(tab == 1){
					$tabs.find(".slidingTabs div").eq(1).animate({
						left: (0) + '%'
					},400, function(){});
				}else{
					$tabs.find(".slidingTabs div").eq(1).animate({
						left: (100) + '%'
					},400, function(){});
				}
				
			}
		});
	}

	makeTabsIntoSlidingTabs($("#related_tabs"));

	$('.collapse_handler a').click(function(){
		$('.right_related_sidebar').toggle('slide',{direction: 'right'},1000);
		$('.center_article_table').animate({
			'margin-right': $('.center_article_table').css('margin-right')=='0px'
			?'-250px':'0px'
		},1000);

		/*$('.my-menu').animate({
			'margin-left':
		});*/

		//$('.my-menu').hide("slide",{direction: "left"},1000);
		//$('.txt4').hide("slide", {direction: "right"}, 2000);


	});

	$('.abstract_more_toggle').click(function(){
		$('.article_abstract').addClass('article_abstract_expanded');
		$(this).hide();
		$('.abstract_less_toggle').show();
	});

	$('.abstract_less_toggle').click(function(){
		$('.article_abstract').removeClass('article_abstract_expanded');
		$(this).hide();
		$('.abstract_more_toggle').show();
	});

});

