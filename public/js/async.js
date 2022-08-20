'use strict';

// Active Dark Mode On Load Page
if (localStorage.getItem("theme_mode") != null) {
    let root = document.documentElement,
        tooltip = document.getElementById("theme-mode"),
        LightTooltip = tooltip.getAttribute("alt-tooltip");

    root.classList.add("dark");
    tooltip.setAttribute("tooltip", LightTooltip);
	document.querySelector('#theme-mode i').classList.remove('fi-rr-moon-stars');
	document.querySelector('#theme-mode i').classList.add('fi-rr-sun');

    setTimeout(() => {
        let table = document.getElementsByTagName("table");
        Array.from(table).forEach(function (el) {
            el.classList.add("table-dark");
        });
    }, 10);
}

// Collaps Menu On Load Page
if (localStorage.getItem("collapse_menu") != null) {
    document.body.classList.add("collapsed");
}


// Add RTL To Swiper Slider Automatically
if (document.dir == "rtl") {
    document.getElementsByClassName("swiper-container")[0].setAttribute("dir", "rtl");
}