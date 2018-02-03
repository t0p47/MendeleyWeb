$(document).ready(function(){

	var currFolderRMB='0';
	var url = '/library';

	//Turned arrow's in folders
	//alert($('.sidebar-menu ul li a +ul.treeview-menu').length);
	$('.sidebar-menu ul li a + ul.treeview-menu').each(function(index){
		$(this).siblings().append("<span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>");
	});
	var aLinks = $('.sidebar-menu ul li a');

	var $contextMenu = $('#contextMenu');


	//FancyBox Add folder click
	$('.fancybox').fancybox();

	//Add folder click
	$('#contextMenu a[TabIndex*="1"]').on('click',function(e){
		$('#addfolder #isrename').val(0);
	});

	//Rename folder click
	$('#contextMenu a[TabIndex*="2"]').on('click',function(e){
		$('#addfolder #isrename').val(1);
	});

	//Delete folder click
	$('#contextMenu a[TabIndex*="3"]').on('click',function(e){

		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		});

		var my_url = url+'/deleteFolder';
		var type="POST";
		var formData = {
			"folder_id":currFolderRMB.attr('id'),
		}

		$.ajax({
			type:type,
			url: my_url,
			data: formData,
			success: function(data){
				console.log(data);
			},error: function(data){
				console.log("Error",data);
			}
		});

		currFolder = "0";
		$('h1').text("Library");
		document.title = "Library";

		getAllArticles();

		currFolderRMB.next().remove();

		var ulparent = currFolderRMB.parent().parent();
		if(ulparent.children().length==1){
			ulparent.prev().find('span.pull-right-container').remove();
		}

		currFolderRMB.remove();
		
	});

	function addOrRename($formid){
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		});

		var name = $($formid).find('#name').val();
		var isrename = $($formid).find('#isrename').val();
		var my_url = url+'/addSubfolder';
		var type = "POST";
		var formData = {
			"isrename": isrename,
			"parent_id": currFolderRMB.attr('id'),
			"name": name,
		}

		$.ajax({
			type:type,
			url: my_url,
			data: formData,
			success: function(data){
				console.log(data);
				console.log('Success:',data);
				console.log('Siblings:',currFolderRMB.siblings().length);
				$.fancybox.close();
				jQuery($formid).each(function(){
					this.reset();
				});
				if(data=="true"){
					currFolderRMB.find('span.text').text(name);
				}else{
					var folder = '';
					if(currFolderRMB.siblings().length == 0){
						new_folder = " <ul class='treeview-menu' style='display: none;'>";
						new_folder += '<li><a id="folder'+data['id']+'" class="curs-point"><i class="fa fa-circle-o"></i><span class="text">'+data['name']+'</span></a>';
						new_folder += " </li></ul>";
						//var new_folder_selector = $('a#folder'+data['id']);
						currFolderRMB.append("<span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>");
						currFolderRMB.parent().append(new_folder);
						aLinks = $('.sidebar-menu ul li a');
					}else{
						new_folder = '<li><a id="folder'+data['id']+'" class="curs-point"><i class="fa fa-circle-o"></i><span class="text">'+data['name']+'</span></a></li>';
						currFolderRMB.siblings().append(new_folder);
						aLinks = $('.sidebar-menu ul li a');
					}
				}
				
				
				
			},error: function(data){
				console.log('Error 128ln',data);
			}
		});
	}

	//Add subfolder click
	$('#addfolder').on('submit',function(e){

		e.preventDefault();

		addOrRename('#addfolder');
	});

	//SetCurrentFolder name to field
	$('a[tabindex=2]').click(function(){
		console.log('CurrFolder: ',currFolderRMB.text());
		$('#renamefolder #name').val(currFolderRMB.text());
	});

	//Rename subfolder click
	$('#renamefolder').on('submit',function(e){

		e.preventDefault();

		addOrRename('#renamefolder');
	});


	$(document).click(function(e){
		if(e.button==0){
			$contextMenu.hide();
		}
	});

	$contextMenu.on('click','a',function(){
		$contextMenu.hide();
	});

	$('.btn-folder-control').click(function(){
		alert('folder-control');
	});


	//Show context menu on RMB click
	$('.sidebar-menu .treeview-exp').on('contextmenu','ul li a',function(e){
		currFolderRMB = $(this);
		$contextMenu.css({
			display: "block",
			left: e.pageX,
			top: e.pageY
		});

		return false;
	});

	//Открыть папку и показать подпапки
	$('.sidebar-menu .treeview-exp').on('click','ul li a', function(e){
		if(currFolder != '0'){
			currFolder.removeClass('active_folder');
			currFolder.find('i.fa.fa-bars').addClass('hide');
		}
		$(this).addClass('active_folder');

		$(this).find('i.fa.fa-bars').removeClass('hide');

		currFolder = $(this);
		$('h1').text(currFolder.text());
		document.title = currFolder.text();

		//Перерисовываем данные для этой папки
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		});

		getArticlesInFolder($(this).attr('id'));
	});	

	function createArticlesList(index,value){
		if(value.journal == null){
			value.journal = "";
		}
		if(value.abstract == null){
			value.abstract = "";
		}
		if(value.volume == null){
			value.volume = "";
		}
		if(value.issue == null){
			value.issue = "";
		}
		if(value.year == null){
			value.year = "";
		}
		if(value.pages == null){
			value.pages = "";
		}
		if(value.ArXivID == null){
			value.ArXivID = "";
		}
		if(value.DOI == null){
			value.DOI = "";
		}
		if(value.PMID == null){
			value.PMID = "";
		}
		if(value.filepath == null){
			value.filepath = "";
		}

		var article = "<li data-id="+value.id+"><span class='check_indicator'><input id='testarticles' class='checkbox-styled' type='checkbox' /><label for='testarticles'></label></span>";
		
		//Check is article is favorite
		if(value.favorite==1){
			article+= "<span class='favorite_indicator favorite_indicator_active'>";
		}else{
			article+= "<span class='favorite_indicator'>";
		}

		//<i class='fa fa-file-pdf-o' aria-hidden='true'></i>
		article+= "<i class='fa fa-star' aria-hidden='true'></i></span><span class='read_indicator'></span><span class='file_indicator' data-filepath="+value.filepath+">";
		if(value.filepath!=''){
			article+= "<i class='fa fa-file-pdf-o' aria-hidden='true'></i>";
		}

		var date = new Date(value.created_at);

		var months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
		var endDate = date.getDate()+" "+months[date.getMonth()];

		article+= "</span><h2 class='article_title'>"+value.title+"</h2><p class='authorAndArticle'>"+value.authors+" В "+value.journal_id+"</p><span class='date_added'>"+endDate+"</span></li>";

		$('#articles_list ul').append(article);
	}

	function getAllArticles(){
		var my_url = url+"/all";
		getArticlesList(my_url);
	}

	function getFavoriteArticles(){
		var my_url = url+"/favorite";
		getArticlesList(my_url);
	}

	function getMyArticles(){
		var my_url = url+"/my";
		getArticlesList(my_url);
	}

	function getArticlesInFolder(folderId){
		var my_url= url+"/folder";
		var formData = {
			"folderId":folderId,
		}
		getArticlesList(my_url,formData);
	}

	function getArticlesList(my_url,formData=0){
		var type = "POST";

		ajaxSetup();

		console.log("FormData: ",formData);

		$.ajax({
			type: type,
			url: my_url,
			data: formData,
			success: function(data){
				console.log("Success: ",data);
				$('#articles_list ul').html('');
				disableRightSidebar();
				$.each(data, function(index, value){
					//console.log("NewFolder open index: ",index,", value: ",value);
					createArticlesList(index,value);
				});


			},
			error: function(data){
				console.log('Error: ',data);
			}
		});
	}


	//WORK WITH LEFTBAR Buttons

	//AllArticles
	$('.sidebar-menu .allarticles-btn').click(function(e){
		e.preventDefault();
		getAllArticles();
	});

	$('.sidebar-menu .favorite-articles-btn').click(function(e){
		e.preventDefault();
		alert("Show favorite");
		getFavoriteArticles();
	});

	$('.sidebar-menu .my-articles-btn').click(function(e){
		e.preventDefault();
		alert("Shom my articles");
		getMyArticles();
	});


});

var currFolder='0';