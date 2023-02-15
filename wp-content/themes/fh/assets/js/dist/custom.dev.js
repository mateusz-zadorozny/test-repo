"use strict";

var nav = document.querySelector('.site-header');
var navTop = nav.offsetTop + 120;

function stickyNavigation() {
  if (window.scrollY >= navTop) {
    document.body.classList.add('fixed-nav');
  } else {
    document.body.style.paddingTop = 0;
    document.body.classList.remove('fixed-nav');
  }
}

window.addEventListener('scroll', stickyNavigation);