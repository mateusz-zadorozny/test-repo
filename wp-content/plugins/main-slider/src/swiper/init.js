document.addEventListener("DOMContentLoaded", () => {
    const mainSlider = new Swiper('.wp-block-create-block-main-slider .swiper.intro-slider', {
        // Optional parameters
        effect: "fade",
        allowTouchMove: false,

        // If we need pagination
        pagination: {
          el: '.swiper-pagination',
          clickable: true
        },

        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
      
        spaceBetween: 0,
        slidesPerView: 1,
      });
});
