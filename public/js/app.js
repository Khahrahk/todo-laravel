$(window).keyup(function(e){
    var target = $('.checkbox-btn input:focus');
    if (e.keyCode === 9 && $(target).length){
        $(target).parent().addClass('focused');
    }
});

$('.checkbox-btn input').focusout(function(){
    $(this).parent().removeClass('focused');
});
