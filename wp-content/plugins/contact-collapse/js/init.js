document.addEventListener("DOMContentLoaded", function () {
    const faqItems = document.querySelectorAll(".contact-collapse__item");
    faqItems.forEach((item) => {
        let height = item.scrollHeight;
        item.addEventListener('click', event => {
            item.classList.toggle("open-collapse");
            let itemContent = item.querySelectorAll('.contact-collapse__item-content')[0];
            if (item.classList.contains('open-collapse')){
                itemContent.setAttribute('style', 'max-height: ' + height + 'px');
            }else{
                itemContent.setAttribute('style', 'max-height: 0');
            }
        })
})
});