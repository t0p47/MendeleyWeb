$(document).ready(function(){
	
	initialise();

	//File upload section
	// Variable to store your files
	var files;

	// Add events
	$('#addjournalarticle form input[type=file]').on('change', prepareUpload);

	// Grab the files and set them to our variable
	function prepareUpload(event)
	{
	  files = event.target.files;
	}


	$('#addjournalarticle form').on('submit',function(e){
		e.preventDefault();

		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		});

		var title = $(this).find('#title').val();
		var authors = $(this).find('#authors').val();
		var abstract = $(this).find('#abstract').val();
		var journal = $(this).find('#journal').val();
		var year = $(this).find('#year').val();
		var volume = $(this).find('#volume').val();
		var issue = $(this).find('#issue').val();
		var pages = $(this).find('#pages').val();
		var ArXivID = $(this).find('#ArXivID').val();
		var DOI = $(this).find('#DOI').val();
		var PMID = $(this).find('#PMID').val();
		//TODO Как загружать файлы через AJAX
		var filepath = '';
		var uid = $(this).find('#uid').val();
		var folder = $(this).find('#folder').val();

		var formData = {
			title:title,
			authors:authors,
			abstract:abstract,
			journal:journal,
			year:year,
			volume:volume,
			issue:issue,
			pages:pages,
			ArXivID:ArXivID,
			DOI:DOI,
			PMID:PMID,
			filepath:filepath,
			uid:uid,
			folder:folder,
		}

		var type = "POST";
		var my_url = '/create_journal_article';

		$.ajax({
			type:type,
			url:my_url,
			data: formData,
			success: function(data){
				console.log('Success:',data);
				$('#addjournalarticle').modal('hide');
				$('#addjournalarticle .form-group').removeClass('has-error');
				$('#addjournalarticle .form-group .help-block').remove();
				$('#addjournalarticle').modal('hide');

				var newIndex = parseInt($('#article-list > tr').last().find('.checkbox-select').attr('checkbox-id'))+1;
				//alert(newIndex);

				if(data.journal == null){
					data.journal = "";
				}
				if(data.abstract == null){
					data.abstract = "";
				}
				if(data.volume == null){
					data.volume = "";
				}
				if(data.issue == null){
					data.issue = "";
				}
				if(data.year == null){
					data.year = "";
				}
				if(data.pages == null){
					data.pages = "";
				}
				if(data.ArXivID == null){
					data.ArXivID = "";
				}
				if(data.DOI == null){
					data.DOI = "";
				}
				if(data.PMID == null){
					data.PMID = "";
				}
				var article = "<tr id='article-preview-data'><td><input type='checkbox' class='checkbox-select' checkbox-id='"+newIndex+"' data-id='"+data.id+"'></td>";
				article += "<td><a class='user-edit curs-point' data-toggle='modal' data-target='#edituser' data-id='' data-name='' data-email='' data-ip=''>"+data.title+"</a></td>";
				article += "<td><a class='user-edit curs-point' data-toggle='modal' data-target='#edituser' data-id='' data-name='' data-email='' data-ip=''>"+data.authors+"</a></td>";
				article += "<td><a class='user-edit curs-point' data-toggle='modal' data-target='#edituser' data-id='' data-name='' data-email='' data-ip=''>"+data.journal+"</a></td>";
				article += "<td><a class='edit-article curs-point' data-toggle='modal' data-target='#editarticle'";					
				article += "data-id='"+data.id+"' data-title='"+data.title; 
				article += "data-authors='"+data.authors+"' data-abstract='"+data.abstract;
				article += "data-journal='"+data.journal+"' data-year='"+data.year;
				article += "data-volume='"+data.volume+"' data-issue='"+data.issue;
				article += "data-pages='"+data.pages+"' data-arxivid='"+data.ArXivID;
				article += "data-doi='"+data.DOI+"' data-pmid='"+data.PMID+"'>Редактировать</a><br>";
				article += "<a class='delete-article-class curs-point' data-id='"+data.id+"'>Удалить</a>";

				if(data.filepath){
					article += "<br><a class='read-pdf-class' data-filepath='"+data.filepath+"'>Читать PDF</a>";		
				}
				article += "</td></tr>";
				$('#article-list').append(article);
				initialise();
				
			},
			error: function(data){
				console.log('Error:',data);
				var errors = data.responseJSON;
				$.each(errors,function(index,value){
					var errorShow = "<span class='help-block'><strong>"+value+"</strong></span>";
					index = '#addjournalarticle form #'+index;
					$(index).after(errorShow);
					$(index).closest('.form-group').addClass('has-error');
				});


			}
		});
	});

	function initialise(){
		

	var maxArrLength = $('#article-list > tr').length;
	//alert(arrLength);
	var arr = [];

	$('.checkbox-select').change(function(){
		var isCheck = $(this).prop('checked');
		//Добавить в массив
		if(isCheck){
			console.log(arr);
			arr[$(this).attr('checkbox-id')] = $(this).attr('data-id');
			$('#delete-selected-articles').removeClass('disabled');

			if(arr.length == maxArrLength){
				var allChecked = true;
				$('.checkbox-select').each(function(){
					if(!$(this).prop('checked')){
						allChecked = false;
						return false;
					}
				});
				if(allChecked){
					$('#all-top-checkboxes').prop('checked',true);
					$('#all-bottom-checkboxes').prop('checked',true);	
				}
			}
			//alert(arr);
		//Удалить из массива
		}else{
			arr[$(this).attr('checkbox-id')] = '';
			$('#all-top-checkboxes').prop('checked',false);
			$('#all-bottom-checkboxes').prop('checked',false);

			var someChecked = false;
			$('.checkbox-select').each(function(){
				if($(this).prop('checked')){
					someChecked = true;
					return false;
				}
			});
			if(!someChecked){
				$('#delete-selected-articles').addClass('disabled');
			}
			//alert(arr);
			//alert(arr.length);
		}
	});

	$('#all-top-checkboxes').change(function(){
		var isCheck = $(this).prop('checked');
		$('.checkbox-select').prop('checked',isCheck);
		$('#all-bottom-checkboxes').prop('checked',isCheck);
		if(isCheck){
			arr = [];
			$('.checkbox-select').each(function(){
				arr[$(this).attr('checkbox-id')] = $(this).attr('data-id');
			});
			$('#delete-selected-articles').removeClass('disabled');
			//alert(arr);
		}else{
			arr = [];
			$('#delete-selected-articles').addClass('disabled');
			//alert(arr);
		}
	});

	$('#all-bottom-checkboxes').change(function(){
		var isCheck = $(this).prop('checked');
		$('.checkbox-select').prop('checked',isCheck);
		$('#all-top-checkboxes').prop('checked',isCheck);
		
		if(isCheck){
			arr = [];
			$('.checkbox-select').each(function(){
				arr[$(this).attr('checkbox-id')] = $(this).attr('data-id');
			});
			$('#delete-selected-articles').removeClass('disabled');
			//alert(arr);
		}else{
			arr = [];
			$('#delete-selected-articles').addClass('disabled');
			//alert(arr);
		}
		
	});

	$('#delete-selected-articles').click(function(){
		$("#delete-selected-articles-form input[name='articles']").val(arr);
		$('#delete-selected-articles-form').submit();
		alert(arr);
	});
	

	//Edit-Delete article
	var id;
	var title;
	var authors;
	var abstract;
	var journal;
	var year;
	var volume;
	var issue;
	var pages;
	var arxivid;
	var doi;
	var pmid;

	$('.delete-article-class').click(function(){
		id = $(this).attr('data-id');
		var act = "/journalarticle/delete/"+id;
		$('#delete-article').attr('action',act);
		$('#delete-article').submit();
	});

	var path;
	$('.read-pdf-class').click(function(){
		path = $(this).attr('data-filepath');

		$('#read-pdf #read-pdf-input').val(path);

		//$('#read-pdf').attr('action',path);
		$('#read-pdf').submit();
	});

	$('.edit-article').click(function(){
		id = $(this).attr('data-id');
		title = $(this).attr('data-title');
		authors = $(this).attr('data-authors');
		abstract = $(this).attr('data-abstract');
		journal = $(this).attr('data-journal');
		year = $(this).attr('data-year');
		volume = $(this).attr('data-volume');
		issue = $(this).attr('data-issue');
		pages = $(this).attr('data-pages');
		arxivid = $(this).attr('data-arxivid');
		doi = $(this).attr('data-doi');
		pmid = $(this).attr('data-pmid');

		$('#editarticle #id').val(id);
		$('#editarticle #title').val(title);
		$('#editarticle #authors').val(authors);
		$('#editarticle #abstract').val(abstract);
		$('#editarticle #journal').val(journal);
		$('#editarticle #year').val(year);
		$('#editarticle #volume').val(volume);
		$('#editarticle #issue').val(issue);
		$('#editarticle #pages').val(pages);
		$('#editarticle #ArXivID').val(arxivid);
		$('#editarticle #DOI').val(doi);
		$('#editarticle #PMID').val(pmid);

		var act = "/journalarticle/delete/"+id;
		$('#delete-article').attr('action',act);
	});
	}

});