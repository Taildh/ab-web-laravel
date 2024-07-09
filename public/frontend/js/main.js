const screenWidth = screen.width;

function scrollToTop() {
    window.scrollTo(0, 0);
    hideNavSlide();
}

function scrollToCenter(id) {
    const element = document.getElementById(id);
    const elementRect = element.getBoundingClientRect();
    const elementHeight = elementRect.height;
    const viewportHeight = window.innerHeight;
    const offset = elementRect.top + window.pageYOffset;

    window.scrollTo({
        top: offset,
        behavior: "smooth",
    });

    hideNavSlide();
}

function closeModal() {
    const modal = $("#projectDetailModal");

    modal.hide();
}

function expandSlide() {
    const screenWidth = screen.width;

    if (screenWidth <= 576) {
        rotateScreen();
        return;
    }

    let slider = document.getElementById("projectSlider");

    if (!document.fullscreenElement) {
        if (slider.requestFullscreen) {
            slider.requestFullscreen();
        } else if (slider.mozRequestFullScreen) {
            // Firefox
            slider.mozRequestFullScreen();
        } else if (slider.webkitRequestFullscreen) {
            // Chrome, Safari and Opera
            slider.webkitRequestFullscreen();
        } else if (slider.msRequestFullscreen) {
            // IE/Edge
            slider.msRequestFullscreen();
        }
    }
}

function exitFullScreen() {
    if (document.exitFullscreen) {
        document.exitFullscreen();
    } else if (document.mozCancelFullScreen) {
        // Firefox
        document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
        // Chrome, Safari and Opera
        document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) {
        // IE/Edge
        document.msExitFullscreen();
    }
}

function hideNavSlide() {
    const nav = document.querySelector(".nav");
    const logo = document.querySelector(".image-logo");
    const toggleMenu = document.querySelector(".toggle-menu");

    toggleMenu.classList.remove("close-toggle-menu");
    nav.classList.remove("nav-active");
    logo.classList.remove("image-logo-hidden");
}

// Nav Mobile
const navSlide = () => {
    const toggleMenu = document.querySelector(".toggle-menu");
    const nav = document.querySelector(".nav");
    const logo = document.querySelector(".image-logo");

    toggleMenu.addEventListener("click", function () {
        nav.classList.toggle("nav-active");

        toggleMenu.classList.toggle("close-toggle-menu");
        logo.classList.toggle("image-logo-hidden");
    });
};

function handleModalDisplay(element) {
    if ($(element).hasClass("project-item-active")) {
        const modal = $("#projectDetailModal");
        modal.show();
    }
}

// Function to handle adding the active class to project items
function handleProjectItemActivation(element) {
    $(".project-item").removeClass("project-item-active");
    $(element).addClass("project-item-active");
}

function setupHandlers() {
    if ($(window).width() < 576) {
        $(".project-item")
            .off("mouseenter mouseout")
            .on("click", function () {
                handleProjectItemActivation(this);
            });
    } else {
        $(".project-item").hover(
            function () {
                handleProjectItemActivation(this);
            },
            function () {
                $(".project-item").removeClass("project-item-active");
            }
        );
    }
}


document.addEventListener("fullscreenchange", function () {
    let slider = document.getElementById("projectSlider");
    if (!document.fullscreenElement) {
        slider.classList.remove("slider-image-fullscreen");
        // Exited full-screen mode

        $("#projectSlider").hide();
        $("#mainImageWrapper").show();
    } else {
        slider.classList.add("slider-image-fullscreen");
        // Entered full-screen mode
        $("#projectSlider").show();
        $("#mainImageWrapper").hide();

    }
});

document.addEventListener("DOMContentLoaded", function () {
    const scrollButton = document.getElementById("scrollToTopBtn");
    let scrollTimeOut;

    function showScrollButton() {
        scrollButton.style.display = "block";
        setTimeout(() => {
            scrollButton.classList.add("show-button");
            scrollButton.classList.remove("hide-button");
        }, 10); // Short delay to ensure display:block takes effect
    }

    function hideScrollButton() {
        scrollButton.classList.remove("show-button");
        scrollButton.classList.add("hide-button");

        setTimeout(() => {
            scrollButton.style.display = "none";
        }, 500); // Match the duration of the CSS transition
    }

    window.addEventListener("scroll", function () {
        clearTimeout(scrollTimeOut);
        showScrollButton();

        scrollTimeOut = setTimeout(hideScrollButton, 2000);
    });
});



const bannerPath = 'storage/'

$(".project-item").on("click", function () {
    handleModalDisplay(this);
    let id = $(this).data('id');
    $.ajax({
        url: '/get-constructions',
        method: "GET",
        data: {
            id: id
        },
        success(response) {
            $(".project-detail .title").text(response.title);
            $(".project-detail .area").text(response.area);
            $(".project-detail .description").text(response.description);


            const firstImage = response.images[0];
            $("#mainImage").attr('src', bannerPath + firstImage.path)

            updateImages(response.images)
            updateCarousel(response.images)
        }

    })

    $(".list-images").slick("setPosition");
});

function updateImages(newImages) {
    $('.list-images').slick('slickRemove', null, null, true);

    newImages.forEach(function(image) {
        var newSlide = '<div><img src="' + bannerPath + image.path + '" alt="" class="slick-item"></div>';
        $('.list-images').slick('slickAdd', newSlide);
    });

    // Refresh Slick to reinitialize the slides
    $('.list-images').slick('setPosition');
}

function updateCarousel(newImages) {
    var $carouselInner = $('.carousel-inner');
    $carouselInner.empty();  // Clear existing items

    newImages.forEach(function(image, index) {
        var isActive = index === 0 ? 'active' : '';
        var newItem = `
                <div class="carousel-item ${isActive}">
                    <img src="${bannerPath + image.path}" class="project-detail-image d-block" alt="..." onclick="expandSlide()">
                </div>
            `;
        $carouselInner.append(newItem);
    });

    // Refresh the carousel (reinitialize if necessary)
    $('#carouselExample').carousel(0);
}


// Animate Text Banner Mobile
const animatedText = () => {
    const screenWidth = screen.width;

    if (screenWidth <= 576) {
        setTimeout(function () {
            document
                .querySelector(".banner-content .heading")
                .classList.add("text-animated");
            document
                .querySelector(".banner-content .desc")
                .classList.add("text-animated");
        }, 2000);
    }
};

// Lazy load Mobile
document.addEventListener("DOMContentLoaded", function () {
    const screenWidth = screen.width;

    if (screenWidth > 576) {
        return;
    }

    const fadeElements = document.querySelectorAll(".section-fade-in");

    function checkViewport() {
        fadeElements.forEach((element) => {
            if (isElementInViewport(element)) {
                element.classList.add("visible");
            } else {
                element.classList.remove("visible");
            }
        });
    }

    function isElementInViewport(el) {
        const rect = el.getBoundingClientRect();
        const viewportHeight =
            window.innerHeight || document.documentElement.clientHeight;

        // Calculate the bottom 1/3 of the viewport
        const viewportThreshold = viewportHeight - viewportHeight / 3;

        return rect.top <= viewportThreshold;
    }

    // Initial check when page loads
    checkViewport();

    // Check when scrolling
    document.addEventListener("scroll", checkViewport);
});

document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelectorAll(".nav .scroll-link");

    menuItems.forEach((item) => {
        item.addEventListener("click", function () {
            menuItems.forEach((i) => i.classList.remove("active"));

            this.classList.add("active");
        });
    });
});

function rotateScreen() {
    document.body.classList.toggle('rotated');
}

animatedText();
navSlide();
setupHandlers();

$(window).resize(function () {
    setupHandlers();
});

document.addEventListener("DOMContentLoaded", function () {
    const mainImage = document.getElementById("mainImage");

    // Use event delegation on the parent of .slick-item elements
    document.querySelector(".list-images").addEventListener("mouseenter", function (event) {
        if (event.target.classList.contains("slick-item")) {

            const thumbnails = document.querySelectorAll(".slick-item");

            thumbnails.forEach((item) => {
                item.classList.remove("hovered");
            });

            const newSrc = event.target.getAttribute("src");
            mainImage.setAttribute("src", newSrc);

            event.target.classList.add("hovered");
        }
    }, true);  // Use capturing phase to ensure it works with dynamically added elements
});
