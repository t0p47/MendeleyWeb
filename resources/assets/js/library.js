$(document).ready(function(){

	$('#articles_list').on('click','li .file_indicator',function(e){
		e.stopPropagation();
		alert("ShowPDF");
		var filepath = $(this).attr('data-filepath');

		$("#pdf-form input[name='filepath']").val(filepath);
		$('#pdf-form').submit();

		/*var newTab = window.open(filepath,'_blank');
		if(newTab){
			newTab.focus();
		}else{
			alert("Запрещено открытие всплывающих окон для этого сайта");
		}*/
	});

	$('#articles_list').on('click','li .favorite_indicator',function(e){

		e.stopPropagation();
		ajaxSetup();
		var favorite;

		if($(this).hasClass('favorite_indicator_active')){
			$(this).removeClass('favorite_indicator_active');
			favorite=0;
		}else{
			$(this).addClass('favorite_indicator_active');
			favorite=1
		}		

		var url = '/library/make-favorite';
		var type = "POST";
		var formData = {
			'id':$(this).parent().attr('data-id'),
			'favorite':favorite,
		}

		$.ajax({
			url:url,
			type:type,
			data:formData,
			success: function(data){
				console.log("Success: ",data);
			},
			error: function(data){
				console.log("Error: ",data);
			}
		});
	});

	$('#articles_list').on('click','li .check_indicator',function(e){

		e.stopPropagation();
		var $checkbox = $(this).children('input');
		var $item = $(this).parent();

			//Уже нажато, отключить
			if($checkbox.prop('checked')==true){
				
				$checkbox.prop('checked',false);
				$item.removeClass('article_selected');
				if($selected_articles.length==1){
					$selected_articles = [];
					toggleRightSidebar(false);
				}else{
					$selected_articles = jQuery.grep($selected_articles,function(a){
						return a !== $item.attr('data-id');
					});
					toggleRightSidebar(true);
				}

			//Если не выбрано
		}else{
			$selected_articles.push($item.attr('data-id'));
			$item.addClass('article_selected');
			$checkbox.prop('checked',true);
			toggleRightSidebar(true);
		}

	});

	$('#articles_list').on('click','li',function(e){

		//Если статья уже выбрана(Отключить остальные, оставить только эту)
		if($(this).hasClass('article_selected')){
			if($selected_articles.length>1){

				isCheckAllArticles(false);
				$(this).find('#testarticles').prop('checked',true);

				$('#articles_list li').removeClass('article_selected');
				$selected_articles = [];

				$selected_articles.push($(this).attr('data-id'));
				
				$(this).addClass('article_selected');

				toggleRightSidebar(true);
			//Отключить единственныю выбранную(не одна не выбрана)
		}else{
			$(this).find('#testarticles').prop('checked',false);

			$selected_articles = jQuery.grep($selected_articles,function(a){
				return a !== $(this).attr('data-id');
			});

			$(this).removeClass('article_selected');

			toggleRightSidebar(false);
		}


		//Если статья еще не выбрана(Отключить остальные, оставить только эту)
	}else{
		isCheckAllArticles(false);
		$(this).find('#testarticles').prop('checked',true);

		$('#articles_list li').removeClass('article_selected');
		$selected_articles = [];

		$selected_articles.push($(this).attr('data-id'));
		$(this).addClass('article_selected');

		toggleRightSidebar(true);

		fillArticleRightSidebar($(this).attr('data-id'));
	}

	console.log("Array: ",$selected_articles);

});

//All checkboxes
$('.controller_toolbar label').click(function(){
	var $checkbox = $('#'+$(this).attr('for'));

	//Отключить
	if($checkbox.prop('checked')==true){
		alert("Already checked. Uncheck.");
		isCheckAllArticles(false);
		$('#articles_list li').removeClass('article_selected');
		disableRightSidebar();

		console.log("Uncheck: ",$selected_articles);
	//Включить
	}else{
		alert("Check");
		isCheckAllArticles(true);
		$('#articles_list li').addClass('article_selected');
		$selected_articles = [];

		$('#articles_list li').each(function(index){
			$selected_articles.push($(this).attr('data-id'));
		});
		toggleRightSidebar(true);

		console.log("Check: ",$selected_articles);
	}
});


$selected_articles = [];

function resetCheckboxOnRefresh(){
	$('.checkbox-styled:checked').prop('checked',false);
}

resetCheckboxOnRefresh();

	function isCheckAllArticles(checked){

	//$(document).on('click','#testarticles',function(){
		$('#articles_list li #testarticles').prop('checked',checked);

	}

	toggleFolderButtons($(".controller_toolbar button"), true);

	function toggleRightSidebar(isArticleSelected){
		if(isArticleSelected){
			if($selected_articles.length>1){
				$('.no_article_selected p').html($selected_articles.length+' статей выбрано');

				$('.no_article_selected').show();

				$('#related_tabs').hide();

			}else{
				$('.no_article_selected').hide();

				$('#related_tabs').show();
			}

			toggleFolderButtons($(".controller_toolbar button"), false);

		}else{

			$('.no_article_selected p').html('Статья не выбрана');


			$('.no_article_selected').show();

			$('#related_tabs').hide();
			toggleFolderButtons($(".controller_toolbar button"), true);
		}
	}

	//TODO Заменить все селекторы на переменные
	var $editForm = $(document).find('.edit_article_form form');
	var originalForm = '';

	function fillArticleRightSidebar(id){
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
			}
		});

		var formData={
			'id':id
		}
		var url = '/journal-article/'+id;
		var type = 'GET';

		$.ajax({
			type:type,
			url:url,
			success:function(data){
				//console.log("Success: ",data);


				$('.article_info .article_title').html(data["title"]);
				//TODO: Если авторов несколько
				$('.article_info .article_authors li').html(data["authors"]);
				$('.article_details .article_journal').html(data["journal_id"]);
				$('.article_details .article_year').html(data['year']);
				if(data['abstract']!=null){
					$('.article_abstract').html(data['abstract']);
				}

				$('.edit_article_form #id').val(data['id']);
				$('.edit_article_form #title').val(data['title']);
				$('.edit_article_form #authors').val(data['authors']);
				$('.edit_article_form #abstract').val(data['abstract']);
				$('.edit_article_form #journal_id').val(data['journal_id']);
				$('.edit_article_form #year').val(data['year']);
				$('.edit_article_form #volume').val(data['volume']);
				$('.edit_article_form #issue').val(data['issue']);
				$('.edit_article_form #pages').val(data['pages']);
				$('.edit_article_form #ArXivID').val(data['arxivid']);
				$('.edit_article_form #DOI').val(data['doi']);
				$('.edit_article_form #PMID').val(data['pmid']);
				
				originalForm = $editForm.serialize();

			},
			error: function(data){
				console.log("Error: ",data);
			}
		});
	}

	$(document).on('click','.edit_article_button',function(){
		$(".show_article_info").hide("slow");

		$(".edit_article_info").show("slow");
	});

	$(document).on('click','.close_article_edit_button',function(){

		$editForm = $(document).find('.edit_article_form form');

		if(originalForm !== $editForm.serialize()){
			alert("Есть несохраненные изменения");
		}else{
			$(".show_article_info").show("slow");

			$(".edit_article_info").hide("slow");
		}

		
	});

	//$(document).on('click','#testarticles',function(){



	//EditArticle
	$(document).on('click','.save_article_edit_button',function(){

		$editForm = $(document).find('.edit_article_form form');

		//Если в форме были изменения
		if(originalForm !== $editForm.serialize()){
			ajaxSetup();

			var url = '/edit_journal_article';
			var type = "POST";

			$.ajax({
				url:url,
				type:type,
				data: $editForm.serialize(),
				success: function(data){
					console.log("Success: ",data);
					originalForm = $editForm.serialize();

					SetEditArticle(data);

					$(".show_article_info").show("slow");

					$(".edit_article_info").hide("slow");
				},
				error: function(data){
					console.log("Error: ",data);
					Alert("Ошибка при обновлении статьи");
				}
			});
		}else{
			alert("Не было никаких изменений");
		}
	});

	function SetEditArticle(data){

		//Изменения в правой части(сайдбаре)
		$('.article_info .article_title').html(data["title"]);
		//TODO: Если авторов несколько
		$('.article_info .article_authors li').html(data["authors"]);
		$('.article_details .article_journal').html(data["journal_id"]);
		$('.article_details .article_year').html(data['year']);
		if(data['abstract']!=null){
			$('.article_abstract').html(data['abstract']);
		}

		//console.log("Journal id edit field: ",$('.edit_article_form #journal_id').html());

		//Изменения центрального списка
		//console.log("Selected article: ",$selected_articles);
		$(".article_selected .article_title").html(data["title"]);
		$(".article_selected .authorAndArticle").html(data["authors"]+" в "+data["journal_id"]);
	}

	$('.add-article-btn').click(function(){
		if(currFolder != '0'){
			$('#addJournalArticleID #folder').val(currFolder.attr('id').substring(6));
		}
	});

	//CreateArticle
	$("#addJournalArticleID").on('submit',function(e){
		e.preventDefault();

		ajaxSetup();

		var url = "/create_journal_article"
		var type ="POST";
		var data = new FormData($(this)[0]);

		console.log("Data: ",data);

		$.ajax({
			url: url,
			type:type,
			processData: false,
			contentType: false,
			data: data,
			success: function(data){
				console.log("Success: ",data);
				$.fancybox.close();
				jQuery('#addJournalArticleID').each(function(){
					this.reset();
				});
				console.log("Filepath: ".data);
				AddNewArticleToList(data);
			},
			error: function(data){
				console.log("Error: ",data);
			}
		});

	});

	function AddNewArticleToList(data){
		var article = "<li data-id="+data['id']+"><span class='check_indicator'><input id='testarticles' class='checkbox-styled' type='checkbox' /><label for='testarticles'></label></span>";

		article+= "<span class='favorite_indicator'><i class='fa fa-star' aria-hidden='true'></i></span><span class='read_indicator'></span><span class='file_indicator' data-filepath="+data['filepath']+">";

		if(data['filepath']){
			article+= "<i class='fa fa-file-pdf-o' aria-hidden='true'></i>";
		}

		var date = new Date(data['created_at']);

		var months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
		var endDate = date.getDate()+" "+months[date.getMonth()];

		article+= "</span><h2 class='article_title'>"+data['title']+"</h2><p class='authorAndArticle'>"+data['authors']+" В "+data['journal_id']+"</p><span class='date_added'>"+endDate+"</span></li>";

		$('#articles_list ul').append(article);
	}

	//Delete article(s)
	$('#delete-article-btn').click(function(){
		$('.controller_toolbar input').prop('checked',false);
		if($selected_articles.length < 1){
			return;
		}
		console.log("Delete selected: ",$selected_articles);
		ajaxSetup();

		var requestData = JSON.stringify($selected_articles)

		console.log("Data: ",requestData);

		var url = "/journalarticle/delete";
		var type = "POST";

		$.ajax({
			url:url,
			type:type,
			data:{data : requestData},
			success: function(data){
				console.log("Success: ",data);
				$('.article_selected').remove();
				disableRightSidebar();

			},error: function(data){
				console.log("Error: ",data);
			}
		});

	});


});

//END OF FILE

var $selected_articles;

var disableRightSidebar = function(){
	$('.no_article_selected p').html('Статья не выбрана');
	$('.no_article_selected').show();
	$('#related_tabs').hide();
	$selected_articles = [];
	toggleFolderButtons($(".controller_toolbar button"),true)
}

var toggleFolderButtons = function($btnSelector,disable){
	$btnSelector.prop("disabled",disable);
}