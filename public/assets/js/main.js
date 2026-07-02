(function($) {
    "use strict";
  
    const $documentOn = $(document);
    const $windowOn = $(window);
  
    $documentOn.ready( function() {
  
      /* ================================
       Mobile Menu Js Start
    ================================ */
    
      $('#mobile-menu').meanmenu({
        meanMenuContainer: '.mobile-menu',
        meanScreenWidth: "1199",
        meanExpand: ['<i class="far fa-plus"></i>'],
    });

       $('#mobile-menus').meanmenu({
        meanMenuContainer: '.mobile-menus',
        meanScreenWidth: "19920",
        meanExpand: ['<i class="far fa-plus"></i>'],
    });

     $documentOn.on("click", ".mean-expand", function () {
        let icon = $(this).find("i");

        if (icon.hasClass("fa-plus")) {
            icon.removeClass("fa-plus").addClass("fa-minus"); 
        } else {
            icon.removeClass("fa-minus").addClass("fa-plus"); 
        }
    });

    /* ================================
        Sidebar Toggle & Sticky Item Logic
        ================================ */

        // Open offcanvas
        $(".sidebar__toggle").on("click", function () {
        $(".offcanvas__info").addClass("info-open");
        $(".offcanvas__overlay").addClass("overlay-open");

        // Hide sticky item
        $(".sidebar-sticky-item").fadeOut().removeClass("active");
        });

        // Close offcanvas
        $(".offcanvas__close, .offcanvas__overlay").on("click", function () {
        $(".offcanvas__info").removeClass("info-open");
        $(".offcanvas__overlay").removeClass("overlay-open");

        // Show sticky item
        $(".sidebar-sticky-item").fadeIn().addClass("active");
        });

        /* ================================
        Body Overlay Js Start
        ================================ */

        $(".body-overlay").on("click", function () {
        $(".offcanvas__area").removeClass("offcanvas-opened");
        $(".df-search-area").removeClass("opened");
        $(".body-overlay").removeClass("opened");

        // Show sticky item when overlay clicked
        $(".sidebar-sticky-item").fadeIn().addClass("active");
        });

        /* ================================
        Offcanvas Link Click (Optional)
        ================================ */

        $(".offcanvas a").on("click", function () {
        $(".sidebar-sticky-item").fadeIn().addClass("active");
    });

    
      /* ================================
       Sticky Header Js Start
    ================================ */

       $windowOn.on("scroll", function () {
        if ($(this).scrollTop() > 250) {
          $("#header-sticky").addClass("sticky");
        } else {
          $("#header-sticky").removeClass("sticky");
        }
      });      


      ////////////////////////////////////////////////////
	// 05. Search Js
	$(".search_btn").on("click", function () {
		$(".search_popup").addClass("search-opened");
		$(".search-popup-overlay").addClass("search-popup-overlay-open");
		$("body").addClass("overflow-hidden");
	});

	$(".search_close_btn").on("click", function () {
		$(".search_popup").removeClass("search-opened");
		$(".search-popup-overlay").removeClass("search-popup-overlay-open");
		$("body").removeClass("overflow-hidden");
	});
	$(".search-popup-overlay").on("click", function () {
		$(".search_popup").removeClass("search-opened");
		$(this).removeClass("search-popup-overlay-open");
		$("body").removeClass("overflow-hidden");
	});

      
       /* ================================
       Video & Image Popup Js Start
    ================================ */

      $(".img-popup").magnificPopup({
        type: "image",
        gallery: {
          enabled: true,
        },
      });

      $(".video-popup").magnificPopup({
        type: "iframe",
        callbacks: {},
      });
  
      /* ================================
       Counterup Js Start
    ================================ */

      $(".count").counterUp({
        delay: 15,
        time: 4000,
      });
  
      /* ================================
       Wow Animation Js Start
    ================================ */

      new WOW().init();
  
      /* ================================
       Nice Select Js Start
    ================================ */

    if ($('.single-select').length) {
        $('.single-select').niceSelect();
    }

      /* ================================
       Parallaxie Js Start
    ================================ */

      if ($('.parallaxie').length && $(window).width() > 991) {
          if ($(window).width() > 768) {
              $('.parallaxie').parallaxie({
                  speed: 0.55,
                  offset: 0,
              });
          }
      }

       // circle-progress
        $(".circle-bar").loading();
      
      /* ================================
      Hover Active Js Start
    ================================ */

    $(".counter-box, .service-card-item, .choose-list li, .feature-box-style-3, .about-wrapper-5 .about-icon-item, .service-box-style-5, .counter-box-style-5, .work-process-box-style-4, .contact-info-box").hover(
		// Function to run when the mouse enters the element
		function () {
			// Remove the "active" class from all elements
			$(".counter-box, .service-card-item, .choose-list li, .feature-box-style-3, .about-wrapper-5 .about-icon-item, .service-box-style-5, .counter-box-style-5, .work-process-box-style-4, .contact-info-box").removeClass("active");
			// Add the "active" class to the currently hovered element
			$(this).addClass("active");
		}
	);

      if ($('.service-box-style-4').length) {
        $(".service-box-style-4").on('click', '.service-acc-btn', function () {
            var outerBox = $(this).closest('.service-box-style-4');
            var target = $(this).closest('.accordion');
            var accBtn = $(this);
            var accContent = accBtn.next('.service-acc-content');

            if (target.hasClass('active-block')) {
                // Already open, so close it
                accBtn.removeClass('active');
                target.removeClass('active-block');
                accContent.slideUp(300);
            } else {
                // Close all others
                outerBox.find('.accordion').removeClass('active-block');
                outerBox.find('.service-acc-btn').removeClass('active');
                outerBox.find('.service-acc-content').slideUp(300);

                // Open clicked one
                accBtn.addClass('active');
                target.addClass('active-block');
                accContent.slideDown(300);
            }
        });
    }

    /* ================================
     Scrolldown Js Start
    ================================ */
    $("#scrollDown").on("click", function () {
        setTimeout(function () {
            $("html, body").animate({ scrollTop: "+=1000px" }, "slow");
        }, 1000);
    });


    const boxes = document.querySelectorAll(".main-box .box");

boxes.forEach(box => {
    box.addEventListener("mouseenter", () => {
        boxes.forEach(b => b.classList.remove("active"));
        box.classList.add("active");
    });
});

    /* ================================
      Brand Slider Js Start
    ================================ */

   if ($('.brand-slider').length > 0) {
    const brandSlider = new Swiper(".brand-slider", {
        spaceBetween: 30,
        speed: 1300,
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".array-next",
            prevEl: ".array-prev",
        },
        breakpoints: {
            1399: {
                slidesPerView: 6,
            },
            1199: {
                slidesPerView: 5.5,
            },
            991: {
                slidesPerView: 4.5,
            },
            767: {
                slidesPerView: 3.3,
            },
            575: {
                slidesPerView: 2,
            },
            0: {
                slidesPerView: 1.3,
            },
        },
    });
   }

    /* ================================
       GT Team Slider Js Start
    ================================ */

    if ($(".team-slider-active").length > 0) {
      const gtInstagramSlider2 = new Swiper(".team-slider-active", {
        spaceBetween: 30,
        speed: 1300,
        centeredSlides: true,
        loop: true,
        autoplay: {
          delay: 2000,
          disableOnInteraction: false,
        },
        navigation: {
          nextEl: ".array-prev",
          prevEl: ".array-next",
        },
        breakpoints: {
          1399: {
            slidesPerView: 4,
          },
          1199: {
            slidesPerView: 4,
          },
          991: {
            slidesPerView: 3,
          },
          767: {
            slidesPerView: 3,
          },
          575: {
            slidesPerView: 2,
          },
          0: {
            slidesPerView: 1,
          },
        },
      });
    }
   
   /* ================================
      Brand Slider Js Start
    ================================ */
   
   if ($('.brand-slider-7').length > 0) {
    const brandSlider7 = new Swiper(".brand-slider-7", {
        spaceBetween: 30,
        speed: 1300,
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".array-next",
            prevEl: ".array-prev",
        },
        breakpoints: {
            1399: {
                slidesPerView: 4,
            },
            1199: {
                slidesPerView: 3,
            },
            991: {
                slidesPerView: 2,
            },
            767: {
                slidesPerView: 2,
            },
            575: {
                slidesPerView: 2,
            },
            0: {
                slidesPerView: 1,
            },
        },
    });
   }
   /* ================================
       GT Testimonial Slider Js Start
    ================================ */

    if ($(".testimonial-img-slider").length > 0) {
      const gtTestimonialSlider = new Swiper(".testimonial-img-slider", {
        spaceBetween: 30,
        slidesPerView: 3,
        direction: "vertical",
        speed: 1300,
        loop: true,
        centeredSlides: true,
        autoplay: {
          delay: 2000,
          disableOnInteraction: false,
        },
        navigation: {
          nextEl: ".tastimonial-one-array-next",
          prevEl: ".tastimonial-one-array-prev",
        },
        pagination: {
          el: ".dot",
          clickable: true,
        },
      });
    }

    if ($(".testimonial-text-slider").length > 0) {
      const gtTestimonialSlider = new Swiper(".testimonial-text-slider", {
        spaceBetween: 30,
        slidesPerView: 1,
        speed: 1300,
        loop: true,
        centeredSlides: true,
        autoplay: {
          delay: 2000,
          disableOnInteraction: false,
        },

        navigation: {
          nextEl: ".tastimonial-one-array-next",
          prevEl: ".tastimonial-one-array-prev",
        },
        pagination: {
          el: ".dot",
          clickable: true,
        },
      });
    }

    /* ================================
      Testimonial Slider Js Start
    ================================ */

   if ($('.testimonial-slider').length > 0) {
    const TestimonialSlider = new Swiper(".testimonial-slider", {
        spaceBetween: 30,
        speed: 1300,
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".array-next",
            prevEl: ".array-prev",
        },
        pagination: {
            el: ".dot",
            clickable: true,
        },
        breakpoints: {
            1199: {
                slidesPerView: 2,
            },
            991: {
                slidesPerView: 1,
            },
            767: {
                slidesPerView: 1,
            },
            575: {
                slidesPerView: 1,
            },
            0: {
                slidesPerView: 1,
            },
        },
    });
   }

   /* ================================
      Testimonial Slider-2 Js Start
    ================================ */

   if ($('.testimonial-slider-2').length > 0) {
    const TestimonialSlider2 = new Swiper(".testimonial-slider-2", {
        spaceBetween: 30,
        speed: 1300,
        loop: true,
        centeredSlides: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".array-next",
            prevEl: ".array-prev",
        },
        pagination: {
            el: ".dot",
            clickable: true,
        },
        breakpoints: {
            1199: {
                slidesPerView: 1,
            },
            991: {
                slidesPerView: 1,
            },
            767: {
                slidesPerView: 1,
            },
            575: {
                slidesPerView: 1,
            },
            0: {
                slidesPerView: 1,
            },
        },
    });
   }

   if ($('.testimonial-slider-3').length > 0) {
    const testimonialSlider3 = new Swiper(".testimonial-slider-3", {
        spaceBetween: 30,
        speed: 1300,
        loop: true,
         centeredSlides: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".array-next",
            prevEl: ".array-prev",
        },
        pagination: {
            el: ".dot2",
            clickable: true,
        },
        breakpoints: {
            1399: {
                slidesPerView: 4,
            },
            1199: {
                slidesPerView: 3.4,
            },
            991: {
                slidesPerView: 3,
            },
            767: {
                slidesPerView: 2,
            },
            575: {
                slidesPerView: 1.5,
            },
            0: {
                slidesPerView: 1.2,
            },
        },
    });
    }

   /* ================================
      Testimonial Slider Js Start
    ================================ */

   if ($('.testimonial-slider-4').length > 0) {
    const TestimonialSlider4 = new Swiper(".testimonial-slider-4", {
        spaceBetween: 30,
        speed: 1300,
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".array-next",
            prevEl: ".array-prev",
        },
        pagination: {
            el: ".dot",
            clickable: true,
        },
        breakpoints: {
             1399: {
                slidesPerView: 4,
            },
            1199: {
                slidesPerView: 3,
            },
            991: {
                slidesPerView: 2,
            },
            767: {
                slidesPerView: 2,
            },
            575: {
                slidesPerView: 1,
            },
            0: {
                slidesPerView: 1,
            },
        },
    });
   }

    /* ================================
      Testimonial Slider Js Start
    ================================ */
   if ($('.testimonial-slider-5').length > 0) {
    const TestimonialSlider5 = new Swiper(".testimonial-slider-5", {
        spaceBetween: 0,
        speed: 1300,
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".array-next",
            prevEl: ".array-prev",
        },
        pagination: {
            el: ".dot",
            clickable: true,
        },
        breakpoints: {
             1399: {
                slidesPerView: 3,
            },
            1199: {
                slidesPerView: 2,
            },
            991: {
                slidesPerView: 2,
            },
            767: {
                slidesPerView: 2,
            },
            575: {
                slidesPerView: 1,
            },
            0: {
                slidesPerView: 1,
            },
        },
    });
   }

   /* ================================
      Testimonial Slider-2 Js Start
    ================================ */

   if ($('.news-slider').length > 0) {
    const NewsSlider = new Swiper(".news-slider", {
        spaceBetween: 30,
        speed: 1300,
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".dot2",
            clickable: true,
        },
        breakpoints: {
            1199: {
                slidesPerView: 4,
            },
            991: {
                slidesPerView: 2,
            },
            767: {
                slidesPerView: 2,
            },
            575: {
                slidesPerView: 1,
            },
            0: {
                slidesPerView: 1,
            },
        },
    });
   }

   /* ================================
      Service Slider Js Start
    ================================ */

   if ($('.service-slider').length > 0) {
    const ServiceSlider = new Swiper(".service-slider", {
        spaceBetween: 30,
        speed: 1300,
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".array-next",
            prevEl: ".array-prev",
        },
        pagination: {
            el: ".dot",
            clickable: true,
        },
        breakpoints: {
            1399: {
                slidesPerView: 5,
            },
            1199: {
                slidesPerView: 4,
            },
            991: {
                slidesPerView: 3,
            },
            767: {
                slidesPerView: 2,
            },
            575: {
                slidesPerView: 1,
            },
            0: {
                slidesPerView: 1,
            },
        },
    });
   }

   /* ================================
      Service Slider-3 Js Start
    ================================ */

   if ($('.service-slider-3').length > 0) {
    const ServiceSlider3 = new Swiper(".service-slider-3", {
        spaceBetween: 30,
        speed: 1300,
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".array-next",
            prevEl: ".array-prev",
        },
        pagination: {
            el: ".dot",
            clickable: true,
        },
        breakpoints: {
            1399: {
                slidesPerView: 4,
            },
            1199: {
                slidesPerView: 3,
            },
            991: {
                slidesPerView: 3,
            },
            767: {
                slidesPerView: 2,
            },
            575: {
                slidesPerView: 1,
            },
            0: {
                slidesPerView: 1,
            },
        },
    });
   }

   /* ================================
      Service Slider-3 Js Start
    ================================ */

   if ($('.service-slider-4').length > 0) {
    const ServiceSlider4 = new Swiper(".service-slider-4", {
        spaceBetween: 30,
        speed: 1300,
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".array-next",
            prevEl: ".array-prev",
        },
        pagination: {
            el: ".dot",
            clickable: true,
        },
        breakpoints: {
            1399: {
                slidesPerView: 3,
            },
            1199: {
                slidesPerView: 2,
            },
            991: {
                slidesPerView: 2,
            },
            767: {
                slidesPerView: 2,
            },
            575: {
                slidesPerView: 1,
            },
            0: {
                slidesPerView: 1,
            },
        },
    });
   }



   document.querySelectorAll('.tw-hover-btn').forEach(btn => {
    const circle = btn.querySelector('.tw-btn-circle-dot');

    btn.addEventListener('mouseenter', e => {
        const r = btn.getBoundingClientRect();
        circle.style.left = e.clientX - r.left + 'px';
        circle.style.top = e.clientY - r.top + 'px';

        circle.style.width = '20px';
        circle.style.height = '20px';
        circle.offsetHeight; // force reflow
    });

    btn.addEventListener('mousemove', e => {
        const r = btn.getBoundingClientRect();
        circle.style.left = e.clientX - r.left + 'px';
        circle.style.top = e.clientY - r.top + 'px';
    });

    btn.addEventListener('mouseenter', () => {
        circle.style.width = '300%';
        circle.style.height = '300%';
    });

    btn.addEventListener('mouseleave', () => {
        circle.style.width = '20px';
        circle.style.height = '20px';
    });
});

/* ================================
    Marquee-Group Js Start
    ================================ */

    if (document.querySelectorAll(".marquee-group").length) {
        const marqueegroup = document.querySelectorAll(".marquee-group");

        marqueegroup.forEach((box) => {
            const hoverImg = box.querySelector(".hover-image");
            if (!hoverImg) return;

            box.addEventListener("mousemove", (event) => {
            const rect = box.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;

            hoverImg.style.opacity = "1";
            hoverImg.style.visibility = "visible";
            hoverImg.style.transform = `translate(${x}px, ${y}px) rotate(10deg)`;
            });

            box.addEventListener("mouseleave", () => {
            hoverImg.style.opacity = "0";
            hoverImg.style.visibility = "hidden";
            hoverImg.style.transform = `translateY(-50%) rotate(10deg)`;
            });
        });
        }


   /* ================================
    Project Slider Js Start
    ================================ */

    if($('.project-slider').length > 0) {
         const ProjectSlider = new Swiper(".project-slider", {
            spaceBetween: 30,
            speed: 1300,
            loop: true,
            centeredSlides: true,
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            },
            breakpoints: {
                1399: {
                    slidesPerView: 4,
                },
                1199: {
                    slidesPerView: 3,
                },
                991: {
                    slidesPerView: 2,
                },
                767: {
                    slidesPerView: 2,
                },
                575: {
                    slidesPerView: 1,
                },
                0: {
                    slidesPerView: 1,
                },
            },
        });
    }

     if($('.project-slider-7').length > 0) {
         const ProjectSlider7 = new Swiper(".project-slider-7", {
            spaceBetween: 30,
            speed: 1300,
            loop: true,
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            },
             pagination: {
            el: ".dot",
            clickable: true,
        },
            breakpoints: {
                1399: {
                    slidesPerView: 3,
                },
                1199: {
                    slidesPerView: 2,
                },
                991: {
                    slidesPerView: 2,
                },
                767: {
                    slidesPerView: 2,
                },
                575: {
                    slidesPerView: 1,
                },
                0: {
                    slidesPerView: 1,
                },
            },
        });
    }
 
 
   //>>box Slider Start <<//
      if($('.box-slider').length > 0) {
        const BoxSlider = new Swiper(".box-slider", {
            slidesPerView: 'auto',
            spaceBetween: 20,
            freemode: true,
            centeredSlides: true,
            loop: true,
            speed: 6000,
            allowTouchMove: false,
            autoplay: {
                delay: 1,
                disableOnInteraction: true,
            },
        });
    }

    //>>box Slider2 Start <<//
    if($('.box-slider-2').length > 0) {
        const BoxSlider2 = new Swiper(".box-slider-2", {
            slidesPerView: 'auto',
            spaceBetween: 20,
            freemode: true,
            centeredSlides: true,
            loop: true,
            speed: 6000,
            allowTouchMove: false,
            autoplay: {
                delay: 1,
                disableOnInteraction: true,
            },
        });
    }

    /* ================================
      Custom Accordion Js Start
    ================================ */

   if ($('.accordion-box').length) {
        $(".accordion-box").on('click', '.acc-btn', function () {
            var outerBox = $(this).closest('.accordion-box');
            var target = $(this).closest('.accordion');
            var accBtn = $(this);
            var accContent = accBtn.next('.acc-content');

            if (target.hasClass('active-block')) {
                // Already open, so close it
                accBtn.removeClass('active');
                target.removeClass('active-block');
                accContent.slideUp(300);
            } else {
                // Close all others
                outerBox.find('.accordion').removeClass('active-block');
                outerBox.find('.acc-btn').removeClass('active');
                outerBox.find('.acc-content').slideUp(300);

                // Open clicked one
                accBtn.addClass('active');
                target.addClass('active-block');
                accContent.slideDown(300);
            }
        });
    }

    /* ================================
        Mouse Cursor Animation Js Start
    ================================ */

    if ($(".mouseCursor").length > 0) {
        function itCursor() {
            var myCursor = jQuery(".mouseCursor");
            if (myCursor.length) {
                if ($("body")) {
                    const e = document.querySelector(".cursor-inner"),
                        t = document.querySelector(".cursor-outer");
                    let n, i = 0, o = !1;
                    window.onmousemove = function(s) {
                        if (!o) {
                            t.style.transform = "translate(" + s.clientX + "px, " + s.clientY + "px)";
                        }
                        e.style.transform = "translate(" + s.clientX + "px, " + s.clientY + "px)";
                        n = s.clientY;
                        i = s.clientX;
                    };
                    $("body").on("mouseenter", "button, a, .cursor-pointer", function() {
                        e.classList.add("cursor-hover");
                        t.classList.add("cursor-hover");
                    });
                    $("body").on("mouseleave", "button, a, .cursor-pointer", function() {
                        if (!($(this).is("a", "button") && $(this).closest(".cursor-pointer").length)) {
                            e.classList.remove("cursor-hover");
                            t.classList.remove("cursor-hover");
                        }
                    });
                    e.style.visibility = "visible";
                    t.style.visibility = "visible";
                }
            }
        }
        itCursor();
    }

    /* ================================
        Back To Top Button Js Start
    ================================ */
    $windowOn.on('scroll', function() {
        var windowScrollTop = $(this).scrollTop();
        var windowHeight = $(window).height();
        var documentHeight = $(document).height();

        if (windowScrollTop + windowHeight >= documentHeight - 10) {
            $("#back-top").addClass("show");
        } else {
            $("#back-top").removeClass("show");
        }
    });

    $documentOn.on('click', '#back-top', function() {
        $('html, body').animate({ scrollTop: 0 }, 800);
        return false;
    });

    /* ================================
       Search Popup Toggle Js Start
    ================================ */

    // if ($(".search-toggler").length) {
    //     $(".search-toggler").on("click", function(e) {
    //         e.preventDefault();
    //         $(".search-popup").toggleClass("active");
    //         $("body").toggleClass("locked");
    //     });
    // }
	
    /* ================================
       Smooth Scroller And Title Animation Js Start
    ================================ */
    if ($('#smooth-wrapper').length && $('#smooth-content').length) {
        gsap.registerPlugin(ScrollTrigger, ScrollSmoother, SplitText);

        gsap.config({
            nullTargetWarn: false,
        });

        let smoother = ScrollSmoother.create({
            wrapper: "#smooth-wrapper",
            content: "#smooth-content",
            smooth: 2,
            effects: true,
            smoothTouch: 0.1,
            normalizeScroll: false,
            ignoreMobileResize: true,
        });
    }

     /* ================================
       Sticky Js Start
    ================================ */


    /* ================================
       Text Anim Js Start
    ================================ */

   if ($(".text-anim").length) {
        let staggerAmount = 0.03,
            translateXValue = 20,
            delayValue = 0.1,
            easeType = "power2.out",
            animatedTextElements = document.querySelectorAll(".text-anim");

        animatedTextElements.forEach(element => {
            let animationSplitText = new SplitText(element, { type: "chars, words" });

            // ScrollTrigger দিয়ে section এ ঢুকলে animation শুরু হবে
            ScrollTrigger.create({
                trigger: element,
                start: "top 85%",
                onEnter: () => {
                    gsap.from(animationSplitText.chars, {
                        duration: 1,
                        delay: delayValue,
                        x: translateXValue,
                        autoAlpha: 0,
                        stagger: staggerAmount,
                        ease: easeType,
                    });
                },
            });
        });
    }

    if($('.tz-itm-title').length) {
		var txtheading = $(".tz-itm-title");

    if(txtheading.length == 0) return; gsap.registerPlugin(SplitText); txtheading.each(function(index, el) {

        el.split = new SplitText(el, {
          type: "lines,words,chars",
          linesClass: "split-line"
        });

        if( $(el).hasClass('tz-itm-anim') ){
          gsap.set(el.split.chars, {
            opacity: .3,
            x: "-7",
          });
        }
        el.anim = gsap.to(el.split.chars, {
          scrollTrigger: {
            trigger: el,
            start: "top 92%",
            end: "top 60%",
            markers: false,
            scrub: 1,
          },

          x: "0",
          y: "0",
          opacity: 1,
          duration: .7,
          stagger: 0.2,
        });

      });
    }

    // image animation
    let revealContainers = document.querySelectorAll(".reveal");

    revealContainers.forEach((container) => {
        let image = container.querySelector("img");
        let tl = gsap.timeline({
        scrollTrigger: {
            trigger: container,
            toggleActions: "restart none none reset"
        }
        });

        tl.set(container, { autoAlpha: 1 });
        tl.from(container, 1.5, {
        xPercent: -100,
        ease: Power2.out
        });
        tl.from(image, 1.5, {
        xPercent: 100,
        scale: 1.3,
        delay: -1.5,
        ease: Power2.out
        });
    });


    gsap.registerPlugin(ScrollTrigger);

    // 992px এর উপরে স্ক্রল পিন চালু হবে
    ScrollTrigger.matchMedia({
    
    "(min-width: 1199px)": function () {
        let projectPanels = document.querySelectorAll('.project-panel');

        projectPanels.forEach((section) => {
        gsap.to(section, {
            scrollTrigger: {
            trigger: section,
            pin: section,
            scrub: 1,
            start: "top 10%",
            end: "bottom 65%",
            endTrigger: ".project-panel-area",
            pinSpacing: false,
            markers: false
            }
        });
        });
    },

    // 991px এবং নিচে - সব ScrollTrigger বন্ধ
    "(max-width: 1199px)": function () {
        ScrollTrigger.getAll().forEach(st => st.kill());
    }

    });


  /* ==================================================
    Image Scale
    ================================================== */
   var width = $(window).width();

    if (width > 1023) {
        if (document.querySelectorAll(".scale-animation").length > 0) {

            gsap.registerPlugin(ScrollTrigger);

            gsap.utils.toArray(".scale-animation").forEach(function (section) {

                gsap.timeline({
                    scrollTrigger: {
                        trigger: section,
                        scrub: 3,
                        start: "top 90%",
                        end: "bottom 70%",
                    },
                })
                .from(section, {
                    scale: 0.8,
                    opacity: 0,
                    transformOrigin: "center bottom",
                    duration: 1.5,
                    ease: "power2.out",
                })
                .to(section, {
                    scale: 1,
                    opacity: 1,
                    transformOrigin: "center bottom",
                    duration: 1.2,
                    ease: "power2.out",
                });
            });
        }
    }

  if ($('.full-img-wrap3').length > 0) {
        // Check window width
        if (window.innerWidth > 1399) {
            ScrollTrigger.create({
                trigger: ".full-img-wrap3",
                start: "top 0",
                end: "bottom 0%",
                pin: ".full-img3",
                pinSpacing: false,
            });
        }
    }


    // ScrollTrigger register করতে ভুলবেন না
    gsap.registerPlugin(ScrollTrigger);

    gsap.utils.toArray(".tp_fade_anim").forEach((item) => {
        let tp_fade_offset = item.getAttribute("data-fade-offset") || 40,
            tp_duration_value = item.getAttribute("data-duration") || 0.75,
            tp_fade_direction = item.getAttribute("data-fade-from") || "bottom",
            tp_onscroll_value = item.getAttribute("data-on-scroll") || 1,
            tp_delay_value = item.getAttribute("data-delay") || 0.15,
            tp_ease_value = item.getAttribute("data-ease") || "power2.out";

        let tp_anim_setting = {
            opacity: 0,
            ease: tp_ease_value,
            duration: tp_duration_value,
            delay: tp_delay_value,
            x: (tp_fade_direction == "left" ? -tp_fade_offset : (tp_fade_direction == "right" ? tp_fade_offset : 0)),
            y: (tp_fade_direction == "top" ? -tp_fade_offset : (tp_fade_direction == "bottom" ? tp_fade_offset : 0)),
        };

        // Scroll এ animate হবে
        if (tp_onscroll_value == 1) {
            tp_anim_setting.scrollTrigger = {
                trigger: item,
                start: "top 85%",
                toggleActions: "play none none reset",
            };
        }

        gsap.from(item, tp_anim_setting);
    });

   

    /* ==================================================
     Text Anim  Image 
    ================================================== */
    const textAnims = document.querySelectorAll('.text-anims');

    const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if(entry.isIntersecting){
        entry.target.classList.add('show');
        observer.unobserve(entry.target); // একবার হলে আর observe করবে না
        }
    });
    }, { threshold: 0.5 }); // 50% দেখা গেলে trigger

    textAnims.forEach(el => observer.observe(el));


    // Create mask divs for each wrapper
		
        document.querySelectorAll(".tp-clip-anim").forEach(wrapper => {
        const img = wrapper.querySelector(".tp-anim-img[data-animate='true']");
        if (!img) return;
        const url = img.src;

        // ensure wrapper position relative
        wrapper.style.position = "relative";

        // IntersectionObserver
        const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
        if (entry.isIntersecting) {
        wrapper.querySelectorAll(".mask").forEach(m => m.remove());

            // Create 9 masks
            for (let i = 0; i < 9; i++) {
                const mask = document.createElement("div");
                mask.className = `mask mask-${i + 1}`;
                Object.assign(mask.style, {
                    backgroundImage: `url(${url})`,
                    backgroundSize: "cover",
                    backgroundPosition: "center",
                    position: "absolute",
                    inset: "0"
                });
                wrapper.appendChild(mask);
            }

            // observer stop
            obs.unobserve(entry.target);
        }
    });
        }, { threshold: 0.2 });

        observer.observe(wrapper);
        });

        // scale animation 
        var scale = document.querySelectorAll(".scale");
        var image = document.querySelectorAll(".scale img");
        scale.forEach((item) => {
            gsap.to(item, {
            scale: 1,
            duration: 1,
            ease: "power1.out",
            scrollTrigger: {
                trigger: item,
                start: 'top bottom',
                end: "bottom top",
                toggleActions: 'play reverse play reverse'
            }
            });
        });
        image.forEach((image) => {
            gsap.set(image, {
            scale: 1.3,
            });
            gsap.to(image, {
            scale: 1,
            duration: 1,
            scrollTrigger: {
                trigger: image,
                start: 'top bottom',
                end: "bottom top",
                toggleActions: 'play reverse play reverse'
            }
            });
        })


        // Project-card-wrapper-4 animation 
        gsap.utils.toArray(".project-card-wrapper-4 .project-card-items-4").forEach((element, index, array) => {
        if (index === array.length - 1) return;

            const delay = parseFloat(element.getAttribute("data-ani-delay")) || 0;
            gsap.to(element, {
                scale: .6,
                opacity: 0,
                duration: 2,
                delay: delay,
                scrollTrigger: {
                    trigger: element,
                    start: "top 15%",
                    end: "bottom 15%",
                    scrub: 2,
                    pin: true,
                    pinSpacing: false,
                    markers: false
                }
            });
        });

    /* ================================
       Sticky Js Start
     ================================ */

    let pr = gsap.matchMedia();
	pr.add("(min-width: 1199px)", () => {
		let tl = gsap.timeline();
		let panels = document.querySelectorAll('.tp-panel-pin')
		panels.forEach((section, index) => {
			tl.to(section, {
				scrollTrigger: {
					trigger: section,
					pin: section,
					scrub: 1,
					start: "top 100px",
					end: "bottom 99%",
					endTrigger: '.tp-panel-pin-area',
					pinSpacing: false,
					markers: false,
				},
			})
		})
	});


      /* ================================
       Approach Anim Js Start
    ================================ */

    if (document.querySelectorAll(".approach-area").length > 0) {

    const mm = gsap.matchMedia();

    mm.add("(min-width: 1199px)", () => {

        const boxes = document.querySelectorAll(".approach-area .approach-box");

        gsap.from(boxes, {
            x: "100%",
            duration: 1,
            stagger: 0.3,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".approach-wrapper-box",
                start: "top 100%",
                end: "bottom 40%",
                scrub: 2,
                toggleActions: "play none none reverse",
            },
        });

    });
    }

     let pr2 = gsap.matchMedia();
    pr2.add("(min-width: 1199px)", () => {
        let tl = gsap.timeline();
        let panels = document.querySelectorAll('.tp-panel-pin2');
        panels.forEach((section, index) => {
            tl.to(section, {
                scrollTrigger: {
                    trigger: section,
                    pin: section,
                    scrub: 1,
                    start: 'top 15%',
                    end: 'bottom 65%',
                    endTrigger: '.tp-panel-pin-area2',
                    pinSpacing: false,
                    markers: false,
                },
            });
        });
    });


    /* ================================
      Text Invert Js Start
    ================================ */

    const split2 = new SplitText(".text_invert-2", { type: "lines" });

    split2.lines.forEach((target) => {
        gsap.to(target, {
            backgroundPositionX: 0,
            ease: "none",
            scrollTrigger: {
                trigger: target,
                scrub: 1,
                start: 'top 85%',
                end: "bottom center",
            }
        });
    });

    $(document).ready(function () {
        const $el = $("#typing-text");
        if (!$el.length) return; // stop if element not exist

        const words = ["Developer", "Visual Designer", "Crypto"];
        let index = 0;
        let letterIndex = 0;
        let isDeleting = false;
        let interval;

        function typeEffect() {
            const currentWord = words[index];
            if (!isDeleting && letterIndex <= currentWord.length) {
                $el.text(currentWord.substring(0, letterIndex));
                letterIndex++;
            } else if (isDeleting && letterIndex >= 0) {
                $el.text(currentWord.substring(0, letterIndex));
                letterIndex--;
            }

            if (letterIndex > currentWord.length) {
                isDeleting = true;
                clearInterval(interval);
                interval = setInterval(typeEffect, 100);
            } else if (letterIndex < 0) {
                isDeleting = false;
                index = (index + 1) % words.length;
                clearInterval(interval);
                interval = setInterval(typeEffect, 150);
            }
        }

        interval = setInterval(typeEffect, 150);
    });


     /* ================================
       Project Anim Js Start
    ================================ */

	if ($('.tp-project-5-2-area').length > 0) {
		let project_text = gsap.timeline({
			scrollTrigger: {
				trigger: ".tp-project-5-2-area",
				start: 'top center-=350',
				end: "bottom 50%",
				pin: ".tp-project-5-2-title",
				markers: false,
				pinSpacing: false,
				scrub: 1,
			}
		})
		project_text.set(".tp-project-5-2-title", {
			scale: .6,
			duration: 2
		})
		project_text.to(".tp-project-5-2-title", {
			scale: 1,
			duration: 2
		})
		project_text.to(".tp-project-5-2-title", {
			scale: 1,
			duration: 2
		}, "+=2")

         project_text.to(".tp-project-5-2-title", {
            autoAlpha: 0,
            duration: 2
        });
	}


      /* ================================
      Choose Anim Js Start
    ================================ */

    gsap.registerPlugin(ScrollTrigger);

    if (document.querySelectorAll('.design-choose-item-wrap').length) {
        const pw = ScrollTrigger.matchMedia();
        pw.add("(min-width: 1200px)", () => {
            document.querySelectorAll('.design-choose-item-wrap').forEach(item => {
                gsap.set(item.querySelector('.design-choose-item-1'), { x: -400, rotate: -40 });
                gsap.set(item.querySelector('.design-choose-item-2'), { x: 400, rotate: 40 });

                let tl = gsap.timeline({
                    scrollTrigger: {
                        trigger: item,
                        start: 'top 120%',
                        end: 'top 20%',
                        scrub: 1,
                    }
                });

                tl.to(item.querySelector('.design-choose-item-1'), { x: 0, rotate: 0 })
                .to(item.querySelector('.design-choose-item-2'), { x: 0, rotate: 0 }, 0);
            });
        });
    }


     /* ================================
       Service Panel Js Start
    ================================ */

	let sv = gsap.matchMedia();
	sv.add("(min-width: 1199px)", () => {
		let tl = gsap.timeline();
		let projectpanels = document.querySelectorAll('.tp-service-panel');
		let baseOffset = 150;
		let offsetIncrement = 120;

		projectpanels.forEach((section, index) => {
			let topOffset = baseOffset + (index * offsetIncrement);
			tl.to(section, {
				scrollTrigger: {
					trigger: section,
					pin: section,
					scrub: 1,
					start: `top ${topOffset}px`,
					end: "bottom 50%",
					endTrigger: '.tp-service-pin',
					pinSpacing: false,
					markers: false,
				},
			});
		});
	});

    // text-scale-anim
    const headings = document.querySelectorAll(".text-scale-anim");
    headings.forEach((heading) => {
      const textNodes = [];

      heading.childNodes.forEach((node) => {
        if (node.nodeType === Node.TEXT_NODE) {
          node.textContent.split(" ").forEach((word, index, array) => {
            const wordSpan = document.createElement("span");
            wordSpan.classList.add("tp-word-span");
            word.split("").forEach((letter) => {
              const letterSpan = document.createElement("span");
              letterSpan.classList.add("tp-letter-span");
              letterSpan.textContent = letter;
              wordSpan.appendChild(letterSpan);
            });
            textNodes.push(wordSpan);
            if (index < array.length - 1) {
              textNodes.push(document.createTextNode(" "));
            }
          });
        } else if (node.nodeType === Node.ELEMENT_NODE) {
          textNodes.push(node.cloneNode(true));
        }
      });

      heading.innerHTML = "";
      textNodes.forEach((node) => heading.appendChild(node));

      const letters = heading.querySelectorAll(".tp-letter-span");
      letters.forEach((letter) => {
        $(letter).on("mouseenter", () => {
          gsap.to(letter, {
            scaleY: 1.3,
            y: "-14%",
            duration: 0.2,
            ease: "sine",
          });
        });

        $(letter).on("mouseleave", () => {
          gsap.to(letter, {
            scaleY: 1,
            y: "0%",
            duration: 0.2,
            ease: "sine",
          });
        });
      });
    });

    
     // scroll Img
    gsap.to(".scroll-image", {
      x: () => {
        const img = document.querySelector(".scroll-image");
        const startRight = img.getBoundingClientRect().right;
        const endLeft = 290;
        const distance = startRight - endLeft - img.offsetWidth;
        return -distance;
      },
      scrollTrigger: {
        trigger: ".scroll-image",
        start: "top 60%",
        end: "bottom 0%",
        scrub: true,
      },
    });
    
     // About Page sticky
    let about_thumb = gsap.matchMedia();
    about_thumb.add("(min-width: 1200px)", () => {
      if ($(".gt-sticky-wrap").length > 0) {
        ScrollTrigger.create({
          trigger: ".gt-sticky-wrap",
          start: "top 150px",
          end: "52%",
          pin: ".gt-sticky",
          pinSpacing: true,
        });
      }
    });



    // Animation-3
    if (document.querySelectorAll(".cta-area").length > 0) {
      var tl = gsap.timeline({
        ease: "none",
        scrollTrigger: {
          trigger: ".cta-area",
          pin: true,
          pinSpacing: true,
          scrub: 2,
          start: "bottom 100%",
          end: "200%",
        },
      });

      // Background scale
      tl.to(".cta-area .area-bg", {
        scale: 10,
        delay: 0.1,
        ease: "power2.in",
      });

      // Title scale
      tl.to(
        ".cta-area .title",
        { fontSize: "4vw", ease: "power2.in" },
        "<" // sync with bg
      );

      // SVG width scale
      tl.to(
        ".cta-area .icon svg",
        {
          width: "25vw",
          marginBottom: "20px",
          ease: "power2.in",
        },
        "<"
      );
    }
    
        
    }); // End Document Ready Function

    

     $.fn.loading = function() {
        const DEFAULTS = {
            backgroundColor: '#b3cef6',
            progressColor: '#4b86db',
            percent: 75,
            duration: 2000
        };

        $(this).each(function() {
            const $target = $(this);

            const opts = {
                backgroundColor: $target.data('color') ? $target.data('color').split(',')[0] : DEFAULTS.backgroundColor,
                progressColor: $target.data('color') ? $target.data('color').split(',')[1] : DEFAULTS.progressColor,
                percent: $target.data('percent') ? $target.data('percent') : DEFAULTS.percent,
                duration: $target.data('duration') ? $target.data('duration') : DEFAULTS.duration
            };
            // console.log(opts);

            $target.append('<div class="background"></div><div class="rotate"></div><div class="left"></div><div class="right"></div><div class=""><span>' + opts.percent + '%</span></div>');

            $target.find('.background').css('background-color', opts.backgroundColor);
            $target.find('.left').css('background-color', opts.backgroundColor);
            $target.find('.rotate').css('background-color', opts.progressColor);
            $target.find('.right').css('background-color', opts.progressColor);

            const $rotate = $target.find('.rotate');
            setTimeout(function() {
                $rotate.css({
                    'transition': 'transform ' + opts.duration + 'ms linear',
                    'transform': 'rotate(' + opts.percent * 3.6 + 'deg)'
                });
            }, 1);

            if (opts.percent > 50) {
                let animationRight = 'toggle ' + (opts.duration / opts.percent * 50) + 'ms step-end';
                let animationLeft = 'toggle ' + (opts.duration / opts.percent * 50) + 'ms step-start';
                $target.find('.right').css({
                    animation: animationRight,
                    opacity: 1
                });
                $target.find('.left').css({
                    animation: animationLeft,
                    opacity: 0
                });
            }
        });
    }

     /* ================================
       Preloader Js Start
    ================================ */

     function loader() {
        $(window).on('load', function() {
            // Animate loader off screen
            $(".preloader").addClass('loaded');                    
            $(".preloader").delay(600).fadeOut();                       
        });
    }
    loader();


    
  })(jQuery); // End jQuery

