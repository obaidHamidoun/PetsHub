const menuButton = document.querySelector('.menuButton');
const menu = document.querySelector('.menu');
const close = document.querySelector('.close');
const HomeMenu = document.querySelector('.HomeMenu');

function toggleMenu() {
    if (window.innerWidth <= 700) {
        menu.classList.toggle('show');
        menu.style = 'opacity:0';
    }
}

// Show/hide menu when the menu button is clicked
menuButton.addEventListener('click', toggleMenu);
menuButton.addEventListener('click', function () {
    menu.style = 'animation: fade 0.5s cubic-bezier(0.85, 0, 0.15, 1) forwards';
    close.style = 'animation: scaleout 0.1s cubic-bezier(0.85, 0, 0.15, 1) reverse';

    const pagesOfMenu = document.querySelectorAll('.pagesOfMenu button');

    pagesOfMenu.forEach((button, index) => {
        setTimeout(() => {
            const delay = (index + 1) * 200 + 200; // Calculate delay for each button
            button.style.animation = `menuPagesDis ${delay / 1000}s cubic-bezier(0.85, 0, 0.15, 1) forwards`;
        }, 100 + index * 100);
    });

})

// Hide menu when the screen width becomes larger than 950px
window.addEventListener('resize', () => {
    if (window.innerWidth > 700) {
        menu.classList.remove('show');
    }
});

close.addEventListener('click', function () {
    close.style = 'animation: scaleout 0.1s cubic-bezier(0.85, 0, 0.15, 1)'
    menu.style = 'animation: Backfade 0.5s cubic-bezier(0.85, 0, 0.15, 1) forwards';
    setTimeout(function () {
        menu.classList.remove('show');
    }, 500);

})

