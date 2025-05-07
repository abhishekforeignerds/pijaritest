(function ($) {
    "use strict";
    var showSwitcher = true;
    var $body = $('body');
    var $style_switcher = $('#style-switcher');
    if (!$style_switcher.length && showSwitcher) {
        $.ajax({
            url: "color-switcher/style-switcher.html",
            success: function (data) {
                $body.append(data);
            },
            dataType: 'html'
        });
    }

    function handlePreloader() {
        if ($('.preloader').length) {
            $('.preloader').delay(200).fadeOut(500);
        }
    }

    function headerStyle() {
        if ($('.main-header').length) {
            var windowpos = $(window).scrollTop();
            var siteHeader = $('.header-style-one');
            var scrollLink = $('.scroll-to-top');
            var sticky_header = $('.main-header .sticky-header');
            if (windowpos > 100) {
                sticky_header.addClass("fixed-header animated slideInDown");
                scrollLink.fadeIn(300);
            } else {
                sticky_header.removeClass("fixed-header animated slideInDown");
                scrollLink.fadeOut(300);
            }
            if (windowpos > 1) {
                siteHeader.addClass("fixed-header");
            } else {
                siteHeader.removeClass("fixed-header");
            }
        }
    }
    headerStyle();
    if ($('.main-header li.dropdown ul').length) {
        $('.main-header .navigation li.dropdown').append('<div class="dropdown-btn"><i class="fa fa-angle-down"></i></div>');
    }
    if ($('.hidden-bar').length) {
        $('.toggle-hidden-bar').on('click', function () {
            $('body').addClass('active-hidden-bar');
        });
        $('.hidden-bar-back-drop, .hidden-bar .close-btn').on('click', function () {
            $('body').removeClass('active-hidden-bar');
        });
    }
    if ($('.mobile-menu').length) {
        var mobileMenuContent = $('.main-header .main-menu .navigation').html();
        $('.mobile-menu .navigation').append(mobileMenuContent);
        $('.sticky-header .navigation').append(mobileMenuContent);
        $('.mobile-menu .close-btn').on('click', function () {
            $('body').removeClass('mobile-menu-visible');
        });
        $('.mobile-menu li.dropdown .dropdown-btn').on('click', function () {
            $(this).prev('ul').slideToggle(500);
            $(this).toggleClass('active');
            $(this).prev('.mega-menu').slideToggle(500);
        });
        $('.mobile-nav-toggler').on('click', function () {
            $('body').addClass('mobile-menu-visible');
        });
        $('.mobile-menu .menu-backdrop, .mobile-menu .close-btn').on('click', function () {
            $('body').removeClass('mobile-menu-visible');
        });
    }
    if ($('.search-btn').length) {
        $('.search-btn').on('click', function () {
            $('.main-header').addClass('moblie-search-active');
        });
        $('.close-search, .search-back-drop').on('click', function () {
            $('.main-header').removeClass('moblie-search-active');
        });
    }
    if ($('.banner-slider').length) {
        var swiper = new Swiper(".banner-slider", {
            slidesPerView: 1,
            spaceBetween: 15,
            infinite: true,
            autoplay: true,
            arrows: true,
            autoplaySpeed: 3000,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                576: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 1,
                },
                992: {
                    slidesPerView: 1,
                },
                1023: {
                    slidesPerView: 1,
                },
                1400: {
                    slidesPerView: 1,
                },
            },
        });
    }
    if ($('.our-pujari-slider').length) {
        var swiper = new Swiper(".our-pujari-slider", {
            slidesPerView: 1,
            spaceBetween: 15,
            infinite: true,
            autoplay: true,
            arrows: true,
            autoplaySpeed: 3000,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                576: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 2,
                },
                1023: {
                    slidesPerView: 4,
                },
                1400: {
                    slidesPerView: 4,
                },
            },
        });
    }
    if ($('.service-three-slider').length) {
        var swiper = new Swiper(".service-three-slider", {
            slidesPerView: 1,
            spaceBetween: 15,
            infinite: true,
            autoplay: true,
            arrows: true,
            autoplaySpeed: 3000,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                576: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 2,
                },
                1023: {
                    slidesPerView: 5,
                },
                1400: {
                    slidesPerView: 5,
                },
            },
        });
    }
    if ($('.package-slider').length) {
        var swiper = new Swiper(".package-slider", {
            slidesPerView: 1,
            spaceBetween: 8,
            infinite: true,
            autoplay: true,
            arrows: false,
            autoplaySpeed: 3000,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                576: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 2,
                },
                1023: {
                    slidesPerView: 4,
                },
                1400: {
                    slidesPerView: 4,
                },
            },
        });
    }
    if ($('.review-slider').length) {
        const swiper = new Swiper('.review-slider', {
            slidesPerView: 1,
            spaceBetween: 10,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                576: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 2,
                },
                1400: {
                    slidesPerView: 2,
                },
            },
        });
    }


    if ($('.oneday-puja-slider').length) {
        var swiper = new Swiper(".oneday-puja-slider", {
            slidesPerView: 1,
            spaceBetween: 15,
            infinite: true,
            autoplay: true,
            arrows: true,
            autoplaySpeed: 3000,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                576: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 1,
                },
                992: {
                    slidesPerView: 1,
                },
                1023: {
                    slidesPerView: 1,
                },
                1400: {
                    slidesPerView: 1,
                },
            },
        });
    }
    if ($('.video-testimonial').length) {
        var swiper = new Swiper(".video-testimonial", {
            slidesPerView: 1,
            spaceBetween: 15,
            infinite: true,
            autoplay: true,
            arrows: false,
            autoplaySpeed: 3000,
            // navigation: {
            // 	nextEl: '.swiper-button-next',
            // 	prevEl: '.swiper-button-prev',
            // },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                576: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 2,
                },
                1023: {
                    slidesPerView: 3,
                },
                1400: {
                    slidesPerView: 3,
                },
            },
        });
    }
    if ($('.testimonial-single-slider').length) {
        $('.testimonial-single-slider').slick({
            infinite: true,
            dots: true,
            arrows: true,
            autoplay: true,
            autoplaySpeed: 3000,
            fade: true,
            fadeSpeed: 1000
        });
    }
    if ($('.testimonial-slider-content').length) {
        var slider = new Swiper('.testimonial-slider-content', {
            slidesPerView: 1,
            navigation: false,
            centeredSlides: true,
            loop: true,
            loopedSlides: 6,
            // navigation: {
            // 	nextEl: '.swiper-button-next',
            // 	prevEl: '.swiper-button-prev',
            // },
        });
        var thumbs = new Swiper('.testimonial-thumbs', {
            slidesPerView: 'auto',
            spaceBetween: 0,
            navigation: true,
            centeredSlides: true,
            arrows: true,
            loop: true,
            autoplay: true,
            autoplaySpeed: 3000,
            slideToClickedSlide: true,
        });
        slider.controller.control = thumbs;
        thumbs.controller.control = slider;
    }
    // if ($('.product-details .bxslider').length) {
    // 	$('.product-details .bxslider').bxSlider({
    // 		nextSelector: '.product-details #slider-next',
    // 		prevSelector: '.product-details #slider-prev',
    // 		nextText: '<i class="fa fa-angle-right"></i>',
    // 		prevText: '<i class="fa fa-angle-left"></i>',
    // 		mode: 'fade',
    // 		auto: 'true',
    // 		speed: '700',
    // 		pagerCustom: '.product-details .slider-pager .thumb-box'
    // 	});
    // };
    if ($('.product_slider').length) {
        var swiper = new Swiper(".product_slider", {
            slidesPerView: 1,
            spaceBetween: 15,
            infinite: true,
            autoplay: true,
            arrows: true,
            autoplaySpeed: 3000,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                576: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 1,
                },
                992: {
                    slidesPerView: 1,
                },
                1023: {
                    slidesPerView: 1,
                },
                1400: {
                    slidesPerView: 1,
                },
            },
        });
    }
    if ($('.dial').length) {
        $('.dial').appear(function () {
            var elm = $(this);
            var color = elm.attr('data-fgColor');
            var perc = elm.attr('value');
            elm.knob({
                'value': 0,
                'min': 0,
                'max': 100,
                'skin': 'tron',
                'readOnly': true,
                'thickness': 0.15,
                'dynamicDraw': true,
                'displayInput': false
            });
            $({
                value: 0
            }).animate({
                value: perc
            }, {
                duration: 2000,
                easing: 'swing',
                progress: function () {
                    elm.val(Math.ceil(this.value)).trigger('change');
                }
            });
            $(this).append(function () { });
        }, {
            accY: 20
        });
    }
    if ($('.accordion-box').length) {
        $(".accordion-box").on('click', '.acc-btn', function () {
            var outerBox = $(this).parents('.accordion-box');
            var target = $(this).parents('.accordion');
            if ($(this).hasClass('active') !== true) {
                $(outerBox).find('.accordion .acc-btn').removeClass('active ');
            }
            if ($(this).next('.acc-content').is(':visible')) {
                return false;
            } else {
                $(this).addClass('active');
                $(outerBox).children('.accordion').removeClass('active-block');
                $(outerBox).find('.accordion').children('.acc-content').slideUp(300);
                target.addClass('active-block');
                $(this).next('.acc-content').slideDown(300);
            }
        });
    }
    if ($('.count-box').length) {
        $('.count-box').appear(function () {
            var $t = $(this),
                n = $t.find(".count-text").attr("data-stop"),
                r = parseInt($t.find(".count-text").attr("data-speed"), 10);
            if (!$t.hasClass("counted")) {
                $t.addClass("counted");
                $({
                    countNum: $t.find(".count-text").text()
                }).animate({
                    countNum: n
                }, {
                    duration: r,
                    easing: "linear",
                    step: function () {
                        $t.find(".count-text").text(Math.floor(this.countNum));
                    },
                    complete: function () {
                        $t.find(".count-text").text(this.countNum);
                    }
                });
            }
        }, {
            accY: 0
        });
    }
    if ($('.tabs-box').length) {
        $('.tabs-box .tab-buttons .tab-btn').on('click', function (e) {
            e.preventDefault();
            var target = $($(this).attr('data-tab'));
            if ($(target).is(':visible')) {
                return false;
            } else {
                target.parents('.tabs-box').find('.tab-buttons').find('.tab-btn').removeClass('active-btn');
                $(this).addClass('active-btn');
                target.parents('.tabs-box').find('.tabs-content').find('.tab').fadeOut(0);
                target.parents('.tabs-box').find('.tabs-content').find('.tab').removeClass('active-tab animated fadeIn');
                $(target).fadeIn(300);
                $(target).addClass('active-tab animated fadeIn');
            }
        });
    }
    $(".quantity-box .add").on("click", function () {
        if ($(this).prev().val() < 999) {
            $(this).prev().val(+$(this).prev().val() + 1);
        }
    });
    $(".quantity-box .sub").on("click", function () {
        if ($(this).next().val() > 1) {
            if ($(this).next().val() > 1)
                $(this).next().val(+$(this).next().val() - 1);
        }
    });
    if ($('.price-range-slider').length) {
        $(".price-range-slider").slider({
            range: true,
            min: 10,
            max: 99,
            values: [10, 60],
            slide: function (event, ui) {
                $("input.property-amount").val(ui.values[0] + " - " + ui.values[1]);
            }
        });
        $("input.property-amount").val($(".price-range-slider").slider("values", 0) + " - $" + $(".price-range-slider").slider("values", 1));
    }
    if ($(".count-bar").length) {
        $(".count-bar").appear(function () {
            var el = $(this);
            var percent = el.data("percent");
            $(el).css("width", percent).addClass("counted");
        }, {
            accY: -50
        });
    }
    if ($('.tabs-box').length) {
        $('.tabs-box .tab-buttons .tab-btn').on('click', function (e) {
            e.preventDefault();
            var target = $($(this).attr('data-tab'));
            if ($(target).is(':visible')) {
                return false;
            } else {
                target.parents('.tabs-box').find('.tab-buttons').find('.tab-btn').removeClass('active-btn');
                $(this).addClass('active-btn');
                target.parents('.tabs-box').find('.tabs-content').find('.tab').fadeOut(0);
                target.parents('.tabs-box').find('.tabs-content').find('.tab').removeClass('active-tab animated fadeIn');
                $(target).fadeIn(300);
                $(target).addClass('active-tab animated fadeIn');
            }
        });
    }
    if ($('.progress-line').length) {
        $('.progress-line').appear(function () {
            var el = $(this);
            var percent = el.data('width');
            $(el).css('width', percent + '%');
        }, {
            accY: 0
        });
    }
    if ($('.lightbox-image').length) {
        $('.lightbox-image').fancybox({
            openEffect: 'fade',
            closeEffect: 'fade',
            helpers: {
                media: {}
            }
        });
    }
    if ($('.scroll-to-target').length) {
        $(".scroll-to-target").on('click', function () {
            var target = $(this).attr('data-target');
            $('html, body').animate({
                scrollTop: $(target).offset().top
            }, 0);
        });
    }
    if ($('.wow').length) {
        var wow = new WOW({
            boxClass: 'wow',
            animateClass: 'animated',
            offset: 0,
            mobile: false,
            live: true
        });
        wow.init();
    }
    var $onepage_nav = $('.onepage-nav');
    var $sections = $('section');
    var $window = $(window);

    function TM_activateMenuItemOnReach() {
        if ($onepage_nav.length > 0) {
            var cur_pos = $window.scrollTop() + 2;
            var nav_height = $onepage_nav.outerHeight();
            $sections.each(function () {
                var top = $(this).offset().top - nav_height - 80,
                    bottom = top + $(this).outerHeight();
                if (cur_pos >= top && cur_pos <= bottom) {
                    $onepage_nav.find('a').parent().removeClass('current').removeClass('active');
                    $sections.removeClass('current').removeClass('active');
                    $onepage_nav.find('a[href="#' + $(this).attr('id') + '"]').parent().addClass('current').addClass('active');
                }
                if (cur_pos <= nav_height && cur_pos >= 0) {
                    $onepage_nav.find('a').parent().removeClass('current').removeClass('active');
                    $onepage_nav.find('a[href="#header"]').parent().addClass('current').addClass('active');
                }
            });
        }
    }
    $(window).on('scroll', function () {
        headerStyle();
        TM_activateMenuItemOnReach();
    });
    $(window).on('load', function () {
        handlePreloader();
    });
    // if ($('.filter-list').length) {
    //     $('.filter-list').mixItUp({});
    // }
})(window.jQuery);
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('pooja-search');
    const cards = Array.from(document.querySelectorAll('.pooja-card'));
    if (input) {
    input.addEventListener('input', function() {
      const q = input.value.trim().toLowerCase();

      // If fewer than 2 chars, show all
      if (q.length < 2) {
        cards.forEach(card => {
          card.style.display = '';
        });
        return;
      }

      cards.forEach(card => {
        // Read the data attributes
        const nameEn = (card.dataset.name || '').toLowerCase();
        const nameHi = (card.dataset.nameHindi || '').toLowerCase();

        // Check match
        if (nameEn.includes(q) || nameHi.includes(q)) {
          card.style.display = '';            // show
        } else {
          card.style.display = 'none';        // hide
        }
      });
    });
}
    
  });


  document.addEventListener('DOMContentLoaded', function(){
  const slider     = document.querySelector('.package-slider .row');
  const prevBtn    = document.querySelector('.package-slider .slider-btn.prev');
  const nextBtn    = document.querySelector('.package-slider .slider-btn.next');
  const slideWidth = () => slider.clientWidth * 0.8 + 16; // flex-basis + gutter
  let autoSlideInterval;

  function slideNext() {
    if (slider) {
    slider.scrollBy({ left: slideWidth(), behavior: 'smooth' });
  }
  }
  function slidePrev() {
    if (slider) {
    slider.scrollBy({ left: -slideWidth(), behavior: 'smooth' });
  }
  }
  if (nextBtn && prevBtn) {
    nextBtn.addEventListener('click', slideNext);
    prevBtn.addEventListener('click', slidePrev);
}




  // auto-slide every 4s
  function startAutoSlide() {
    autoSlideInterval = setInterval(slideNext, 4000);
  }
  function stopAutoSlide() {
    clearInterval(autoSlideInterval);
  }
  if (slider) {
    slider.addEventListener('mouseenter', stopAutoSlide);
    slider.addEventListener('mouseleave', startAutoSlide);
}

  startAutoSlide();
});
document.addEventListener('DOMContentLoaded', function(){
    const container = document.getElementById('package-slider-bd268f');
    if (!container) return;
  
    const slider  = container.querySelector('.row');
    const prevBtn = container.querySelector('.slider-btn.prev');
    const nextBtn = container.querySelector('.slider-btn.next');
  
    // measure the width of one slide (you can also hard-code if you prefer)
    const slideWidth = () => {
      const slide = slider.querySelector('.package-content');
      const style = getComputedStyle(slide);
      return slide.clientWidth + parseFloat(style.marginRight);
    };
  
    function slideNext() {
      slider.scrollBy({ left: slideWidth(), behavior: 'smooth' });
    }
    function slidePrev() {
      slider.scrollBy({ left: -slideWidth(), behavior: 'smooth' });
    }
  
    nextBtn.addEventListener('click', slideNext);
    prevBtn.addEventListener('click', slidePrev);
  
    // auto-slide
    let autoSlide = setInterval(slideNext, 4000);
    slider.addEventListener('mouseenter', () => clearInterval(autoSlide));
    slider.addEventListener('mouseleave', () => {
      autoSlide = setInterval(slideNext, 4000);
    });
  });
  


  function ready(fn) {
    if (document.readyState !== 'loading') {
      fn();
    } else {
      document.addEventListener('DOMContentLoaded', fn);
    }
  }
  
  ready(function(){
    var filterSelect = document.getElementById('locationFilterss');
    var grid         = document.getElementById('pooja-grid');
    if (!filterSelect || !grid) return;
  
    var cards = Array.prototype.slice.call(
      grid.querySelectorAll('.pooja-card'),
      0
    );
  
    function applyFilterAndLog(){
      var chosen = filterSelect.value;
      var visible = [], hidden = [];
      cards.forEach(function(card){
        var loc = (card.getAttribute('data-location')||'').toLowerCase();
        var show = (chosen==='both' || loc===chosen || loc==='both');
        card.style.display = show ? '' : 'none';
        (show ? visible : hidden).push(card.getAttribute('data-name')||'[no-name]');
      });
      console.log('Visible:', visible.length, visible);
      console.log('Hidden:', hidden.length, hidden);
  
      if (grid.swiper && typeof grid.swiper.update === 'function') {
        grid.swiper.update();
      }
    }
  
    // Native select change
    filterSelect.addEventListener('change', applyFilterAndLog);
  
    // Select2 (jQuery) — must use jQuery .on()
    $(filterSelect).on('select2:select', applyFilterAndLog);
  
    // initial filter
    applyFilterAndLog();
  });
  
