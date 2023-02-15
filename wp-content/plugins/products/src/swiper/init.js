document.addEventListener("DOMContentLoaded", () => {
    const productsCarousel = new Swiper('.swiper.products-carousel', {
        // If we need pagination
        pagination: {
          type: "progressbar",
          el: '.progress-pagination',
          clickable: true
        },
        navigation: {
          nextEl: '.swiper.products-carousel .carousel-button-next',
          prevEl: '.swiper.products-carousel .carousel-button-prev',
        },
        slidesPerView: 4,
        watchSlidesProgress: true,

        spaceBetween: 24,
        breakpoints: {
          320: {
            slidesPerView: 'auto',
          },
          992: {
            slidesPerView: 3,
          },
          1400: {
            slidesPerView: 4,
          }
        }
      });
});