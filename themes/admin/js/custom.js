jQuery(document).ready(function () {
	// audience.create();
	// audience.update();
	myFileStyle.run();
});

var audience = {
	create: function () {
		$(".add_audience_specialty").colorbox({iframe: true, innerHeight: '430', innerWidth: '600', close: "<span title='close'>close</span>", overlayClose: false, escKey: false});
	},
	update: function () {
		$(".update_audience_specialty").colorbox({iframe: true, innerHeight: '430', innerWidth: '600', close: "<span title='close'>close</span>", overlayClose: false, escKey: false});
	}
};

//apply style for button select file
var myFileStyle = {
	run: function () {
		$('input[type=file]').bootstrapFileInput();
	}
};


 $(document).on('click','.hidden-symbol', function(e){
    var menuid = $(this).parent('li').attr('id');
    $('#' + menuid + ' .data-' + menuid).show();
    $('#' + menuid + ' .close-' + menuid).html('-');
    $('#' + menuid + ' .close-' + menuid).removeClass('hidden-symbol');
    $('#' + menuid + ' .close-' + menuid).addClass('showing-symbol');
 });

 $(document).on('click','.showing-symbol', function(e){
    var menuid = $(this).parent('li').attr('id');
    $('#' + menuid + ' .data-' + menuid).hide();
    $('#' + menuid + ' .close-' + menuid).html('+');
    $('#' + menuid + ' .close-' + menuid).removeClass('showing-symbol');
    $('#' + menuid + ' .close-' + menuid).addClass('hidden-symbol');
 });


//haidt - moved from custom.js
$(document).ready(function(){
    $('.dd').nestable({ /* config options */ });
	$('.multiselect').multiselect();
});

