$(document).ready(function(){

	//$('#contextMenu a[TabIndex*="1"]').on('click',function(e){

	$(document).on('click','.delete-article-class',function(){
		var id = $(this).attr('data-id');

		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		});

		var formData = {
			'articles': id,
		}
		var url = '/delete_articles';
		var type= "POST";

		$.ajax({
			type:type,
			url:url,
			data:formData,
			success: function(data){
				console.log("Success: ",data);
			},
			error: function(data){
				console.log("Error: ",data);
			}
		});

		$(this).parent().parent().remove();
	});

	//var arr = [];
	var arr = {};
	var checkUncheckCounter = 0;
	$(':checkbox:checked').prop('checked',false);


	//$(document).on('click','.delete-article-class',function(){
	$(document).on('change','.checkbox-select',function(){
		if(this.checked){
			if(checkUncheckCounter==0){
				$('#delete-selected-articles').removeClass('disabled');
			}
			//alert('checked: '+$(this).attr('data-id').toString());
			arr[$(this).attr('data-id')] = $(this).attr('data-id');
			console.log("Checked one ",$(this).attr('data-id'));
			checkUncheckCounter++;
		}else{
			checkUncheckCounter--;
			//alert('unchecked: '+$(this).attr('data-id').toString());
			delete arr[$(this).attr('data-id')];
			if(checkUncheckCounter == 0){
				$('#delete-selected-articles').addClass('disabled');
			}
			console.log("Unchecked",arr);
		}
	});

	$('#all-top-checkboxes').change(function(){
		arr = {};
		$('.checkbox-select').prop('checked',$(this).prop('checked'));
		if(this.checked){
			if(checkUncheckCounter == 0){
				$('#delete-selected-articles').removeClass('disabled');
			}
			$('.checkbox-select').each(function(index){
				console.log("Each ",$(this).attr('data-id'));
				arr[$(this).attr('data-id')] = $(this).attr('data-id');
				//console.log("Checked",arr);
			});

		}else{
			$('#delete-selected-articles').addClass('disabled');

		}
	});

	/*
		var arr = ["jQuery","JavaScript","HTML","Ajax","Css"];
	    var itemtoRemove = "HTML";
	    $('span').html('Array Items before removal:<b> ' + arr + '</b>'); 
	    arr.splice($.inArray(itemtoRemove ,arr),1);
	    $('p').html('Array Items after removal:<b> ' + arr + '</b>'); 
	*/

	$('#delete-selected-articles').click(function(){
		console.log('Array of articles for delete: ',arr);
		var tmpCounter = 0;
		var tmpArr = [];
		for(var p in arr){
			tmpArr[tmpCounter] = p;
			tmpCounter++;
		}

		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		});

		var formData = {
			'articles':tmpArr.toString()
		}
		var url = "/delete_articles";
		var type= "POST";

		$.ajax({
			type:type,
			url:url,
			data:formData,
			success: function(data){
				console.log("Success: ",data);
				$('.checkbox-select:checked').parent().parent().remove();
			},
			error: function(data){
				console.log("Error: ",data);
			}
		});
		$(this).addClass('disabled');
		$('.all-top-checkboxes').prop('checked',false);
	});
});