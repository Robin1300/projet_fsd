'use strict';

document.addEventListener('DOMContentLoaded', () => {
    let descriptions = document.querySelectorAll(".description");

    if (descriptions) {
        descriptions.forEach(description => {
            description.addEventListener("click", () => {
                description.nextElementSibling.classList.toggle("d-none");
            });
        })
    }
});
