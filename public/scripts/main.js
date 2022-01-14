// Swiper Init
function slidesAmountCalc() {
    const mediaQuery = window.matchMedia('(min-width: 768px)')

    if (mediaQuery.matches) {
        return 2
    }
    return 1
}

function freeMode() {
    return slidesAmountCalc() !== 1;
}

const initSlider = () => {
    const swiper = new Swiper(".mySwiper", {
        slidesPerView: slidesAmountCalc(),
        spaceBetween: 30,
        freeMode: freeMode(),

        // If we need pagination
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
        }
    });
}
document.addEventListener("DOMContentLoaded", function(event) {

    initSlider();
});
    window.addEventListener('resize', () => {
        initSlider();
});


// Map Init
function initMap() {
    const userRating = document.querySelector('#map');
    const location = JSON.parse(userRating.dataset.location);

    const lat = parseFloat(location.lat)
    const lng = parseFloat(location.lng)

    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        center: {
            lat,
            lng
        },
    });
    const marker = new google.maps.Marker({
        position: {
            lat,
            lng
        },
        map
    });
}

//Typejs For Type Animation

const options = {
    strings: ["Twig", "CSS", "Java Script", "PHP", "Symfony", "Tailwind", "En een paar plugins"],
    typeSpeed: 80,
    fadeOut: true,
    loop: true,
    showCursor: false
};

const typed = new Typed(".element", options);


