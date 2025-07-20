

// ******************* Stiky Nav ****************

function navigation(){
	if($(window).scrollTop() >= 40) {
		$('header').addClass('is-sticky');
		$('.content-wrapper').addClass('padtp');       
	}
	else{
		$('header').removeClass('is-sticky');
		$('.content-wrapper').removeClass('padtp');
	}
}

$(window).scroll(function(){
  navigation();
});


// ******************* Header Search Toggle ****************

$(document).ready(function(){
	$('.header-main .search .search-togglebtn').click(function(){
		$('.header-main .search .search-form').toggleClass('sm');
	});
	$('.header-main .search .search-togglebtn1').click(function(){
		$('.header-main .search .search-form').removeClass('sm');
	});
});

// ******************* currency Fancy DroapDown ****************

$("ul.currency-select").on("click", ".init", function() {
    $(this).closest("ul.currency-select").children('li:not(.init)').toggle();
});

var allOptions = $("ul.currency-select").children('li:not(.init)');
$("ul.currency-select").on("click", "li:not(.init)", function() {
    allOptions.removeClass('selected');
    $(this).addClass('selected');
    $("ul.currency-select").children('.init').html($(this).html());
    allOptions.toggle();
});

// ******************* Home Banner ****************

$('#homebanner').owlCarousel({
  loop: true,
  item: 1,
  nav: false,
  autoplay: true,
  autoplayTimeout: 5000,
  dots: true,
  responsive: {
        0: {
            items: 1
        },
        768: {
            items: 1
        },
        1000: {
            items: 1
        }
    }
});

// ******************* Product slider ****************

$('.product-carousel').owlCarousel({
	loop:true,
	margin:80,
	nav:true,
	navText: ["<i class='icon-left-arrow-1'></i>","<i class='icon-left-arrow-1'></i>"],
	dots:false,
	autoplay:true,
	responsive:{
		0:{
			items:1
		},
		576:{
			items:2
		},
		768:{
			items:3,
			margin:30
		},
		1200:{
			items:4
		}
	}
});

// ******************* Testimonial Slider ****************

$('.testi-slider').owlCarousel({
	loop: true,
	margin:10,
	item: 4,
	nav: true,
	navText: ["<i class='icon-left-arrow-3'></i>","<i class='icon-left-arrow-3'></i>"],
	autoplay: true,
	autoplayTimeout: 5000,
	dotsData: false,
	dots: false,
	responsiveClass:true,
	responsive: {
	    0: {
	        items: 1
	    },
	    768: {
	        items: 2
	    },
	    992: {
	        items: 3
	    },
	    1200: {
	        items: 4
	    }
	}
});

// ******************* Insta slider ****************

$('#instafeed').owlCarousel({
	loop: true,
	margin:20,
	item: 5,
	nav: true,
	autoplay: false,
	navText: ["<i class='icon-left-arrow-2'></i>","<i class='icon-left-arrow-2'></i>"],
	autoplayTimeout: 5000,
	dotsData: false,
	dots: false,
	responsiveClass:true,
	responsive: {
		0: {
			items: 1
		},
		576: {
			items: 2
		},
		768: {
			items: 3
		},
		1100: {
			items: 4
		},
		1200: {
			items: 5
		}
	}
});

// ******************* Mega Menu ****************

var HeaderAside = function() {

	$("#mynavigation .navbar-nav .has-children, #mynavigation .navbar-nav .has-children .sub.m-level-item,  #mynavigation .navbar-nav .has-children .level-home").prepend('<span class="plus-button"><i class="icon-left-arrow-1"></i></span>');

	$('header  .navbar-toggler').on('click',function() {
		$('header .bg-overlay').addClass('show');
		$('header #mynavigation').addClass('active');
		$('html').css('overflow-y','hidden');
	});
	$('.has-children.level0 .plus-button').each(function () {
		$(this).click(function () {
			$(this).siblings('.megamenu').find('.nav.level1').addClass('active');
		});
	});
	$('.level1 .sub.m-level-item .plus-button').each(function () {
		$(this).click(function () {
			$(this).siblings('ul.nav.level2').addClass("active");
		});
	});
	// $('.level-home .plus-button').each(function () {
	// 	$(this).click(function(){
	// 		$(this).parents('ul.nav.level1').removeClass('active');
	// 	});
	// });
	$('.level-home .plus-button').each(function () {
		$(this).click(function(){
			// var xyz = $(this).parents('ul.nav.level2');
			// console.log(xyz);
			$(this).parents('ul.nav').removeClass('active');
		});
	});

	$('#mynavigation .close-menu').click(function(event) {
		$('header .bg-overlay').removeClass("show");
		$('header #mynavigation, ul.nav.level1, ul.nav.level2').removeClass("active");
		$('html').removeAttr('style');
	});
}
HeaderAside();

