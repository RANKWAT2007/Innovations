document.addEventListener("DOMContentLoaded", () => {

    const cards = document.querySelectorAll(".stats-card");

    cards.forEach((card,index) => {

        card.style.opacity = "0";

        setTimeout(() => {

            card.style.transition = "0.5s";
            card.style.opacity = "1";

        }, index * 200);

    });

});