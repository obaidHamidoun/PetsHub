const menuButton = document.querySelector('.menuButton')
const nav = document.querySelector('nav');
const closeButton = document.querySelector('.closeButton');

menuButton.addEventListener('click',function(){
    nav.style = '    animation: slide 1s cubic-bezier(0.85, 0, 0.15, 1) forwards';
})
closeButton.addEventListener('click',function(){
    nav.style = 'animation: Backslide 1s cubic-bezier(0.85, 0, 0.15, 1) forwards';
})
