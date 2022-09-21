(function($) {
    "use strict";
    var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    }

    /*=============================================
    Declarar funciones globales
    =============================================*/

    function parallax() {
        $('.bg--parallax').each(function() {
            var el = $(this),
                xpos = "50%",
                windowHeight = $(window).height();
            if (isMobile.any()) {
                $(this).css('background-attachment', 'scroll');
            } else {
                $(window).scroll(function() {
                    var current = $(window).scrollTop(),
                        top = el.offset().top,
                        height = el.outerHeight();
                    if (top + height < current || top > current + windowHeight) {
                        return;
                    }
                    el.css('backgroundPosition', xpos + " " + Math.round((top - current) * 0.2) + "px");
                });
            }
        });
    }

    function backgroundImage() {
        var databackground = $('[data-background]');
        databackground.each(function() {
            if ($(this).attr('data-background')) {
                var image_path = $(this).attr('data-background');
                $(this).css({
                    'background': 'url(' + image_path + ')'
                });
            }
        });
    }

    function siteToggleAction() {
        var navSidebar = $('.navigation--sidebar'),
            filterSidebar = $('.ps-filter--sidebar');
        $('.menu-toggle-open').on('click', function(e) {
            e.preventDefault();
            $(this).toggleClass('active')
            navSidebar.toggleClass('active');
            $('.ps-site-overlay').toggleClass('active');
        });

        $('.ps-toggle--sidebar').on('click', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $(this).toggleClass('active');
            $(this).siblings('a').removeClass('active');
            $(url).toggleClass('active');
            $(url).siblings('.ps-panel--sidebar').removeClass('active');
            $('.ps-site-overlay').toggleClass('active');
        });

        $('#filter-sidebar').on('click', function(e) {
            e.preventDefault();
            filterSidebar.addClass('active');
            $('.ps-site-overlay').addClass('active');
        });

        $('.ps-filter--sidebar .ps-filter__header .ps-btn--close').on('click', function(e) {
            e.preventDefault();
            filterSidebar.removeClass('active');
            $('.ps-site-overlay').removeClass('active');
        });

        $('body').on("click", function(e) {
            if ($(e.target).siblings(".ps-panel--sidebar").hasClass('active')) {
                $('.ps-panel--sidebar').removeClass('active');
                $('.ps-site-overlay').removeClass('active');
            }
        });
    }

    function subMenuToggle() {
        $('.menu--mobile .menu-item-has-children > .sub-toggle').on('click', function(e) {
            e.preventDefault();
            var current = $(this).parent('.menu-item-has-children')
            $(this).toggleClass('active');
            current.siblings().find('.sub-toggle').removeClass('active');
            current.children('.sub-menu').slideToggle(350);
            current.siblings().find('.sub-menu').slideUp(350);
            if (current.hasClass('has-mega-menu')) {
                current.children('.mega-menu').slideToggle(350);
                current.siblings('.has-mega-menu').find('.mega-menu').slideUp(350);
            }

        });
        $('.menu--mobile .has-mega-menu .mega-menu__column .sub-toggle').on('click', function(e) {
            e.preventDefault();
            var current = $(this).closest('.mega-menu__column')
            $(this).toggleClass('active');
            current.siblings().find('.sub-toggle').removeClass('active');
            current.children('.mega-menu__list').slideToggle(350);
            current.siblings().find('.mega-menu__list').slideUp(350);
        });
        var listCategories = $('.ps-list--categories');
        if (listCategories.length > 0) {
            $('.ps-list--categories .menu-item-has-children > .sub-toggle').on('click', function(e) {
                e.preventDefault();
                var current = $(this).parent('.menu-item-has-children')
                $(this).toggleClass('active');
                current.siblings().find('.sub-toggle').removeClass('active');
                current.children('.sub-menu').slideToggle(350);
                current.siblings().find('.sub-menu').slideUp(350);
                if (current.hasClass('has-mega-menu')) {
                    current.children('.mega-menu').slideToggle(350);
                    current.siblings('.has-mega-menu').find('.mega-menu').slideUp(350);
                }

            });
        }
    }

    function stickyHeader() {
        var header = $('.header'),
            scrollPosition = 0,
            checkpoint = 50;
        header.each(function() {
            if ($(this).data('sticky') === true) {
                var el = $(this);
                $(window).scroll(function() {

                    var currentPosition = $(this).scrollTop();
                    if (currentPosition > checkpoint) {
                        el.addClass('header--sticky');
                    } else {
                        el.removeClass('header--sticky');
                    }
                });
            }
        })

        var stickyCart = $('#cart-sticky');
        if (stickyCart.length > 0) {
            $(window).scroll(function() {
                var currentPosition = $(this).scrollTop();
                if (currentPosition > checkpoint) {
                    stickyCart.addClass('active');
                } else {
                    stickyCart.removeClass('active');
                }
            });
        }
    }

    function owlCarouselConfig() {
        var target = $('.owl-slider');
        if (target.length > 0) {
            target.each(function() {
                var el = $(this),
                    dataAuto = el.data('owl-auto'),
                    dataLoop = el.data('owl-loop'),
                    dataSpeed = el.data('owl-speed'),
                    dataGap = el.data('owl-gap'),
                    dataNav = el.data('owl-nav'),
                    dataDots = el.data('owl-dots'),
                    dataAnimateIn = (el.data('owl-animate-in')) ? el.data('owl-animate-in') : '',
                    dataAnimateOut = (el.data('owl-animate-out')) ? el.data('owl-animate-out') : '',
                    dataDefaultItem = el.data('owl-item'),
                    dataItemXS = el.data('owl-item-xs'),
                    dataItemSM = el.data('owl-item-sm'),
                    dataItemMD = el.data('owl-item-md'),
                    dataItemLG = el.data('owl-item-lg'),
                    dataItemXL = el.data('owl-item-xl'),
                    dataNavLeft = (el.data('owl-nav-left')) ? el.data('owl-nav-left') : "<i class='icon-chevron-left'></i>",
                    dataNavRight = (el.data('owl-nav-right')) ? el.data('owl-nav-right') : "<i class='icon-chevron-right'></i>",
                    duration = el.data('owl-duration'),
                    datamouseDrag = (el.data('owl-mousedrag') == 'on') ? true : false;
                if (target.children('div, span, a, img, h1, h2, h3, h4, h5, h5').length >= 2) {
                    el.owlCarousel({
                        animateIn: dataAnimateIn,
                        animateOut: dataAnimateOut,
                        margin: dataGap,
                        autoplay: dataAuto,
                        autoplayTimeout: dataSpeed,
                        autoplayHoverPause: true,
                        loop: dataLoop,
                        nav: dataNav,
                        mouseDrag: datamouseDrag,
                        touchDrag: true,
                        autoplaySpeed: duration,
                        navSpeed: duration,
                        dotsSpeed: duration,
                        dragEndSpeed: duration,
                        navText: [dataNavLeft, dataNavRight],
                        dots: dataDots,
                        items: dataDefaultItem,
                        responsive: {
                            0: {
                                items: dataItemXS
                            },
                            480: {
                                items: dataItemSM
                            },
                            768: {
                                items: dataItemMD
                            },
                            992: {
                                items: dataItemLG
                            },
                            1200: {
                                items: dataItemXL
                            },
                            1680: {
                                items: dataDefaultItem
                            }
                        }
                    });
                }

            });
        }
    }

    function masonry($selector) {
        var masonry = $($selector);
        if (masonry.length > 0) {
            if (masonry.hasClass('filter')) {
                masonry.imagesLoaded(function() {
                    masonry.isotope({
                        columnWidth: '.grid-sizer',
                        itemSelector: '.grid-item',
                        isotope: {
                            columnWidth: '.grid-sizer'
                        },
                        filter: "*"
                    });
                });
                var filters = masonry.closest('.masonry-root').find('.ps-masonry-filter > li > a');
                filters.on('click', function(e) {
                    e.preventDefault();
                    var selector = $(this).attr('href');
                    filters.find('a').removeClass('current');
                    $(this).parent('li').addClass('current');
                    $(this).parent('li').siblings('li').removeClass('current');
                    $(this).closest('.masonry-root').find('.ps-masonry').isotope({
                        itemSelector: '.grid-item',
                        isotope: {
                            columnWidth: '.grid-sizer'
                        },
                        filter: selector
                    });
                    return false;
                });
            } else {
                masonry.imagesLoaded(function() {
                    masonry.masonry({
                        columnWidth: '.grid-sizer',
                        itemSelector: '.grid-item'
                    });
                });
            }
        }
    }

    function mapConfig() {
        var map = $('#contact-map');
        if (map.length > 0) {
            map.gmap3({
                address: map.data('address'),
                zoom: map.data('zoom'),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                scrollwheel: false
            }).marker(function(map) {
                return {
                    position: map.getCenter(),
                    icon: 'img/marker.png',
                };
            }).infowindow({
                content: map.data('address')
            }).then(function(infowindow) {
                var map = this.get(0);
                var marker = this.get(1);
                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                });
            });
        } else {
            return false;
        }
    }

    function slickConfig() {
        var product = $('.ps-product--detail');
        if (product.length > 0) {
            var primary = product.find('.ps-product__gallery'),
                second = product.find('.ps-product__variants'),
                vertical = product.find('.ps-product__thumbnail').data('vertical');
            primary.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                asNavFor: '.ps-product__variants',
                fade: true,
                dots: false,
                infinite: false,
                arrows: primary.data('arrow'),
                prevArrow: "<a href='#'><i class='fa fa-angle-left'></i></a>",
                nextArrow: "<a href='#'><i class='fa fa-angle-right'></i></a>",
            });
            second.slick({
                slidesToShow: second.data('item'),
                slidesToScroll: 1,
                infinite: false,
                arrows: second.data('arrow'),
                focusOnSelect: true,
                prevArrow: "<a href='#'><i class='fa fa-angle-up'></i></a>",
                nextArrow: "<a href='#'><i class='fa fa-angle-down'></i></a>",
                asNavFor: '.ps-product__gallery',
                vertical: vertical,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            arrows: second.data('arrow'),
                            slidesToShow: 4,
                            vertical: false,
                            prevArrow: "<a href='#'><i class='fa fa-angle-left'></i></a>",
                            nextArrow: "<a href='#'><i class='fa fa-angle-right'></i></a>"
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            arrows: second.data('arrow'),
                            slidesToShow: 4,
                            vertical: false,
                            prevArrow: "<a href='#'><i class='fa fa-angle-left'></i></a>",
                            nextArrow: "<a href='#'><i class='fa fa-angle-right'></i></a>"
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 3,
                            vertical: false,
                            prevArrow: "<a href='#'><i class='fa fa-angle-left'></i></a>",
                            nextArrow: "<a href='#'><i class='fa fa-angle-right'></i></a>"
                        }
                    },
                ]
            });
        }
    }

    function tabs() {
        $('.ps-tab-list  li > a ').on('click', function(e) {
            e.preventDefault();
            var target = $(this).attr('href');
            $(this).closest('li').siblings('li').removeClass('active');
            $(this).closest('li').addClass('active');
            $(target).addClass('active');
            $(target).siblings('.ps-tab').removeClass('active');
        });
        $('.ps-tab-list.owl-slider .owl-item a').on('click', function(e) {
            e.preventDefault();
            var target = $(this).attr('href');
            $(this).closest('.owl-item').siblings('.owl-item').removeClass('active');
            $(this).closest('.owl-item').addClass('active');
            $(target).addClass('active');
            $(target).siblings('.ps-tab').removeClass('active');
        });
    }

    function rating() {
        $('select.ps-rating').each(function() {
            var readOnly;
            if ($(this).attr('data-read-only') == 'true') {
                readOnly = true
            } else {
                readOnly = false;
            }
            $(this).barrating({
                theme: 'fontawesome-stars',
                readonly: readOnly,
                emptyValue: '0'
            });
        });
    }

    function productLightbox() {
        var product = $('.ps-product--detail');
        if (product.length > 0) {
            $('.ps-product__gallery').lightGallery({
                selector: '.item a',
                thumbnail: true,
                share: false,
                fullScreen: false,
                autoplay: false,
                autoplayControls: false,
                actualSize: false
            });
            if (product.hasClass('ps-product--sticky')) {
                $('.ps-product__thumbnail').lightGallery({
                    selector: '.item a',
                    thumbnail: true,
                    share: false,
                    fullScreen: false,
                    autoplay: false,
                    autoplayControls: false,
                    actualSize: false
                });
            }
        }
        $('.ps-gallery--image').lightGallery({
            selector: '.ps-gallery__item',
            thumbnail: true,
            share: false,
            fullScreen: false,
            autoplay: false,
            autoplayControls: false,
            actualSize: false
        });
        $('.ps-video').lightGallery({
            thumbnail: false,
            share: false,
            fullScreen: false,
            autoplay: false,
            autoplayControls: false,
            actualSize: false
        });
    }

    function backToTop() {
        var scrollPos = 0;
        var element = $('#back2top');
        $(window).scroll(function() {
            var scrollCur = $(window).scrollTop();
            if (scrollCur > scrollPos) {
                // scroll down
                if (scrollCur > 500) {
                    element.addClass('active');
                } else {
                    element.removeClass('active');
                }
            } else {
                // scroll up
                element.removeClass('active');
            }

            scrollPos = scrollCur;
        });

        element.on('click', function() {
            $('html, body').animate({
                scrollTop: '0px'
            }, 800);
        });
    }

    function filterSlider() {
        var el = $('.ps-slider');
        var min = el.siblings().find('.ps-slider__min');
        var max = el.siblings().find('.ps-slider__max');
        var defaultMinValue = el.data('default-min');
        var defaultMaxValue = el.data('default-max');
        var maxValue = el.data('max');
        var step = el.data('step');
        if (el.length > 0) {
            el.slider({
                min: 0,
                max: maxValue,
                step: step,
                range: true,
                values: [defaultMinValue, defaultMaxValue],
                slide: function(event, ui) {
                    var values = ui.values;
                    min.text('$' + values[0]);
                    max.text('$' + values[1]);
                }
            });
            var values = el.slider("option", "values");
            min.text('$' + values[0]);
            max.text('$' + values[1]);
        } else {
            // return false;
        }
    }

    function modalInit() {
        var modal = $('.ps-modal');
        if (modal.length) {
            if (modal.hasClass('active')) {
                $('body').css('overflow-y', 'hidden');
            }
        }
        modal.find('.ps-modal__close, .ps-btn--close').on('click', function(e) {
            e.preventDefault();
            $(this).closest('.ps-modal').removeClass('active');
        });
        $('.ps-modal-link').on('click', function(e) {
            e.preventDefault();
            var target = $(this).attr('href');
            $(target).addClass('active');
            $("body").css('overflow-y', 'hidden');
        });
        $('.ps-modal').on("click", function(event) {
            if (!$(event.target).closest(".ps-modal__container").length) {
                modal.removeClass('active');
                $("body").css('overflow-y', 'auto');
            }
        });
    }

    function searchInit() {
        var searchbox = $('.ps-search');
        $('.ps-search-btn').on('click', function(e) {
            e.preventDefault();
            searchbox.addClass('active');
        });
        searchbox.find('.ps-btn--close').on('click', function(e) {
            e.preventDefault();
            searchbox.removeClass('active');
        });
    }

    function countDown() {
        var time = $(".ps-countdown");
        time.each(function() {
            var el = $(this),
                value = $(this).data('time');
            var countDownDate = new Date(value).getTime();
            var timeout = setInterval(function() {
                var now = new Date().getTime(),
                    distance = countDownDate - now;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24)),
                    hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
                    minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)),
                    seconds = Math.floor((distance % (1000 * 60)) / 1000);
                el.find('.days').html(days);
                el.find('.hours').html(hours);
                el.find('.minutes').html(minutes);
                el.find('.seconds').html(seconds);
                if (distance < 0) {
                    clearInterval(timeout);
                    el.closest('.ps-section').hide();
                }
            }, 1000);
        });
    }

    function productFilterToggle() {
        $('.ps-filter__trigger').on('click', function(e) {
            e.preventDefault();
            var el = $(this);
            el.find('.ps-filter__icon').toggleClass('active');
            el.closest('.ps-filter').find('.ps-filter__content').slideToggle();
        });
        if ($('.ps-sidebar--home').length > 0) {
            $('.ps-sidebar--home > .ps-sidebar__header > a').on('click', function(e) {
                e.preventDefault();
                $(this).closest('.ps-sidebar--home').children('.ps-sidebar__content').slideToggle();
            })
        }
    }

    function mainSlider() {
        var homeBanner = $('.ps-carousel--animate');
        homeBanner.slick({
            autoplay: true,
            speed: 1000,
            lazyLoad: 'progressive',
            arrows: false,
            fade: true,
            dots: true,
            prevArrow: "<i class='slider-prev ba-back'></i>",
            nextArrow: "<i class='slider-next ba-next'></i>"
        });
    }

    function subscribePopup() {
        var subscribe = $('#subscribe'),
            time = subscribe.data('time');
        setTimeout(function() {
            if (subscribe.length > 0) {
                subscribe.addClass('active');
                $('body').css('overflow', 'hidden');
            }
        }, time);
        $('.ps-popup__close').on('click', function(e) {
            e.preventDefault();
            $(this).closest('.ps-popup').removeClass('active');
            $('body').css('overflow', 'auto');
        });
        $('#subscribe').on("click", function(event) {
            if (!$(event.target).closest(".ps-popup__content").length) {
                subscribe.removeClass('active');
                $("body").css('overflow-y', 'auto');
            }
        });
    }

    function stickySidebar() {
        var sticky = $('.ps-product--sticky'),
            stickySidebar, checkPoint = 992,
            windowWidth = $(window).innerWidth();
        if (sticky.length > 0) {
            stickySidebar = new StickySidebar('.ps-product__sticky .ps-product__info', {
                topSpacing: 20,
                bottomSpacing: 20,
                containerSelector: '.ps-product__sticky',
            });
            if ($('.sticky-2').length > 0) {
                var stickySidebar2 = new StickySidebar('.ps-product__sticky .sticky-2', {
                    topSpacing: 20,
                    bottomSpacing: 20,
                    containerSelector: '.ps-product__sticky',
                });
            }
            if (checkPoint > windowWidth) {
                stickySidebar.destroy();
                stickySidebar2.destroy();
            }
        } else {
            return false;
        }
    }

    function accordion() {
        var accordion = $('.ps-accordion');
        accordion.find('.ps-accordion__content').hide();
        $('.ps-accordion.active').find('.ps-accordion__content').show();
        accordion.find('.ps-accordion__header').on('click', function(e) {
            e.preventDefault();
            if ($(this).closest('.ps-accordion').hasClass('active')) {
                $(this).closest('.ps-accordion').removeClass('active');
                $(this).closest('.ps-accordion').find('.ps-accordion__content').slideUp(350);

            } else {
                $(this).closest('.ps-accordion').addClass('active');
                $(this).closest('.ps-accordion').find('.ps-accordion__content').slideDown(350);
                $(this).closest('.ps-accordion').siblings('.ps-accordion').find('.ps-accordion__content').slideUp();
            }
            $(this).closest('.ps-accordion').siblings('.ps-accordion').removeClass('active');
            $(this).closest('.ps-accordion').siblings('.ps-accordion').find('.ps-accordion__content').slideUp();
        });
    }

    function progressBar() {
        var progress = $('.ps-progress');
        progress.each(function(e) {
            var value = $(this).data('value');
            $(this).find('span').css({
                width: value + "%"
            })
        });
    }

    function customScrollbar() {
        $('.ps-custom-scrollbar').each(function() {
            var height = $(this).data('height');
            $(this).slimScroll({
                height: height + 'px',
                alwaysVisible: true,
                color: '#000000',
                size: '6px',
                railVisible: true,
            });
        })
    }

    function select2Cofig() {
        $('select.ps-select').select2({
            placeholder: $(this).data('placeholder'),
            minimumResultsForSearch: -1
        });

        $('.select2').select2();
    }

    function carouselNavigation() {
        var prevBtn = $('.ps-carousel__prev'),
            nextBtn = $('.ps-carousel__next');
        prevBtn.on('click', function(e) {
            e.preventDefault();
            var target = $(this).attr('href');
            $(target).trigger('prev.owl.carousel', [1000]);
        });
        nextBtn.on('click', function(e) {
            e.preventDefault();
            var target = $(this).attr('href');
            $(target).trigger('next.owl.carousel', [1000]);
        });
    }

    function dateTimePicker() {
        $('.ps-datepicker').datepicker();
    }

    /*=============================================
    Función de paginación
    =============================================*/

    function pagination(){

        var target = $('.pagination');

        if(target.length > 0){

            target.each(function() {

                var el = $(this),
                    totalPages = el.data("total-pages"),
                    currentPage = el.data("current-page"),
                    urlPage = el.data("url-page");

                el.twbsPagination({

                    totalPages: totalPages,
                    startPage: currentPage,
                    visiblePages: 3,
                    first: '<i class="fas fa-angle-double-left"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>',
                    prev: '<i class="fas fa-angle-left"></i>',
                    next: '<i class="fas fa-angle-right"></i>'

                }).on("page", function(evt, page){

                    if(urlPage.includes("&",1)){

                        urlPage = urlPage.replace("&"+currentPage, "&"+page);
                        window.location = urlPage+"#showcase";

                    }else{

                        window.location = urlPage+"&"+page+"#showcase";
                    }    

                })

            })

        }

    }

    /*=============================================
    Función Preload
    =============================================*/

    function preload(){

        var preloadFalse = $(".preloadFalse");
        var preloadTrue = $(".preloadTrue");

        if(preloadFalse.length > 0){

            preloadFalse.each(function(i){

                var el = $(this);

                $(el).ready(function(){

                    $(preloadTrue[i]).remove();
                    $(el).css({"opacity":1,"height":"auto"})

                })

            })

        }
    }

    /*=============================================
    Validación Bootstrap 4
    =============================================*/

    function validateBS4(){

        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Get the forms we want to add validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
                });
            }, false);
        })();

    }

    /*=============================================
    Capturar email login
    =============================================*/
    function rememberLogin(){

        if(localStorage.getItem("emailRem") != null){

            $('[name="loginEmail"]').val(localStorage.getItem("emailRem"));

        }

        if(localStorage.getItem("checkRem") != null && localStorage.getItem("checkRem")){

            $('#remember-me').attr("checked", true);

        }

    }

    /*=============================================
    Datatable
    =============================================*/
    function dataTable(){

        /*=============================================
        Datatable Lado Cliente
        =============================================*/

        var targetClient = $('.dt-responsive.dt-client');

        if(targetClient.length > 0){

            $(targetClient).DataTable({

                "order":[]

            });

        }

        /*=============================================
        Datatable Lado Servidor para órdenes
        =============================================*/

        var targetServerOrders = $('.dt-responsive.dt-server-orders');

        if(targetServerOrders.length > 0){

            $(targetServerOrders).DataTable({

                "processing":true,
                "serverSide": true,
                "ajax":{
                    "url": $("#path").val()+"ajax/data-orders.php?idStore="+$("#idStore").val()+"&token="+localStorage.getItem("token_user"),
                    "type": "POST"
                },
                "columns": [

                    { "data": "id_order" },
                    { "data": "status_order"},
                    { "data": "displayname_user"},
                    { "data": "email_order" },
                    { "data": "country_order" },
                    { "data": "city_order" },
                    { "data": "address_order", "orderable": false  },
                    { "data": "phone_order", "orderable": false  },
                    { "data": "name_product" },
                    { "data": "quantity_order" },
                    { "data": "details_order", "orderable": false  },
                    { "data": "price_order" },
                    { "data": "process_order", "orderable": false  },
                    { "data": "date_created_order" }

                ]

            });

        }


    }

    /*=============================================
    Summernote
    =============================================*/

    function summer(){

        var target = $('.summernote');

        if(target.length > 0){

            $(target).summernote({

                placeholder:'',
                tabsize: 2,
                height: 400,
                toolbar:[
                    ['misc', ['codeview', 'undo', 'redo']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['style', 'ul', 'ol', 'paragraph', 'height']],
                    ['insert', ['link','picture', 'hr']]
                ]

            });

        }

    }

    /*=============================================
    Editar contenido de Summernote
    =============================================*/

    function editSummer(){

        var target = $('.editSummernote');

        if(target.length > 0){

            target.each(function(i){

                var el = $(this);

                $(el).ready(function(){

                    var settings = {

                        "url": $("#urlApi").val()+"products?linkTo=id_product&equalTo="+$(el).attr("idProduct")+"&select=description_product",
                        "method": "GET",
                        "timeout": 0,
                    };

                    /*=============================================
                    Cuando la petición de AJAX devuelve coincidencia
                    =============================================*/

                    $.ajax(settings).done(function (response) {

                        if(response.status == 200){

                            $(el).summernote('pasteHTML', response.results[0].description_product);

                        }

                    });

                })


            })

        }

    }

    /*=============================================
    Share
    =============================================*/

    function share(){

        var target = $('.social-share');

        if(target.length > 0){

            $(target).shapeShare();

        }

    }

    /*=============================================
    Ejecutar funciones globales
    =============================================*/

    $(function() {
        backgroundImage();
        owlCarouselConfig();
        siteToggleAction();
        subMenuToggle();
        masonry('.ps-masonry');
        productFilterToggle();
        tabs();
        slickConfig();
        productLightbox();
        rating();
        backToTop();
        stickyHeader();
        filterSlider();
        mapConfig();
        modalInit();
        searchInit();
        countDown();
        mainSlider();
        parallax();
        stickySidebar();
        accordion();
        progressBar();
        customScrollbar();
        select2Cofig();
        carouselNavigation();
        dateTimePicker();
        $('[data-toggle="tooltip"]').tooltip();
        pagination();
        preload();
        validateBS4();
        rememberLogin();
        dataTable();
        summer();
        editSummer();
        share();
    });

    $(window).on('load', function() {
        $('body').addClass('loaded');
        // subscribePopup();
    });

    $.scrollUp({
        scrollText:'',
        scrollSpeed: 1000
    })

})(jQuery);














/*========================================================================================================
	TODO: ==========================================================================================
=========================================================================================================*/















/*=====================================================
	TODO: Función para ordenar productos
======================================================*/

function sortProduct(event){

    var url = event.target.value.split("+")[0];
    var sort = event.target.value.split("+")[1];
    var endUrl = url.split("&")[0];
    window.location = endUrl+"&1&"+sort+"#showcase";

}

/*=====================================================
	TODO: Función para crear Cookies en JS
======================================================*/

function setCookie(name, value, exp){

    var now = new Date();

    now.setTime(now.getTime() + (exp*24*60*60*1000));

    var expDate = "expires="+now.toUTCString();

    document.cookie = name + "=" +value+"; "+expDate;

}

/*=========================================================================
	TODO: Función para almacenar en cookie la tabulación de la vitrina
==========================================================================*/

$(document).on("click",".ps-tab-list li", function(){

    setCookie("tab", $(this).attr("type"), 1);

})

/*=====================================================
	TODO: Función para buscar productos
======================================================*/

$(document).on("click", ".btnSearch", function(){

    var path = $(this).attr("path");
    var search = $(this).parent().children(".inputSearch").val().toLowerCase();
    var match = /^[a-z0-9ñÑáéíóú ]*$/;

    if(match.test(search)){

        var searchTest = search.replace(/[ ]/g, "_");
        searchTest = searchTest.replace(/[ñ]/g, "n");
        searchTest = searchTest.replace(/[á]/g, "a");
        searchTest = searchTest.replace(/[é]/g, "e");
        searchTest = searchTest.replace(/[í]/g, "i");
        searchTest = searchTest.replace(/[ó]/g, "o");
        searchTest = searchTest.replace(/[ú]/g, "u");

        window.location = path+searchTest;

    }else{

        $(this).parent().children(".inputSearch").val("");

    }

})

/*=====================================================
	TODO: Función para buscar con la tecla ENTER
======================================================*/

var inputSearch = $(".inputSearch");
var btnSearch = $(".btnSearch");

for(let i = 0; i < inputSearch.length; i++){

    $(inputSearch[i]).keyup(function(event) {

        event.preventDefault();

        if(event.keyCode == 13 && $(inputSearch[i]).val() != ""){

            var path =  $(btnSearch[i]).attr("path");
            var search = $(this).val().toLowerCase();
            var match = /^[a-z0-9ñÑáéíóú ]*$/;

            if(match.test(search)){

                var searchTest = search.replace(/[ ]/g, "_");
                searchTest = searchTest.replace(/[ñ]/g, "n");
                searchTest = searchTest.replace(/[á]/g, "a");
                searchTest = searchTest.replace(/[é]/g, "e");
                searchTest = searchTest.replace(/[í]/g, "i");
                searchTest = searchTest.replace(/[ó]/g, "o");
                searchTest = searchTest.replace(/[ú]/g, "u");

                window.location = path+searchTest;

            }else{

                $(this).val("");

            }


        }


    })

}

/*=====================================================
	TODO: Función para cambiar la cantidad
======================================================*/

function changeQuantity(quantity, move, stock, index){

    var number = 1;

    if(Number(quantity) > stock-1){

        quantity = stock-1;

    }

    if(move == "up"){

        number = Number(quantity)+1;

    }

    if(move == "down" && Number(quantity) > 1){

        number = Number(quantity)-1;
    }

    $("#quant"+index).val(number);

    $("[quantitySC]").attr("quantitySC", number);

    totalP(index);

}

/*==================================================
    TODO: Función para validar data repetida
==================================================*/

function validateRepeat(event, type, table, suffix) {

    var data = new FormData();
    data.append("data", event.target.value);
    data.append("table", table);
    data.append("suffix", suffix);

    $.ajax({
        url: "../ajax/ajax-validate.php",
        method: "POST",
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {

            if (response == 200) {

                event.target.value = "";
                $(event.target).parent().addClass("was-validated");
                $(event.target).parent().children(".invalid-feedback").html("El dato escrito ya existe en la base de datos");

            } else {

                validateJS(event, type);

                if (table == "categories" || table == "subcategories" || table == "products") {

                    createUrl(event, "url-" + suffix);

                }

            }

        }

    })

}

/*=====================================================
	TODO: Función para validar formulario
======================================================*/

function validateJS(event, type){

    /*=============================================
    Validamos texto
    =============================================*/

    if(type == "text"){

        var pattern = /^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/;

        if(!pattern.test(event.target.value)){

            $(event.target).parent().addClass("was-validated");

            $(event.target).parent().children(".invalid-feedback").html("No utilice números ni caracteres especiales.");

            event.target.value = "";

            return;

        }

    }

    /*=============================================
    Validamos texto y números
    =============================================*/

    if(type == "text&number"){

        var pattern = /^[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/;

        if(!pattern.test(event.target.value)){

            $(event.target).parent().addClass("was-validated");

            $(event.target).parent().children(".invalid-feedback").html("No utilice caracteres especiales.");

            event.target.value = "";

            return;

        }

    }

    /*=============================================
    Validamos email
    =============================================*/

    if(type == "email"){

        var pattern = /^[^0-9][.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/;

        if(!pattern.test(event.target.value)){

            $(event.target).parent().addClass("was-validated");

            $(event.target).parent().children(".invalid-feedback").html("El correo electrónico está mal escrito.");

            event.target.value = "";

            return;

        }

    }

    /*=============================================
    Validamos contraseña
    =============================================*/

    if(type == "password"){

        var pattern = /^[#\\=\\$\\;\\*\\_\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-Z]{1,}$/;

        if(!pattern.test(event.target.value)){

            $(event.target).parent().addClass("was-validated");

            $(event.target).parent().children(".invalid-feedback").html("La contraseña está mal escrita.");

            event.target.value = "";

            return;

        }

    }

    /*=============================================
    Validamos teléfono
    =============================================*/

    if(type == "phone"){

        var pattern = /^[-\\(\\)\\0-9 ]{1,}$/;

        if(!pattern.test(event.target.value)){

            $(event.target).parent().addClass("was-validated");

            $(event.target).parent().children(".invalid-feedback").html("El teléfono está mal escrito.");

            event.target.value = "";

            return;

        }

    }

    /*=============================================
    Validamos párrafos
    =============================================*/

    if(type == "paragraphs"){

        var pattern = /^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/;

        if(!pattern.test(event.target.value)){

            $(event.target).parent().addClass("was-validated");

            $(event.target).parent().children(".invalid-feedback").html("La entrada está mal escrita.");

            event.target.value = "";

            return;

        }

    }

    /*=============================================
    Validamos número
    =============================================*/

    if(type == "numbers"){

        var pattern = /^[.\\,\\0-9]{1,}$/;

        if(!pattern.test(event.target.value)){

            $(event.target).parent().addClass("was-validated");

            $(event.target).parent().children(".invalid-feedback").html("La entrada está mal escrita.");

            event.target.value = "";

            return;

        }

    }

}

/*=====================================================
	TODO: Validamos imagen
======================================================*/

function validateImageJS(event, input){

    var image = event.target.files[0];

    /*=============================================
    Validamos el formato
    =============================================*/

    if(image["type"] !== "image/jpeg" && image["type"] !== "image/png"){

        fncSweetAlert("error", "La imagen debe estar en formato JPG o PNG.", null)

        return;
    }

    /*=============================================
    Validamos el tamaño
    =============================================*/

    else if(image["size"] > 2000000){

        fncSweetAlert("error", "La imagen no debe pesar más de 2MB", null)

        return;

    }

    /*=============================================
    Mostramos la imagen temporal
    =============================================*/

    else{

        var data = new FileReader();
        data.readAsDataURL(image);

        $(data).on("load", function(event){

            var path = event.target.result;

            $("."+input).attr("src", path);

        })

    }

}

/*=====================================================
	TODO: Función para recordar email en el login
======================================================*/

function remember(event){

    if(event.target.checked){

        localStorage.setItem("emailRem", $('[name="loginEmail"]').val());
        localStorage.setItem("checkRem", true);

    }else{

        localStorage.removeItem("emailRem");
        localStorage.removeItem("checkRem");

    }

}

/*=============================================================
	TODO: Función para agregar productos a la lista de deseos
==============================================================*/

function addWishlist(urlProduct, urlApi, idUser, currentUrl, urlDomain){

    if(idUser != 0){
    /*=============================================
    Validamos que el usuario esté autenticado
    =============================================*/
    if(localStorage.getItem("token_customer") != null){

        let datos = {"urlProduct":urlProduct,"urlApi":urlApi,"idUser":idUser,"function":"addwhislist","token":localStorage.getItem("token_customer")};

        var settings = {
            "url": '../controllers/wishlist.controller.php',
            "method": "GET",
            "data":datos
        };

        $.ajax(settings).done(function (response) {

            var porciones = currentUrl.split('/');

            if(response == 200){
                fncSweetAlert(
                    "success",
                    "El producto fue agregado a la lista de deseos",
                    urlDomain + porciones[1]
                )
            }
            else if(response == 400){
                fncSweetAlert(
                    "error",
                    "El producto no se agrego, intentalo nuevamente",
                )
            }
            else{
                fncSweetAlert(
                    "error",
                    "El producto ya fue agregado con anterioridad",
                )
            }

        })

        }else{

        fncNotie(3,"El usuario debe estar logueado.");
        }
    }else
    {
    fncNotie(3,"El usuario debe estar logueado.");
    }

}

/*================================================================
	TODO: Función para agregar dos productos a la lista de deseos
=================================================================*/

function addWishlist2(urlProduct1, urlProduct2, urlApi, idUser, currentUrl, urlDomain){

    if(idUser != 0){
        addWishlist(urlProduct1, urlApi, idUser, currentUrl, urlDomain);

        setTimeout(function(){

            addWishlist(urlProduct2, urlApi, idUser, currentUrl, urlDomain);

        },1000)

    }
    else
    {
        fncNotie(3,"El usuario debe estar logueado.");
    }
}

/*=====================================================================
	TODO: Función para remover productos de la lista de deseos
======================================================================*/

function removeWishlist(urlProduct, urlApi, urlDomain, idUser){

    fncSweetAlert("confirm","¿Está seguro de eliminar este elemento?","").then(resp=>{

        if(resp){

            let datos = {"urlProduct":urlProduct,"urlApi":urlApi,"idUser":idUser,"function":"removewishlist","token":localStorage.getItem("token_customer"),"urlDomain":urlDomain};

                var settings = {
                    "url": '../controllers/wishlist.controller.php',
                    "method": "GET",
                    "data":datos
                };

                $.ajax(settings).done(function (response) {

                    if(response == 200){
                        fncSweetAlert(
                            "success",
                            "El producto fue elimido de la lista de deseos",
                            urlDomain+"account&wishlist"
                        )
                    }else{
                        fncSweetAlert(
                            "error",
                            "El producto no fue removido de la lista de deseos",
                            urlDomain+"account&wishlist"
                        )
                    }
                })

        }

    })

}

/*=====================================================================
	TODO: Función para adicionar productos al carrito de compras
======================================================================*/

function addShoppingCart(urlProduct, urlApi, currentUrl, tag){

    /*=============================================
    Traer información del producto
    =============================================*/

    var select = "stock_product";

    var settings = {
        "url": urlApi+"products?linkTo=url_product&equalTo="+urlProduct+"&select="+select,
        "method": "GET",
        "timeout": 0
    }

    $.ajax(settings).done(function (response) {

        if(response.status == 200){

            /*=============================================
            Preguntamos primero que el producto tenga stock
            =============================================*/

            if(response.results[0].stock_product == 0){

                fncSweetAlert(
                    "error",
                    "No hay Stock",
                    ""
                )

                return;

            }

            /*=============================================
            Validamos existencia de cantidad
            =============================================*/

            if(tag.getAttribute("quantitySC") != ""){

                var quantity = tag.getAttribute("quantitySC");

            }else{

                var quantity = 1;
            }

            /*=============================================
            Preguntar si la Cookie ya existe
            =============================================*/

            var myCookies = document.cookie;
            var listCookies = myCookies.split(";");
            var count = 0;

            for(const i in listCookies){

                list = listCookies[i].search("listSC");

                /*=============================================
                Si list es superior a -1 es porque encontró la cookie
                =============================================*/

                if(list > -1){

                    count--

                    var arrayListSC = JSON.parse(listCookies[i].split("=")[1]);

                }else{

                    count++
                }

            }


            /*=============================================
            Trabajamos sobre la cookie que ya existe
            =============================================*/

            if(count != listCookies.length){

                if(arrayListSC != undefined){

                    /*=============================================
                    Preguntar si el producto se repite
                    =============================================*/

                    var count = 0;
                    var index = null;

                    for(const i in arrayListSC){

                        if(arrayListSC[i].product == urlProduct ){

                            count--
                            index = i;

                        }else{

                            count++
                        }

                    }

                    if(count == arrayListSC.length){

                        arrayListSC.push({

                            "product": urlProduct,
                            "quantity": quantity

                        })

                    }else{

                        arrayListSC[index].quantity += quantity;

                    }

                    /*=============================================
                    Creamos la cookie
                    =============================================*/

                    setCookie("listSC", JSON.stringify(arrayListSC), 1);

                    fncSweetAlert(
                        "success",
                        "Producto añadido al carrito de compra.",
                        currentUrl
                    )

                }

            }else{

                /*=============================================
                Creamos la cookie
                =============================================*/

                var arrayListSC = [];

                arrayListSC.push({

                    "product": urlProduct,
                    "quantity": quantity

                })

                setCookie("listSC", JSON.stringify(arrayListSC), 1);

                fncSweetAlert(
                    "success",
                    "Producto añadido al carrito de compra.",
                    currentUrl
                )

            }

        }

    })

}

/*=====================================================================
	TODO: Función para remover productos del carrito de compras
======================================================================*/

function removeSC(urlProduct, currentUrl){

    fncSweetAlert("confirm","¿Está seguro de eliminar este producto?","").then(resp=>{

        if(resp){

            /*=============================================
            Preguntar si la Cookie ya existe
            =============================================*/

            var myCookies = document.cookie;
            var listCookies = myCookies.split(";");
            var count = 0;

            for(const i in listCookies){

                list = listCookies[i].search("listSC");

                /*=============================================
                Si list es superior a -1 es porque encontró la cookie
                =============================================*/

                if(list > -1){

                    count--

                    var arrayListSC = JSON.parse(listCookies[i].split("=")[1]);

                }else{

                    count++
                }

            }


            /*=============================================
            Trabajamos sobre la cookie que ya existe
            =============================================*/

            if(count != listCookies.length){

                if(arrayListSC != undefined){

                    arrayListSC.forEach((list, index)=>{

                        if(list.product == urlProduct){

                            arrayListSC.splice(index, 1);

                        }

                    })

                    setCookie("listSC", JSON.stringify(arrayListSC), 1);

                    fncSweetAlert(
                        "success",
                        "Producto eliminado del carrito de compra",
                        currentUrl
                    )

                }

            }
        }

    })

}

/*=====================================================================
	TODO: Función para agregar dos productos al carrito de compras
======================================================================*/

function addShoppingCart2(urlProduct1, urlProduct2, urlApi, currentUrl, tag){

    addShoppingCart(urlProduct1, urlApi, currentUrl, tag);

    setTimeout(function(){

        addShoppingCart(urlProduct2, urlApi, currentUrl, tag);

    },1000)

}

/*=====================================================================
	TODO: Definir el subtotal y total del carrito de compras
======================================================================*/

var price = $(".ps-product__price span");
var quantity = $(".quantity input");
var subtotal = $(".subtotal");
var totalPrice = $(".totalPrice span");
var listSC = $(".listSC");

function totalP(){

    var total = 0;

    var arrayListSC = [];

    if(price.length > 0){

        price.each(function(i) {

            /*=============================================
            Calculando los subtotales
            =============================================*/

            let sub = (Number($(price[i]).html())*Number($(quantity[i]).val()));
            total += sub;

            $(subtotal[i]).html(sub.toFixed(2));

            /*=============================================
            Definir lo que actualizaremos en la Cookie
            =============================================*/

            arrayListSC.push({

                "product": $(listSC[i]).attr("url"),
                /* "quantity": $(quantity[i]).val() */
                "quantity": $(quantity[i]).val()

            })

        })

        /*=============================================
        Calculando el total
        =============================================*/

        $(totalPrice).html(total.toFixed(2));

        /*=============================================
        Actualizando la cookie del carrito de compras
        =============================================*/

        setCookie("listSC", JSON.stringify(arrayListSC), 1);

    }

}

totalP(null);

/*=====================================================
	TODO: Agregar codigo telefónico
======================================================*/

function changeCountry(event){

    $(".dialCode").html(event.target.value.split("_")[1]);

}

/*=====================================================
	TODO: Capturamos el método de pago
======================================================*/

var methodPaid = $('[name="payment-method"]').val();

function changeMethodPaid(event){

    methodPaid = event.target.value;
}

/*=====================================================
	TODO: Capturar el total de la transacción
======================================================*/

var total = $(".totalOrder").attr("total");

/*=========================================================================================================================================================*/

/*=====================================================
	TODO: Dar formato a fecha
======================================================*/

function formatDate(date){

    var day = date.getDate();
    var month = date.getMonth()+1;
    var year = date.getFullYear();

    return year + '-' + month + '-' + day;

}

/*=====================================================================
	TODO: Mover el scroll hasta terminos y condiciones
=====================================================================*/

function goTerms(){

    $("html, body").animate({

        scrollTop: $("#tabContent").offset().top-50

    })

}

/*=====================================================
	TODO: Función para cambiar de idioma
======================================================*/

function changeLang(lang){

    localStorage.setItem("yt-widget",`{"lang":"${lang}","active":true}`);

    window.open(window.location.href, '_top');

}
