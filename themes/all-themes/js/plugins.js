
// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

// place folder
function placeHolderFallBack() {
    if("placeholder" in   document.createElement("input")) {
        return;
    } else {
        $('[placeholder]').focus(function () {
            var input = $(this);
            if (input.val() == input.attr('placeholder')) {
                input.val('');
                input.removeClass('placeholder');
            }
        }).blur(function () {
            var input = $(this);

            if (input.val() == '' || input.val() == input.attr('placeholder')) {
                input.addClass('placeholder');
                input.val(input.attr('placeholder'));
            }
        }).blur();
        $('[placeholder]').parents('form').submit(function() {
            $(this).find('[placeholder]').each(function() {
                var input = $(this);
                if(input.val() == input.attr('placeholder')) {
                    input.val('');
                }
            })
        });
    }
}



$(document).ready(function() {

    // placeholder
    placeHolderFallBack();
    $('.content-list').hide();
    $('.content-list-default').show();

    //$('.content-list:first').show();
    $('.list-news-item a.title').hover(function(){
        var id = $(this).attr('rel');
        $('.content-list').hide();
        $('.content-list-default').hide();
        $('.content-list#list-'+id).show();
    });
    $('.list-news-item a.title').mouseout(function(){
        $('.content-list').hide();
        $('.content-list-default').show();
        // var id = $(this).attr('rel');
        //$('.content-list').hide();
        //$('.content-list#list-'+id).show();
    });

});
equalheight = function(container){

    var currentTallest = 0,
        currentRowStart = 0,
        rowDivs = new Array(),
        $el,
        topPosition = 0;
    $(container).each(function() {

        $el = $(this);
        $($el).height('auto')
        topPostion = $el.position().top;

        if (currentRowStart != topPostion) {
            for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
                rowDivs[currentDiv].height(currentTallest);
            }
            rowDivs.length = 0; // empty the array
            currentRowStart = topPostion;
            currentTallest = $el.height();
            rowDivs.push($el);
        } else {
            rowDivs.push($el);
            currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
        }
        for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
            rowDivs[currentDiv].height(currentTallest);
        }
    });
}

function responheight() {
    var hfoot = $('footer').outerHeight();
    var hfoot2 = $('footer').outerHeight()+50;
    $('.bigmain').css({marginBottom:-hfoot});
    $('.mainchild').css({paddingBottom:hfoot2});
    $('.main').css({paddingBottom:hfoot2});
}



$(window).load(function() {
    equalheight('.box-item-news');
    responheight();
});
    

$(window).resize(function(){
    equalheight('.box-item-news');
    responheight();
});

// hiep remove ul empty
$(document).ready(function () {
    $('#main-menu ul').each(function( index ) {
        if (isEmpty($(this))) {
            $(this).remove();
        }
    });
});
function isEmpty( el ){
    return !$.trim(el.html())
}

