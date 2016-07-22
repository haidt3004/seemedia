
	$('ul li:first-child').addClass('first');
	$('ul li:last-child').addClass('last');
	//menu
	$('#menu > li').each(function() {
        $(this).wrapInner('<div class="inner" />');
    });
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
		$("#menu li").find('ul:first').hide();		
	});