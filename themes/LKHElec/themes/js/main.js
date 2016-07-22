// menu
function tongw()
{
    var tt = 0;
    jQuery(".menu > li").each(function(index) {
        tt += jQuery(this).outerWidth();
    });
    return tt;
}

function resize_menu()
{
    var i = 0,
        tc = jQuery(".menu > li").length,
        ww = $(".menu").width()-tongw(),
        wp = parseInt(ww / tc);
    $(".menu > li").each(function(index) {
        $(this).width($(this).width() + wp);
    });
}

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
		
$(document).ready(function() {	

	// placeholder
	placeHolderFallBack();	

    //menu
    resize_menu();  
    var wl = $("#menu > li.last").width()+ $("#menu").width()-tongw();
    $("#menu > li.last").width(wl);
    $("#menu > li").find("ul").prev().addClass("hasSub");
    $("#menu > li").hover(function(){ 
        if ($(this).find('ul:first').prev().hasClass("expanded")) {
            return false;
        } else {
            $('#menu .expanded').removeClass('expanded');
            $("#menu li").find('ul:first').slideUp();
            $(this).find('ul:first').prev().addClass("expanded");
            $(this).find('ul:first').css({visibility: "visible",display: "none"}).slideToggle(); 
        }  
    }, function(){
        $('#menu .expanded').removeClass('expanded');
        $("#menu li").find('ul:first').slideUp();       
    }); 
	
    $('ul li:first-child').addClass('first');
    $('ul li:last-child').addClass('last');
   
 }); 