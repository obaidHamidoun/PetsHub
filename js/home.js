const menuButton = document.querySelector('.menuButton');
const nav = document.querySelector('nav');
const closeButton = document.querySelector('.closeButton');
const pages = document.querySelectorAll('.page');
const PagesIcons = document.querySelectorAll('.PageIcon');

menuButton.addEventListener('click', function() {
    nav.style.animation = 'slide 1s cubic-bezier(0.85, 0, 0.15, 1) forwards';
});

closeButton.addEventListener('click', function() {
    nav.style.animation = 'Backslide 1s cubic-bezier(0.85, 0, 0.15, 1) forwards';
});


function updateInfoContent() {
    const infoElement = document.querySelector('.InfoDC');
    if (window.innerWidth <= 800) {
        infoElement.innerHTML = 'PetsHub’s Daycare provides reliable and high-quality pet care, helping you manage your busy schedule. Sign up today to ensure your pet gets the attention they deserve.';
    } else {
        infoElement.innerHTML = 'Struggling to find time for your pet\'s care? At PetsHub’s Daycare, we\'ve got you covered. Count on us for top-notch care while you tackle your busy schedule. Join our daycare community today to ensure your pet gets the attention they deserve.';
    }
}

updateInfoContent();
window.addEventListener('resize', updateInfoContent);
