jQuery(function ($) {
    $('body').attr('id', 'top');

    $('#back-to-top').on('click', function (event) {
        if (this.hash !== '') {
            event.preventDefault();
            var hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function () {
                window.location.hash = hash;
            });
        }
    });

    $(window).on('scroll', function () {
        var scrollTop = $(window).scrollTop();
        if (scrollTop > 100)
        {
            $('#back-to-top').css('display', 'block');
        } else
        {
            $('#back-to-top').css('display', 'none');
        }
    });

    $('.nav-primary').addClass('responsive-menu').before('<div id="responsive-menu-icon"></div><div class="full-screen-menu"');
	$('.title-area').after('<div button id="search-icon"></div><div id="search-form"><form action="/"><input class="searchboxtop" type="text" name="s" placeholder="Search..."><input class="searchbox-submit" type="submit" value="">');
	
    $('#responsive-menu-icon').prependTo('.site-header .wrap');
    $('#search-icon').appendTo('.site-header .wrap');
	
    $('#responsive-menu-icon').click(function () {
        $('.nav-primary').slideToggle('fast');
        $(this).toggleClass('menu-open');
        if($('#search-icon').css('display') === 'none'){
            $('#search-icon').css('display', 'inline-block');
        }else{
            $('#search-icon').css('display', 'none');
        }
        $('.nav-primary').toggleClass('fullscreen');
    });

	$('#search-icon').click(function () {
        $('#search-form').slideToggle('fast');
        $(this).toggleClass('menu-open');
        $('#responsive-menu-icon').toggle();
        $('#search-form').toggleClass('fullscreen');
    });
	
    function changeMenuLocation() {
        if (window.innerWidth > 860) {
            $('.responsive-menu').prependTo('.site-header .widget-area');
            $('#responsive-menu-icon').hide();
            $('#search-icon').hide();
        } else {
            $('.responsive-menu').appendTo('.site-header');
            $('#responsive-menu-icon').show();
            $('#search-icon').show();
        }
    }
    
    changeMenuLocation();
    $(window).resize(changeMenuLocation);
});

