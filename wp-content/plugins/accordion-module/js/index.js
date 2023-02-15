document.addEventListener("DOMContentLoaded", function () {
        const faqItems = document.querySelectorAll(".accordion__item");
        faqItems.forEach((item) => {
            let height = item.scrollHeight;
            item.addEventListener('click', event => {
                item.classList.toggle("open-accordion-item");
                let itemContent = item.querySelectorAll('.accordion__item-content')[0];
                if (item.classList.contains('open-accordion-item')){
                    itemContent.setAttribute('style', 'max-height: ' + height + 'px');
                }else{
                    itemContent.setAttribute('style', 'max-height: 0');
                }
            })
    })
});