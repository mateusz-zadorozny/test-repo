document.addEventListener("DOMContentLoaded", () => {
    const imagesCarousel = new Swiper('.swiper.images-carousel', {
      navigation: {
        nextEl: '.swiper.images-carousel .carousel-button-next',
        prevEl: '.swiper.images-carousel .carousel-button-prev',
      },
      slidesPerView: "auto",
      spaceBetween: 30,
      grabCursor: true,
      pagination: {
          el: ".carousel-gallery .slider-progress",
          type: "progressbar",
      },
      slidesPerView: 'auto',
    });
});