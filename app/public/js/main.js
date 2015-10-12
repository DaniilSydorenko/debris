/**
 * Animated header
 */
$(function() {
    $(window).scroll(function () {
        var scroll = getCurrentScroll();
        if (scroll >= 60) {
            $('.navbar').addClass('shrink');
        }
        else {
            $('.navbar').removeClass('shrink');
        }
    });

    /**
     * Get current scroll hight
     */
    function getCurrentScroll() {
        return window.pageYOffset || document.documentElement.scrollTop;
    }
});

/* Set Qtip on fields */
//function setQtip() {
//    $('form input[name*="urlfield[url]"]').each(function() {
//        $(this).qtip({
//            content: {
//                text: 'Type your url with \'http://\''
//            },
//            style: {
//                name: 'dark',
//                tip: true
//            },
//            show: {
//                effect: {
//                    type: 'slide',
//                    length: 500
//                }
//            }
//        });
//    });
//}

/* Load all JS functions */
$(document).ready(function(){

    // @TODO: Separate url. parse and common

    var myRegExp =/^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?$/i;

    $('form input[name*="urlfield[url]"]').on('keyup', function ()
    {
        var $input = $(this).val(),
            $element = $("#urlfield_url"),
            $button =  $("form button"),
            accessColors = {'border-color': '#92dce0', 'background-color': '#ffffff'},
            errorColors = {'border-color': '#E86850', 'box-shadow': 'none', 'background-color': '#ffeeee'};

        if (!$input) {
            $element.css(accessColors);
            $button.prop("disabled", false);
        } else if ($input.length >= 1) {
            if (!myRegExp.test($input)) {
                setTimeout(function () {
                    $element.css(errorColors);
                    $button.prop("disabled", true);
                }, 300);
            } else if ($input) {
                setTimeout(function () {
                    $element.css(accessColors);
                    $button.prop("disabled", false);
                }, 300);
            }
        }
    });

    $('.dbrs-form').on('submit', function (e) {
        var event = e || window.event;
        event.stopPropagation();

        var $form = $(this),
            url = $form.attr('action'),
            method = $form.attr('method'),
            data = $form.serialize(),
            $urlInput = $form.find('input[name*="urlfield[url]"]'),
            $submit = $form.find('button'),
            $element = $("#urlfield_url"),
            urlToValidate = $urlInput.val(),
            errorColors = {'border-color': '#E86850', 'box-shadow': 'none', 'background-color': '#ffeeee'};

        if (urlToValidate.length < 1) {
            setTimeout(function () {
                $element.css(errorColors);
                $submit.prop("disabled", true);
            }, 300);
        } else if (urlToValidate.length >= 1 && !myRegExp.test(urlToValidate)) {

            // Check url length
            // to lowercase
            // rtrim / ??

            $("form.dbrs-form").hide();
            $(".dbrs-box").fadeIn("slow");

            $(".dbrs-url-valid").hide();
            $('label[for="dbrs-sad-img"]').text("Sorry, but your url is invalid!");
            $(".dbrs-url-invalid").slideUp().fadeIn();

            setTimeout(function () {
                //$element.css(errorColors);
                //$button.prop("disabled", true);
                $(".dbrs-error").fadeIn();
            }, 300);

            //$submit.prop("disabled", true);

        } else {
            $.ajax(
                {
                    'url': "/JSON/Shortener/shortenUrl",
                    'type': method,
                    'dataType': 'json',
                    'data': {url: $urlInput.val()},
                    'success': function (data)
                    {
                        var shortUrl = data.data.shortUrl,
                            longUrl = data.data.longUrl,
                            urlViews = data.data.urlViews,
                            urlDescription = data.data.description;

                        //if (shortUrl) {

                            $("form.dbrs-form input").val('');
                            $(".dbrs-box").slideUp().fadeIn();
                            if (shortUrl.toLowerCase().indexOf("http://") >= 0) {

                                // @TODO REMOVE BEFORE

                                $(".dbrs-box-content-res").empty();

                                // Create short link
                                var shortLink = $("<a></a>")
                                    .addClass("dbrs-short-url")
                                    .attr("href", shortUrl)
                                    .text(shortUrl);
                                $(".dbrs-box-srt-res .dbrs-box-content-res").append(shortLink);

                                // Create long link
                                var longLink = $("<a></a>")
                                    .addClass(".dbrs-long-url")
                                    .attr("href", longUrl)
                                    .text(urlDescription);
                                $(".dbrs-box-lng-res .dbrs-box-content-res").append(longLink);


                                //$(".dbrs-short-url").text(shortUrl);
                                //$(".dbrs-long-url").text(longUrl);
                                //$("#url-statistic").text(urlViews);

                            } else {
                                $(".dbrs-url-valid").hide();
                                $('label[for="dbrs-sad-img"]').text(shortUrl);
                                $(".dbrs-url-invalid").slideUp().fadeIn();
                                $submit.attr('disabled', 'true');

                                setTimeout(function () {
                                    $(".dbrs-url-valid").hide();
                                    //$element.css(errorColors);
                                    //$button.prop("disabled", true);
                                    $(".dbrs-error").fadeIn();
                                }, 300);
                            }
                        //}
                        //else {
                        //    // Error
                        //}
                    },
                    'error': function ()
                    {
                        // Error
                    }
                }
            );
        }
        return false;
    });
});

