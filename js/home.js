const sidebar = document.querySelector('.sidebar');
const menuButton = document.querySelector('.menuButton');

menuButton.addEventListener('click', function () {
    sidebar.style = 'animation:slide 1s ease forwards';
})
