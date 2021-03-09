$(document).ready(function() {	

	//select all the a tag with name equal to modal	
	$('a[name=modal]').click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
		
		//Get the A tag
		var id = $(this).attr('href');
	alert(id);
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		//Set the popup window to center
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		//transition effect
		$(id).fadeIn(1000); 	
	});
//div click


	
	//if close button is clicked
	$('.window .link').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		$('#mask').hide();
		$('.window').hide();
	});		
//close button	
	//if close button is clicked
	$('.window #closediv').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		$('#mask').hide();
		$('#asd').hide();
		$('.window').hide();
	});	
	//if mask is clicked
	$('#mask').click(function () {
		//$(this).hide();
		//$('.window').hide();
		//$(div_id1).hide();
	});			
	
});
function hide_mask (div_id1) {
  	$('#mask').hide();
  	$('#asd').hide();
	$('.window').hide();
}
function show_mask(sid,name){
		//Cancel the link behavior
		//e.preventDefault();
		
		
		
		
		
		
		
		
		
		div_id1=div_id;
		//Get the A tag
		var id = $(div_id).attr('id');
	
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();

		//Set the popup window to center
		//$('#asd').css('top',  winH/2-$(div_id).height()/2);
		//$('#asd').css('left', winW/2-$(div_id).width()/2);
		
		$('#asd').css('top', 30);
		$('#asd').css('left', 75);
		
	//$('#asd').show(); 
		//transition effect
		$('#asd').fadeIn(2000); 	
	}