$(document).ready(function(){


	var currentTab = $(".search_bar .horizontal-list .active-tab");
	console.log("Active tab is: ",currentTab.text());

	$(".add_to_library").on('click',function(){

		ajaxSetup();

		var currentBtn = $(this);

		var url;
		if(currentTab.text()=="Статьи"){
			url = '/search/article';
		}else if(currentTab.text()=="Автор"){
			url = '/search/author';
		}else if(currentTab.text()=="Группа"){
			url = '/search/group';
		}else if(currentTab.text()=="Поддержка"){
			url = '/search/support';
		}
		
		var type = "POST";
		var formData = {
			'id':$(this).attr('data-id'),
		}

		$.ajax({
			url:url,
			type:type,
			data:formData,
			success:function(data){
				console.log("Success: ",data);
				if(data=="success"){
					currentBtn.find("span").text("Сохранено");
				}else{
					currentBtn.find("span").text("Уже сохранено");
				}
				
				
			},error: function(data){
				console.log("Error: ",data);
				$(this).html("01");
			}
		});
	});

});