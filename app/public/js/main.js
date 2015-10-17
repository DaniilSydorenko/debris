/**
 * Animated header
 */
$(function () {
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

$(document).ready(function () {

    // @TODO: Separate url. parse and common

    var myRegExp = /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?$/i;

    $('form input[name*="urlfield[url]"]').on('keyup', function () {
        var $input = $(this).val(),
            $element = $("#urlfield_url"),
            $button = $("form button"),
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

            $("form.dbrs-form").hide();
            $(".dbrs-box").fadeIn("slow");

            $(".dbrs-url-valid").hide();
            $('label[for="dbrs-sad-img"]').text("Sorry, but your url is invalid!");
            $(".dbrs-url-invalid").slideUp().fadeIn();

            setTimeout(function () {
                $(".dbrs-error").fadeIn();
            }, 300);

        } else {
            $.ajax(
                {
                    'url': "/JSON/Shortener/shortenUrl",
                    'type': method,
                    'dataType': 'json',
                    'data': {url: $urlInput.val()},
                    'success': function (data) {
                        var shortUrl = data.data.shortUrl,
                            longUrl = data.data.longUrl,
                            urlViews = data.data.urlViews,
                            urlDescription = data.data.description;

                        $("form.dbrs-form input").val('');
                        if (shortUrl.toLowerCase().indexOf("http://") >= 0) {

                            var shLink = $("<a></a>").addClass("dbrs-short-url").attr("href", shortUrl).text(shortUrl);
                            var lnLink = $("<a></a>").addClass("dbrs-long-url").attr("href", longUrl).text(urlDescription);

                            var $urlEntity = $('<div class="row url-entity"></div>'),
                                $validUrl = $('<div class="dbrs-url-valid-res col-md-12 col-sm-12"></div>'),
                                $rowIco = $('<div class="col-md-1 col-sm-1 col-xs-1">' +
                                                '<a class="no-fade" href="#" target="_blank" title="">' +
                                                    '<p aria-hidden="true" class="icon_link"></p>' +
                                                '</a>' +
                                            '</div>'),
                                $row = $('<div class="col-md-9 col-sm-9 col-xs-9"></div>'),
                                $rowAction = $('<div class="dbrs-url-action col-md-2 col-sm-2 col-xs-2"></div>'),
                                $viewsCounter = $('<span></span>').text(urlViews),
                                $views = $('<p class="dbrs-url-views"></p>'),
                                $copyBtn = $('<button class="dbrs-url-copy">Copy</button>');

                            $views.text("Views: ");
                            $views.append($viewsCounter);
                            $rowAction.append($views);
                            $rowAction.append($copyBtn);

                            var $sh = $('<div class="dbrs-box-srt-res col-sm-12"></div>'),
                                $ln = $('<div class="dbrs-box-lng-res col-sm-12"></div>'),
                                $shResContent = $('<div class="dbrs-box-content-res"></div>').html(shLink),
                                $lnResContent = $('<div class="dbrs-box-content-res"></div>').html(lnLink);

                            $sh.html($shResContent);
                            $ln.html($lnResContent);
                            $row.append($sh);
                            $row.append($ln);
                            $validUrl.append($rowIco);
                            $validUrl.append($row);
                            $validUrl.append($rowAction);
                            $urlEntity.append($validUrl);
                            $('.done-urls').prepend($urlEntity.fadeIn(500));
                        } else {
                            $(".dbrs-url-valid").hide();
                            $('label[for="dbrs-sad-img"]').text(shortUrl);
                            $(".dbrs-url-invalid").slideUp().fadeIn();
                            $submit.attr('disabled', 'true');

                            setTimeout(function () {
                                $(".dbrs-url-valid").hide();
                                $(".dbrs-error").fadeIn();
                            }, 300);
                        }
                    },
                    'error': function () {
                        // Error
                    }
                }
            );
        }
        return false;
    });
});

