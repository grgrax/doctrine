$(function(){
	$('ul.pagination a').hover(function(e){
		e.preventDefault();				
		console.log("hover");
	});
});