"use strict";

// ============================================
// Back to Top - show/hide on scroll
// ============================================
const backToTop = document.querySelector(".back-to-top");

if (backToTop) {
  window.addEventListener("scroll", () => {
    if (window.scrollY > 300) {
      backToTop.classList.add("is-visible");
    } else {
      backToTop.classList.remove("is-visible");
    }
  });
}
