// JavaScript Document
	
	$('.menu ul li:last-child').addClass('last');
	// menu			
	$('#menu > li').wrapInner('<div class="inner" />');
	$("#menu li").find("ul").prev().addClass("hasSub");
	$("#menu li").hover(function(){ 
		$(this).find('ul:first').prev().addClass("expanded");
		$(this).find('ul:first').css({visibility: "visible",display: "none"}).slideDown(); 
	}, function(){
		$(this).find('ul:first').prev().removeClass('expanded');
		$(this).find('ul:first').slideUp();		
	}); 
		
