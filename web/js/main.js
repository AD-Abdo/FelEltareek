(function($) {
    "use strict";

    jQuery(".navbar .navbar-nav li a, .main-banner-content .btn-primary").on("click", function(e) {
        var anchor = $(this);
        $("html, body")
            .stop()
            .animate({ scrollTop: $(anchor.attr("href")).offset().top - 50 }, 50);
        e.preventDefault();
    });
    jQuery(document).on("click", ".navbar-collapse.in", function(e) {
        if (jQuery(e.target).is("a") && jQuery(e.target).attr("class") != "dropdown-toggle") {
            $(this).collapse("hide");
        }
    });
    jQuery(".navbar .navbar-nav li a").on("click", function() {
        jQuery(".navbar-collapse").collapse("hide");
    });
    jQuery(window).on("scroll", function() {
        if (jQuery(this).scrollTop() > 170) {
            jQuery(".navbar").addClass("is-sticky");
        } else {
            jQuery(".navbar").removeClass("is-sticky");
        }
    });
    $(".services-slides").owlCarousel({
        loop: true,
        autoplay: true,
        nav: true,
        rtl: true,
        margin: 30,
        mouseDrag: true,
        autoplayHoverPause: true,
        responsiveClass: true,
        dots: false,
        navText: ["<i class='icofont-curved-double-left'></i>", "<i class='icofont-curved-double-right'></i>"],
        responsive: { 0: { items: 1 }, 768: { items: 2 }, 1024: { items: 3 }, 1200: { items: 3 } },
    });
    (function($) {
        $(".tab ul.tabs").addClass("active").find("> li:eq(0)").addClass("current");
        $(".tab ul.tabs li a").on("click", function(g) {
            var tab = $(this).closest(".tab"),
                index = $(this).closest("li").index();
            tab.find("ul.tabs > li").removeClass("current");
            $(this).closest("li").addClass("current");
            tab.find(".tab_content")
                .find("div.tabs_item")
                .not("div.tabs_item:eq(" + index + ")")
                .slideUp();
            tab.find(".tab_content")
                .find("div.tabs_item:eq(" + index + ")")
                .slideDown();
            g.preventDefault();
        });
    })(jQuery);
    $(".team-slides").owlCarousel({
        loop: true,
        autoplay: true,
        nav: true,
        rtl: true,
        margin: 30,
        mouseDrag: true,
        autoplayHoverPause: true,
        responsiveClass: true,
        dots: false,
        navText: ["<i class='icofont-curved-double-left'></i>", "<i class='icofont-curved-double-right'></i>"],
        responsive: { 0: { items: 1 }, 768: { items: 2 }, 1024: { items: 3 }, 1200: { items: 4 } },
    });
    $(".features-slides").owlCarousel({
        loop: true,
        autoplay: true,
        nav: true,
        rtl: true,
        margin: 30,
        mouseDrag: true,
        autoplayHoverPause: true,
        responsiveClass: true,
        dots: false,
        navText: ["<i class='icofont-curved-double-left'></i>", "<i class='icofont-curved-double-right'></i>"],
        responsive: { 0: { items: 1 }, 768: { items: 2 }, 1024: { items: 3 }, 1200: { items: 4 } },
    });
    $(".testimonials-slides").owlCarousel({
        loop: true,
        autoplay: true,
        margin: 30,
        rtl: true,
        nav: true,
        mouseDrag: true,
        autoplayHoverPause: true,
        responsiveClass: true,
        dots: false,
        navText: ["<i class='icofont-curved-double-left'></i>", "<i class='icofont-curved-double-right'></i>"],
        responsive: { 0: { items: 1 }, 768: { items: 2 }, 1024: { items: 2 }, 1200: { items: 3 } },
    });
    $(function() {
        $(".accordion")
            .find(".accordion-title")
            .on("click", function() {
                $(this).toggleClass("active");
                $(this).next().slideToggle("fast");
                $(".accordion-content").not($(this).next()).slideUp("fast");
                $(".accordion-title").not($(this)).removeClass("active");
            });
    });
    $(".partner-slides").owlCarousel({
        loop: true,
        autoplay: true,
        margin: 30,
        rtl: true,
        nav: false,
        mouseDrag: true,
        autoplayHoverPause: true,
        responsiveClass: true,
        dots: false,
        navText: ["<i class='icofont-curved-double-left'></i>", "<i class='icofont-curved-double-right'></i>"],
        responsive: { 0: { items: 2 }, 768: { items: 4 }, 1200: { items: 6 } },
    });
    $(".popup-youtube").magnificPopup({ disableOn: 320, type: "iframe", mainClass: "mfp-fade", removalDelay: 160, preloader: false, fixedContentPos: false });
    $(function() {
        $(window).on("scroll", function() {
            var scrolled = $(window).scrollTop();
            if (scrolled > 300) $(".go-top").fadeIn("slow");
            if (scrolled < 300) $(".go-top").fadeOut("slow");
        });
        $(".go-top").on("click", function() {
            $("html, body").animate({ scrollTop: "0" }, 500);
        });
    });
    $(".newsletter-form")
        .validator()
        .on("submit", function(event) {
            if (event.isDefaultPrevented()) {
                formErrorSub();
                submitMSGSub(false, "Please enter your email correctly.");
            } else {
                event.preventDefault();
            }
        });

    function callbackFunction(resp) {
        if (resp.result === "success") {
            formSuccessSub();
        } else {
            formErrorSub();
        }
    }

    function formSuccessSub() {
        $(".newsletter-form")[0].reset();
        submitMSGSub(true, "Thank you for subscribing!");
        setTimeout(function() {
            $("#validator-newsletter").addClass("hide");
        }, 4000);
    }

    function formErrorSub() {
        $(".newsletter-form").addClass("animated shake");
        setTimeout(function() {
            $(".newsletter-form").removeClass("animated shake");
        }, 1000);
    }

    function submitMSGSub(valid, msg) {
        if (valid) {
            var msgClasses = "validation-success";
        } else {
            var msgClasses = "validation-danger";
        }
        $("#validator-newsletter").removeClass().addClass(msgClasses).text(msg);
    }
    $(".newsletter-form").ajaxChimp({ url: "https://envytheme.us20.list-manage.com/subscribe/post?u=60e1ffe2e8a68ce1204cd39a5&amp;id=42d6d188d9", callback: callbackFunction });
    try {
        var mixer = mixitup('.shorting', {
            controls: {
                toggleDefault: 'none'
            }
        });
    } catch (err) {}
    $(".popup-btn").magnificPopup({ type: "image", gallery: { enabled: true } });
    $(".repair-feedback-slides").owlCarousel({
        loop: true,
        autoplay: true,
        nav: false,
        rtl: true,
        margin: 30,
        mouseDrag: true,
        autoplayHoverPause: true,
        responsiveClass: true,
        dots: true,
        navText: ["<i class='icofont-double-left'></i>", "<i class='icofont-double-right'></i>"],
        responsive: { 0: { items: 1 }, 768: { items: 2 }, 1200: { items: 2 } },
    });
    $(".repair-partner-slider").owlCarousel({
        loop: true,
        autoplay: true,
        margin: 30,
        rtl: true,
        nav: false,
        mouseDrag: true,
        autoplayHoverPause: true,
        responsiveClass: true,
        dots: false,
        navText: ["<i class='icofont-double-left'></i>", "<i class='icofont-double-right'></i>"],
        responsive: { 0: { items: 2 }, 768: { items: 4 }, 1200: { items: 6 } },
    });
    $(".repair-home-slides").owlCarousel({
        loop: false,
        autoplay: true,
        nav: false,
        items: 1,
        margin: 30,
        rtl: true,
        mouseDrag: true,
        autoplayHoverPause: true,
        responsiveClass: true,
        dots: true,
        navText: ["<i class='icofont-double-left'></i>", "<i class='icofont-double-right'></i>"],
    });
    $(".repair-home-slides").on("translate.owl.carousel", function() {
        $(".repair-banner-content h2").removeClass("animated animate__animated animate__fadeInUp").css("opacity", "0");
        $(".repair-banner-content p").removeClass("animated zoomIn").css("opacity", "0");
        $(".repair-banner-content .btn").removeClass("animated fadeInDown").css("opacity", "0");
        $(".banner-video a").removeClass("animated animate__animated animate__fadeInUp").css("opacity", "0");
    });
    $(".repair-home-slides").on("translated.owl.carousel", function() {
        $(".repair-banner-content h2").addClass("animated animate__animated animate__fadeInUp").css("opacity", "1");
        $(".repair-banner-content p").addClass("animated zoomIn").css("opacity", "1");
        $(".repair-banner-content .btn").addClass("animated fadeInDown").css("opacity", "1");
        $(".banner-video a").addClass("animated animate__animated animate__fadeInUp").css("opacity", "1");
    });
    $(".repair-services-slides").owlCarousel({
        loop: true,
        autoplay: true,
        nav: false,
        rtl: true,
        margin: 30,
        mouseDrag: true,
        autoplayHoverPause: true,
        responsiveClass: true,
        dots: true,
        navText: ["<i class='icofont-double-left'></i>", "<i class='icofont-double-right'></i>"],
        responsive: { 0: { items: 1 }, 768: { items: 2 }, 1200: { items: 3 } },
    });
    $(window).on("load", function() {
        if ($(".wow").length) {
            var wow = new WOW({ boxClass: "wow", animateClass: "animated", offset: 20, mobile: true, live: true });
            wow.init();
        }
    });
    jQuery(window).on("load", function() {
        $(".preloader").fadeOut();
    });



    /* Start "Technology Services Demo", "SaaS Startup Demo", "NFT Startup Demo", "Crypto Startup Demo", "CSS" */

    //Progress Bar
    try {
        if ($('.progress-line').length) {
            $('.progress-line').appear(function() {
                var el = $(this);
                var percent = el.data('width');
                $(el).css('width', percent + '%');
            }, { accY: 0 });
        }
        if ($('.count-box').length) {
            $('.count-box').appear(function() {
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
                        step: function() {
                            $t.find(".count-text").text(Math.floor(this.countNum));
                        },
                        complete: function() {
                            $t.find(".count-text").text(this.countNum);
                        }
                    });
                }

            }, { accY: 0 });
        }
    } catch (err) {}

    // TS Offer Slides
    $('.ts-offer-slides').owlCarousel({
        nav: true,
        margin: 25,
        loop: true,
        rtl: true,
        autoHeight: true,
        dots: false,
        autoplay: true,
        autoplayHoverPause: true,
        navText: [
            "<i class='icofont-arrow-left'></i>",
            "<i class='icofont-arrow-right'></i>",
        ],
        responsive: {
            0: {
                items: 1
            },
            576: {
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

    // TS Feedback Slides
    $('.ts-feedback-slides').owlCarousel({
        nav: false,
        margin: 25,
        loop: true,
        rtl: true,
        autoHeight: true,
        dots: true,
        autoplay: true,
        autoplayHoverPause: true,
        items: 1,
    });

    // TS Team Slides
    $('.ts-team-slides').owlCarousel({
        nav: true,
        margin: 25,
        loop: true,
        rtl: true,
        autoHeight: true,
        dots: false,
        autoplay: true,
        autoplayHoverPause: true,
        navText: [
            "<i class='icofont-arrow-left'></i>",
            "<i class='icofont-arrow-right'></i>",
        ],
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 1
            },
            768: {
                items: 2
            },
            992: {
                items: 2
            },
            1200: {
                items: 3
            }
        }
    });

    // Pricing Switcher
    let el = document.getElementById('filt-monthly');
    if (el) {
        let e = document.getElementById("filt-monthly"),
            d = document.getElementById("filt-yearly"),
            t = document.getElementById("switcher"),
            m = document.getElementById("monthly"),
            y = document.getElementById("yearly");
        e.addEventListener("click", function() {
            t.checked = false;
            e.classList.add("toggler--is-active");
            d.classList.remove("toggler--is-active");
            m.classList.remove("hide");
            y.classList.add("hide");
        });
        d.addEventListener("click", function() {
            t.checked = true;
            d.classList.add("toggler--is-active");
            e.classList.remove("toggler--is-active");
            m.classList.add("hide");
            y.classList.remove("hide");
        });
        t.addEventListener("click", function() {
            d.classList.toggle("toggler--is-active");
            e.classList.toggle("toggler--is-active");
            m.classList.toggle("hide");
            y.classList.toggle("hide");
        });
    }

    // SaaS Services Slides
    $('.saas-services-slides').owlCarousel({
        nav: true,
        margin: 25,
        loop: true,
        rtl: true,
        autoHeight: true,
        dots: false,
        autoplay: true,
        autoplayHoverPause: true,
        navText: [
            "<i class='icofont-arrow-left'></i>",
            "<i class='icofont-arrow-right'></i>",
        ],
        responsive: {
            0: {
                items: 1
            },
            576: {
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
            },
        }
    });

    // NFT Banner Card Slides JS
    $('.nft-banner-card-slides').owlCarousel({
        loop: true,
        margin: 0,
        rtl: true,
        nav: false,
        mouseDrag: false,
        thumbs: true,
        thumbsPrerendered: true,
        items: 1,
        dots: false,
        autoHeight: true,
        autoplay: true,
        autoplayHoverPause: true,
    });

    // Live Auctions Countdown
    $('.live-auctions-countdown').downCount({
        date: '08/27/2025 12:00:00',
        offset: -5
    }, function() {
        alert('WOOT WOOT, done!');
    });

    // Live Auctions Slides JS
    $('.live-auctions-slides').owlCarousel({
        nav: true,
        margin: 25,
        loop: true,
        rtl: true,
        autoHeight: true,
        dots: false,
        autoplay: true,
        autoplayHoverPause: true,
        navText: [
            "<i class='icofont-arrow-left'></i>",
            "<i class='icofont-arrow-right'></i>",
        ],
        responsive: {
            0: {
                items: 1
            },
            576: {
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
            },
        }
    });

    // Sellers Slides JS
    $('.sellers-slides').owlCarousel({
        nav: true,
        margin: 25,
        rtl: true,
        loop: true,
        autoHeight: true,
        dots: false,
        autoplay: true,
        autoplayHoverPause: true,
        navText: [
            "<i class='icofont-arrow-left'></i>",
            "<i class='icofont-arrow-right'></i>",
        ],
        responsive: {
            0: {
                items: 1
            },
            576: {
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
            },
        }
    });

    // About Countdown
    $('.about-countdown').downCount({
        date: '08/27/2025 12:00:00',
        offset: -5
    }, function() {
        alert('WOOT WOOT, done!');
    });

    // jtimeline JS
    $('#jtimeline-demo').jTimeline({

        // pixels per second
        resolution: 5800000,

        // minimum spacing between events
        minimumSpacing: 200,

        // scrolling (translateX) step size
        step: 200,

        // character for left arrow
        leftArrow: "&larr;",

        // character for right arrow
        rightArrow: "&rarr;",
    });

    /* End "Technology Services Demo", "SaaS Startup Demo", "NFT Startup Demo", "Crypto Startup Demo", "CSS" */

})(jQuery);

// function to set a given theme/color-scheme
function setTheme(themeName) {
    localStorage.setItem('axolot_rtl_theme', themeName);
    document.documentElement.className = themeName;
}
// function to toggle between light and dark theme
function toggleTheme() {
    if (localStorage.getItem('axolot_rtl_theme') === 'theme-dark') {
        setTheme('theme-light');
    } else {
        setTheme('theme-dark');
    }
}
// Immediately invoked function to set the theme on initial load
(function() {
    if (localStorage.getItem('axolot_rtl_theme') === 'theme-dark') {
        setTheme('theme-dark');
        document.getElementById('slider').checked = false;
    } else {
        setTheme('theme-light');
        document.getElementById('slider').checked = true;
    }
})();