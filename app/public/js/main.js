/* Set form in the center of page */
function windowResizer() {
    $(window).resize(function() {
        $('#top_intro').height($(window).height() - 1);
    });
    $(window).trigger('resize');
}

/* Navbar elements decorative line */
//function navbarElementsLine() {
//    if ($("body").hasClass("url-snr")) {
//        $(".line-snr").animate(
//            { width: '143px' },
//        "slow");
//    } else if ($("body").hasClass("fie-psr")) {
//        $(".line-extr").animate(
//            { width: '115px' },
//        "slow");
//    }
//}

/* Set bootstrap style for file input */
function inputFileStyle() {
    $(":file").filestyle(
        { icon: true }
    );
    $('input[type="text"]').attr('disabled', false);
}

/* Set Qtip on fields */
function setQtip() {
    $('form input[name*="urlfield[url]"]').each(function() {
        $(this).qtip({
            content: {
                text: 'Type your url with \'http://\''
            },
            style: {
                name: 'dark',
                tip: true
            },
            show: {
                effect: {
                    type: 'slide',
                    length: 500
                }
            }
        });
    });
}

/* Load all JS functions */
$(document).ready(function(){

    // @TODO: Separate url. parse and common

    windowResizer();
    inputFileStyle();
    //setQtip();

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

    $('.url-snr-form').on('submit', function (e) {
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

            $("form.url-snr-form").hide();
            $(".url-snr-box").fadeIn("slow");

            $(".url-snr-url-valid").hide();
            $('label[for="url-snr-sad-img"]').text("Sorry, but your url is invalid!");
            $(".url-snr-url-invalid").slideUp().fadeIn();

            setTimeout(function () {
                //$element.css(errorColors);
                //$button.prop("disabled", true);
                $(".url-snr-error").fadeIn();
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
                        var response = data.data.response;
                        var longUrl = data.data.longUrl;
                        var urlViews = data.data.urlViews;

                        //if (response) {

                            $("form.url-snr-form").hide();
                            $(".url-snr-box").slideUp().fadeIn();
                            if (response.toLowerCase().indexOf("http://") >= 0) {
                                $(".url-snr-short-url").val(response);
                                $(".url-snr-long-url").val(longUrl);
                                $("#url-statistic").text(urlViews);
                            } else {
                                $(".url-snr-url-valid").hide();
                                $('label[for="url-snr-sad-img"]').text(response);
                                $(".url-snr-url-invalid").slideUp().fadeIn();
                                $submit.attr('disabled', 'true');

                                setTimeout(function () {
                                    $(".url-snr-url-valid").hide();
                                    //$element.css(errorColors);
                                    //$button.prop("disabled", true);
                                    $(".url-snr-error").fadeIn();
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

