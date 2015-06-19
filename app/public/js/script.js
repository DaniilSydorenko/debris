/*************************/
/*   Header and mustache stuff
 /*************************/

$counter = 1;
$current_class = 'm_1';
$hover_class = 'm_1';
$last_visit = 0;
$autorotate = 0;
$forwardOne = 0;
$stachePicked = 0;
$lastScrollTop = 0;



/*************************/
/*   GENERAL VARIABLES
 /*************************/
$isMobile = null;
$myelement = null;
var toggle_visual = 0;
var myfirstindex;
var myindex;
var loadurl;
var scrollCounter = 0;
var $skrol;  //not sure I need this one
var mypages = [
    'home',
    'about',
    'portfolio',
    'resources',
    'blog',
    'photography',
    'florida-2013',
    'silverlake-2013',
    'monterey-2013',
    'summer-2013',
    'colorado-2013',
    'nutanix-case-study',
    'mimi-glyphs',
    'cameras-psd',
    'fujifilm',
    'archive'
];
var myscripts = [
    '../SD_Main/js/home.js',
    '../SD_Main/js/about.js',
    '../SD_Main/js/defaultjs.js',
    '../SD_Main/js/defaultjs.js',
    '../SD_Main/js/defaultjs.js',
    '../SD_Main/js/defaultjs.js',
    '../../SD_Main/js/florida2013.js',
    '../../SD_Main/js/florida2013.js',
    '../../SD_Main/js/florida2013.js',
    '../../SD_Main/js/florida2013.js',
    '../../SD_Main/js/florida2013.js',
    '../../SD_Main/js/florida2013.js',
    '../../SD_Main/js/defaultjs.js',
    '../../SD_Main/js/defaultjs.js',
    '../../SD_Main/js/defaultjs.js',
    '../../SD_Main/js/defaultjs.js'
];

var $root = $(document.documentElement),
    $window = $(window);

var windowWidth = 0,
    windowHeight = 0;


$(document).ready(function()
{

    // this is used so I can track the current page. I use it to toggle script files and class names in body
    regexpStart = /.+\/([^\/]+)/;
    matchStart = regexpStart.exec(window.location.href);
    myfirstindex = jQuery.inArray( matchStart[1], mypages );
    myindex = jQuery.inArray( matchStart[1], mypages );

    updateMyElement();

    windowWidth = $window.width(),
        windowHeight = $(window).height(),

        $isMobile = navigator.userAgent.match(/(iPhone|iPod|iPad|Android|BlackBerry)/);


    initLocalStorage( );
    onMustacheLogoClick();

    $('.salleedesign_header .menu-toggle-link').click(function() {
        $('#main_nav').toggleClass('active');
        return false;
    });

    $('#main_nav a.tooltips').click(function() {
        $('#main_nav').removeClass('active');
        return false;
    });



    if( window.devicePixelRatio ){
        if( window.devicePixelRatio > 1 ){
            loadHighResImages();
        }
    }

    window.setTimeout(function()
    {
        $('.menu' ).addClass( 'init' );
        $('.mustachepickerpage' ).addClass( 'init' );
        //$('#main' ).addClass( 'init' );
    }, 600);

    document.addEventListener("scroll", myScroll, false);
    document.addEventListener("touchmove", myScroll, false);

    $("#main").scroll(function() {
        myScroll();
    });

    $("#main-2").scroll(function() {
        myScroll();
    });

    $('#main').addClass('iddle');
    $('#main-2').addClass('reset');

    paragraphScroll();
    mymainresizes();
    myresizes();
    setheaders();
    windowresize();
    manage_scroller();
    onreadnow();
    //remove the no-transition class that was used to avoid the main window height resize glitch
    window.setTimeout(function(){
        $('#main').removeClass('no-transition');
    }, 100);


});

function updateMyElement(){
    if( toggle_visual == 0 ){ $myelement = $('#main'); }
    else{ $myelement = $('#main-2'); }
}


/**
 *
 *
 * Scroll events
 *
 *
 **/
function myScroll( ){



    var st = $myelement.scrollTop();


    //up and down scroll for the header
    if (st > $lastScrollTop){
        // downscroll code
        if( st > 0 ){
            if( $('header').hasClass('in')){
                scrollCounter++;
                if( scrollCounter >= 1){
                    $(' header ').removeClass('in').addClass('out');
                    scrollCounter = 0;
                }
            }
        }

        if ($myelement.scrollTop() == $(document).height()-$(window).height()){
            $(' header ').removeClass('out').addClass('in');
        }

    } else {
        if( $('header').hasClass('out')){
            scrollCounter++;
            if( scrollCounter >= 3){
                $(' header ').removeClass('out').addClass('in');
                scrollCounter = 0;
            }
        }
    }
    $lastScrollTop = st;

    if( $myelement.find(".top_intro").length > 0 ){
        if( windowWidth > 1200 ){
            var revertColor = windowHeight - 40;
        }
        else{
            var revertColor = windowHeight/3;
        }
        if($myelement.scrollTop() > revertColor ) {
            if( $("header").hasClass('white')) $("header").removeClass('white').addClass('black');
            if( $("header").hasClass('transparent')) $("header").removeClass('transparent');
        }
        else{
            if( $myelement.find(".full-image").length > 0 ){
                if( $("header").hasClass('black')) $("header").removeClass('black').addClass('white');
            }
            else{
                if( $("header").hasClass('black')) $("header").addClass('transparent');
            }
        }
    }
    else{
        revertColor = 60;
        if($myelement.scrollTop() > revertColor ) {
            if( $("header").hasClass('transparent')) $("header").removeClass('transparent');
        }
        else{
            if( $("header").hasClass('black')) $("header").addClass('transparent');
        }
    }

    //paragraph show
}

function setheaders(){
    if( $myelement.find(".full-image").length > 0 ){
        if( $("header").hasClass('black')) $("header").removeClass('black').addClass('white');
    }
    else{
        if( $("header").hasClass('white')) $("header").removeClass('white').addClass('black');
    }
    if( $("header").hasClass('black')) $("header").addClass('transparent');

    $(' header ').removeClass('out').addClass('in');
    if( $isMobile != null ){
        $('body').addClass('mobile-no-hovers-dude');
        $(' header ').removeClass('out').addClass('in');
    }
}

/**
 *
 *
 * paragraph fade in scroll
 *
 *
 **/
function paragraphScroll(){
    /*
     myps = $myelement.find( 'p' );

     myps.each(function() {
     var tst = $(this);

     $myelement.scroll(function() {
     if( mypages[myindex] == 'home'  ||
     mypages[myindex] == 'about'  ||
     mypages[myindex] == 'florida-2013' ||
     mypages[myindex] == 'silverlake-2013' ||
     mypages[myindex] == 'monterey-2013' ||
     mypages[myindex] == 'summer-2013' ||
     mypages[myindex] == 'nutanix-case-study' ){
     if( tst.hasClass( 'show' )){
     }
     else{

     var topDistance = tst.offset().top + $myelement.scrollTop();
     var scrollPos = $myelement.scrollTop() + windowHeight - 200;

     if( tst.hasClass( 'very-last-p' ) ) var scrollPos = $myelement.scrollTop() + windowHeight - 100;

     if(scrollPos > topDistance ) {
     tst.addClass( 'show' );
     }
     }
     }
     });
     });
     */
}

/**
 *
 *
 * all the resizes that have to be done
 *
 *
 **/
function myresizes(){

    if( $myelement.find(".top_intro").length > 0 ){
        $myelement.find(".top_intro").css({ "height": windowHeight });
        fancyTitleIntro();
        setReadMore();

        if( $myelement.find(".full-image").length > 0 ) seamlessImageLoad();
    }
}

function setReadMore(){
    $myelement.find('.read-now-link').click(function(){

        destination = $myelement.find('.start_reading').offset().top;
        $myelement.animate({ scrollTop: destination}, 500 );

        return false;
    });
}

function seamlessImageLoad(){

    if( loadurl != null ) loadurl.onload = null;;

    loadurl = new Image();
    loadurl.onload = function(){

        $myelement.find(".top_intro").css("background-image", myUrl);
        //$('body').removeClass("loading");
    }

    var myUrl = "url(http://salleedesign.com/assets/" + mypages[ myindex ] + "/photo-top.jpg)";
    var myUrlShort = "http://salleedesign.com/assets/" + mypages[ myindex ] + "/photo-top.jpg";

    loadurl.src = myUrlShort;
}

function fancyTitleIntro(){
    $myelement.find(".top_intro").addClass( "init_1" );
    window.setTimeout(function()
    {
        $myelement.find(".top_intro").addClass( "init_2" );
    }, 500);
}

function mymainresizes(){
    //main resizes
    windowWidth = $window.width();
    windowHeight = $(window).height();

    $('#main').css('height', windowHeight + 1 );
    $('#main-2').css('height', windowHeight + 1 );

    if( toggle_visual == 0 ){
        $('#main-2').css('top', 1*windowHeight );
        $('#main').css('top', 0 );
    }
    else{
        $('#main').css('top', 1*windowHeight );
        $('#main-2').css('top', 0 );
    }
}

function windowresize(){

    $(window).resize(function(){
        if( $isMobile != null ){
            if($(window).width() != windowWidth && $(window).height != windowHeight ){
                mymainresizes();
                myresizes();
            }
        }
        else{
            if($(window).width() != windowWidth || $(window).height != windowHeight ){
                mymainresizes();
                myresizes();
            }
        }
    });
}

/**
 *
 *
 * read now click
 *
 *
 **/
function onreadnow(){
    $('.read-now-link').click(function()
    {
        if( $isMobile == null ){ var destination = $myelement.find('.start_reading').offset().top; }
        else {
            if( $(window).width() < 600 ) var destination = myelement.find('#start_reading').offset().top - 50;
            else var destination = $myelement.find('#start_reading').offset().top;
        }
        $myelement.animate({ scrollTop: destination}, 500 );

        return false;

    });
}


/**
 *
 *
 * load @2x if on retina capable device
 *
 *
 **/
function loadHighResImages(){
    var imageExtension = null;
    imageExtension = "@2x";

    if( imageExtension ){
        $(".upscale").each( function( index, element ){
            var newSrc = $(element).attr('src').replace(/\.png/g, imageExtension+".png" );
            $(element).attr('src', newSrc );
        });
    }
}



/**
 *
 *
 * init the local storage. Check if existent and set timer
 *
 *
 **/
function initLocalStorage()
{

    if (typeof(localStorage) == 'undefined' ){
        locals = "m_1";
    }
    else{
        var locals = localStorage.getItem("moustache_choice");
        if( locals == null ){
            locals = "m_1";
        }
        else{
            if( locals != "m_1" &&
                locals != "m_2" &&
                locals != "m_3" &&
                locals != "m_4" &&
                locals != "m_5" &&
                locals != "m_6" &&
                locals != "m_7" &&
                locals != "m_8" &&
                locals != "m_9")
            {
                locals = "m_1";
            }
        }
    }

    $stachePicked = 1;
    $('body').addClass( 'stachepicked' );
    $current_class = locals;
    $counter = $current_class.substr(2);
    setMoustacheLogo( $current_class );
    setSelectedStacheClass();
}


/**
 *
 *
 * write on browsers local sdtorage. Html5
 *
 *
 **/
function setLocalStorage()
{
    $stachePicked = 1;
    $('body').addClass( 'stachepicked' );
    try
    {
        localStorage.setItem("moustache_choice", $current_class); //saves to the database, "key", "value"
    }
    catch (e)
    {
        if (e == QUOTA_EXCEEDED_ERR)
        {
            alert('Quota exceeded!'); //data wasn't successfully saved due to quota exceed so throw an error
        }
    }
}


/**
 *
 *
 * sert timer on local storage
 *
 *
 **/
function setTimerStorage()
{
    try
    {
        localStorage.setItem("visited_last_24h", $last_visit); //saves to the database, "key", "value"
    }
    catch (e)
    {
        if (e == QUOTA_EXCEEDED_ERR)
        {
            alert('Quota exceeded!'); //data wasn't successfully saved due to quota exceed so throw an error
        }
    }
}



/**
 *
 *
 * All the functions around the header functionality.
 *
 *
 **/
function setMoustacheLogo( tha_class )
{
    $('#mustache_on_logo').removeClass( ).addClass( tha_class );
    $('#mustache_on_menu').removeClass( ).addClass( tha_class );
}

function onMustacheLogoClick(){

    $('header .left-controler .arrow a').click(function()
    {
        forwardOne();
        return false;
    });

    $('.header-menu-icon a').click(function()
    {
        $('body').addClass( 'menuopen_2' );
        return false;
    });

    $("#main").click(function()
    {
        if( $('body').hasClass( 'menuopen_2' )){
            $('body').removeClass( 'menuopen_2' );

            return false;
        }
    });

    $("#main-2").click(function()
    {
        if( $('body').hasClass( 'menuopen_2' )){
            $('body').removeClass( 'menuopen_2' );
            return false;
        }
    });


    $('.mustachepickerpage .close_btn a').click(function()
    {
        $('body').removeClass( 'menuopen' );
        return false;
    });

    $('.menu .close_btn a').click(function()
    {
        $('body').removeClass( 'menuopen_2' );
        return false;
    });

    $('.menu ul li a.closemenu').click(function()
    {
        $('body').removeClass( 'menuopen_2' );
    });


    $('.menu ul li a.last').click(function()
    {
        $('body').removeClass( 'menuopen_2' );
        $('body').addClass( 'menuopen' );
        return false;
    });


    $('.logo_icon_list div a').click(function()
    {
        $current_class = $( this ).attr('class');
        setMoustacheLogo( $current_class );
        setSelectedStacheClass();
        $stachePicked = 1;
        $('body').removeClass( 'menuopen' );
        setLocalStorage();
        return false;
    });

    $('.logo_icon_list div a').hover( function()
        {
            if( $stachePicked == 0 ) $autorotate = 0;
            removeSelectedStacheClass( );
            $hover_class = $( this ).attr('class');
            setMoustacheLogo( $hover_class );
        },
        function()
        {
        });

    $('.logo_icon_list div').hover( function()
        {
        },
        function()
        {
            if( $stachePicked == 0 )
            {
                $autorotate = 1;
                $counter = 0;
                $current_class = 'm_0';
                mCounter();
            }
            else{
                setSelectedStacheClass();
                setMoustacheLogo( $current_class );
            }
        });

}

function removeSelectedStacheClass( ){
    var $target_class = '.logo_icon_list div .' + $current_class;
    $( $target_class ).removeClass( 'selected' );
}

function setSelectedStacheClass( ){
    var $target_class = '.logo_icon_list div .' + $current_class;
    $( $target_class ).addClass( 'selected' );
}

function forwardOne(){
    $forwardOne = 1;
    mCounter();
    $forwardOne = 0;
    setLocalStorage();
}

function onRefresh(){
    $autorotate = 1;
    //turnRefresh();
    mCounter();
}

function mCounter( )
{
    if( $autorotate == 1 || $forwardOne == 1 )
    {
        removeSelectedStacheClass( );
        $counter++;
        if( $counter == 9 ) $counter = 1;
        $current_class = 'm_' + $counter;
        setMoustacheLogo( $current_class );
        setSelectedStacheClass( );
        if( $autorotate == 1 ) window.setTimeout(mCounter, 3000);
    }
}



/**
 *
 *
 * scroll to top etc
 *
 *
 **/
function manage_scroller()
{
    $('.scroller').click(function()
    {
        var clicked = $(this).attr("href");
        var destination = $(clicked).offset().top;
        $("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination}, 500 );
        return false;
    });
}








