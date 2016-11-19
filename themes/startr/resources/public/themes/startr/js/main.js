// When the DOM is ready, run this function
$(document).ready(function() {
  
  //#HEADER
	var slideHeight = $(window).height();
	$('#headere-top figure .item').css('height',slideHeight);

	$(window).resize(function(){'use strict',
		$('#headere-top figure .item').css('height',slideHeight);
	});
  
  
  
  //Scroll Menu
	$(window).on('scroll', function(){
		if( $(window).scrollTop()>600 ){
			$('.header-top .header-fixed-wrapper').addClass('navbar-fixed-top animated fadeInDown');
			
		} else {
			$('.header-top .header-fixed-wrapper').removeClass('navbar-fixed-top animated fadeInDown');
		}
	});
	
	
	 $(window).scroll(function(){                          
            if ($(this).scrollTop() > 200) {
                $('#menu').fadeIn(500);
            } else {
                $('#menu').fadeOut(500);
            }
        });
	
	// Navigation Scroll
	$(window).scroll(function(event) {
		Scroll();
	});

	$('.navbar-collapse ul li a').on('click', function() {  
		$('html, body').animate({scrollTop: $(this.hash).offset().top - 1}, 1000);
		return false;
	});
	
	// User define function
	function Scroll() {
		var contentTop      =   [];
		var contentBottom   =   [];
		var winTop      =   $(window).scrollTop();
		var rangeTop    =   200;
		var rangeBottom =   500;
		$('.navbar-collapse').find('.scroll a').each(function(){
			contentTop.push( $( $(this).attr('href') ).offset().top);
			contentBottom.push( $( $(this).attr('href') ).offset().top + $( $(this).attr('href') ).height() );
		})
		$.each( contentTop, function(i){
			if ( winTop > contentTop[i] - rangeTop ){
				$('.navbar-collapse li.scroll')
				.removeClass('active')
				.eq(i).addClass('active');			
			}
		})
	};
  
  // affix
  var width = $(window).width();
  var top = $('.tp-banner-container').length == 0 ? -1 : $('.section-one').offset().top - $('.navbar').height() * 2;
  $('.navbar').affix({
    offset: {
      top: top
    , bottom: function () {
        return (this.bottom = $('.footer').outerHeight(true))
      }
    }
  });
  
  var owl = $("#owl-demo");

      owl.owlCarousel({
        
        itemsCustom : [
          [0, 1],
          [450, 1],
          [600, 1],
          [700, 1],
          [1000, 1],
          [1200, 1],
          [1400, 1],
          [1600, 1]
        ],
        navigation : true,
		autoPlay : 3000,

      });
	  
	  
	  $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
          disableOn: 700,
          type: 'iframe',
          mainClass: 'mfp-fade',
          removalDelay: 160,
          preloader: false,

          fixedContentPos: false
        });
  
});