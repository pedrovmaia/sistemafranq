$(function () {
    var base = $('link[rel="base"]').attr('href') + "/";

    function trigger(data) {
        if(data[0]){
            $.each(data, function(key, value){
                triggerNotify(data[key]);
            })
        } else {
            triggerNotify(data);
        }
    }

    function triggerNotify(data) {

        var triggerContent = "<div class='trigger_notify trigger_notify_" + data.color + "' style='left: 100%; opacity: 0;'>";
        triggerContent += "<p class='" + data.icon + "'> " + data.title + "</p>";
        triggerContent += "<span class='trigger_notify_timer'></span>";
        triggerContent += "</div>";

        if(!$('.trigger_notify_box').length){
            $('body').prepend("<div class='trigger_notify_box'></div>");
        }

        $('.trigger_notify_box').prepend(triggerContent);
        $('.trigger_notify').stop().animate({'left': '0', 'opacity': '1'}, 200, function(){
            $(this).find('.trigger_notify_timer').animate({'width': '100%'}, data.timer, 'linear', function(){
                $(this).parent('.trigger_notify').animate({'left': '100%', 'opacity': '0'}, function(){
                    $(this).remove();
                });
            });
        });

        $('body').on('click', '.trigger_notify', function(){
            $(this).animate({'left': '100%', 'opacity': '0'}, function(){
                $(this).remove();
            });
        });
    }

    $('.login_form').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/Login.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
            if (data.error) {
                form.prepend("<div class='trigger trigger_error ajax_close'>" + data.error + "</div>");
            }
            if (data.trigger) {
                trigger(data.trigger);
            }
            if (data.redirect) {
                setTimeout(function () {
                    window.location.href = base + "" + data.redirect;
                }, 3000)
            }
        }, 'json');

        return false;
    });

});
