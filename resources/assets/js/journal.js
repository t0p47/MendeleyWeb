$(document).ready(function(){

	$(".showArticlesInJournalLink").click(function(){
		var id = $(this).attr('data-id');
		$('.showArticlesInJournalForm #id').val(id);
		$('.showArticlesInJournalForm').submit();
	});

	$('.selectYearLink').click(function(){
		alert("select year");
		var year = $(this).attr('data-year');
		var id = $(this).attr('data-id');
		$('.selectYearForm #year').val(year);
		$('.selectYearForm #id').val(id);
		$('.selectYearForm').submit();
	});
});