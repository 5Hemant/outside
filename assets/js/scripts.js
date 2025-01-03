document.addEventListener("DOMContentLoaded", () => {
    ctMenuActions();
    ctSlider();
    ctAccordion();
    ctCloseTopbar();
    ctMenuSlider();
    ctNavSlider();

    window.addEventListener("resize", () => {
        const hamburger = document.getElementById("hambuger-mobile");
        const menuWrap = document.querySelector(".menu-wrap");

        if (hamburger) hamburger.classList.remove("active");
        if (menuWrap) menuWrap.classList.remove("active");

        // ctMenuSlider();
    });
});

function ctCloseTopbar() {
    const topBar = document.querySelector(".top-bar-area");
    if (topBar) {
        document.addEventListener("click", (e) => {
            if (e.target.closest(".close-top-bar")) {
                const parent = e.target.closest(".top-bar-area");
                if (parent) parent.style.display = "none"; // Slide up replacement
            }
        });
    }
}

function ctAccordion() {
    const accordions = document.querySelectorAll(".block-slider-accordion");
    accordions.forEach((accordion) => {
        const sections = accordion.querySelectorAll(".accordion-sections li .acc-title");
        sections.forEach((section) => {
            section.addEventListener("click", (e) => {
                e.preventDefault();
                const parent = section.closest("li");
                const accordionContainer = section.closest(".block-slider-accordion");

                if (!parent.classList.contains("active")) {
                    accordionContainer.querySelectorAll(".accordion-sections .active").forEach((activeItem) => {
                        activeItem.classList.remove("active");
                        const content = activeItem.querySelector(".acc-content");
                        if (content) content.style.display = "none"; // Slide up replacement
                    });
                    parent.classList.add("active");
                    const content = parent.querySelector(".acc-content");
                    if (content) content.style.display = "block"; // Slide down replacement

                    const slideNo = parent.getAttribute("data-index");
                    const sliderWrap = accordionContainer.querySelector(".slider-wrap");
                    if (sliderWrap && typeof jQuery !== "undefined" && typeof jQuery.fn.slick === "function") {
                        jQuery(sliderWrap).slick("slickGoTo", slideNo);
                    }
                }
            });
        });
    });
}

function ctMenuActions() {
    const hamburger = document.getElementById("hambuger-mobile");
    if (hamburger) {
        hamburger.addEventListener("click", (e) => {
            e.preventDefault();
            hamburger.classList.toggle("active");
            const menuWrap = document.querySelector(".menu-wrap");
            if (menuWrap) menuWrap.classList.toggle("active");
            const menuSlider = document.querySelector('.menu-slider .menu-slider-wrap .menu-slider-init');
            jQuery(menuSlider).slick("reinit");
        });
    }

    document.querySelectorAll("#primary-menu > .menu-item.has-sub-menu > .item-wrap > a").forEach((link) => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const subMenu = link.closest(".menu-item.has-sub-menu").querySelector(".sub-menu-wrap");
            if (subMenu) subMenu.style.display = "block"; // Slide down replacement
            const menuSlider = document.querySelector('.menu-slider .menu-slider-wrap .menu-slider-init');
            jQuery(menuSlider).slick("reinit");
        });
    });

    document.querySelectorAll(".go-back-btn").forEach((button) => {
        button.addEventListener("click", (e) => {
            e.preventDefault();
            const subMenu = button.closest(".sub-menu-wrap");
            if (subMenu) subMenu.style.display = "none"; // Slide up replacement
            // ctMenuSlider();
        });
    });
}

function ctSlider() {
    const sliderWraps = document.querySelectorAll(".block-slider-accordion .slider-wrap");
    sliderWraps.forEach((sliderWrap) => {
        const count = sliderWrap.querySelectorAll(".item").length;
        const progress = 100 / count;

        const progressBar = sliderWrap.closest(".block-wrapper").querySelector(".progress-bar .progress");
        if (progressBar) progressBar.style.width = `${progress}%`;

        if (typeof jQuery !== "undefined" && typeof jQuery.fn.slick === "function") {
            jQuery(sliderWrap).slick({
                dots: false,
                arrows: false,
                infinite: false,
                autoplay: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                adaptiveHeight: false,
                mobileFirst: true,
                useCSS: false,
            });

            jQuery(sliderWrap).on("afterChange", (event, slick, currentSlide) => {
                const sliderNav = sliderWrap.closest(".block-wrapper").querySelector(".accordion-sections .slider-nav");
                sliderNav.querySelectorAll("li").forEach((li) => li.classList.remove("active"));
                sliderNav.querySelector(`li[data-index="${currentSlide}"]`).classList.add("active");

                const itemProgress = progress * (currentSlide + 1);
                if (progressBar) progressBar.style.width = `${itemProgress}%`;
            });
        }
    });
}

function ctMenuSlider() {
    const sliders = document.querySelectorAll(".layout-slider .layout-slider-wrap .layout-slider-init");
    sliders.forEach((slider) => {
        if (!slider.classList.contains("slick-initialized") && typeof jQuery !== "undefined" && typeof jQuery.fn.slick === "function") {
            jQuery(slider).slick({
                dots: false,
                arrows: false,
                infinite: true,
                autoplay: false,
                slidesToShow: 2,
                slidesToScroll: 1,
                adaptiveHeight: false,
                mobileFirst: true,
                useCSS: false,
                nextArrow: '<button type="button" class="slick-next slick-arrow"><i class="icon icon-next"></i></button>',
                prevArrow: '<button type="button" class="slick-prev slick-arrow"><i class="icon icon-prev"></i></button>',
                responsive: [{
                    breakpoint: 767,
                    settings: {
                        arrows: true,
                        slidesToShow: parseInt(slider.getAttribute("data-show")) || 2,
                        slidesPerRow: 1
                    }
                }]
            });
        }
    });
}

function ctNavSlider() {
    const sliders = document.querySelectorAll(".menu-slider .menu-slider-wrap .menu-slider-init");
    sliders.forEach((slider) => {
        if (!slider.classList.contains("slick-initialized") && typeof jQuery !== "undefined" && typeof jQuery.fn.slick === "function") {
            jQuery(slider).slick({
                dots: false,
                arrows: false,
                infinite: true,
                autoplay: false,
                slidesToShow: 2,
                slidesToScroll: 1,
                adaptiveHeight: false,
                mobileFirst: true,
                useCSS: false,
            });
        }
    });
}