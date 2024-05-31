const searchIcon = document.querySelector('.searchIcon')
const searchPage= document.querySelector('.searchPage')
const searchButton = document.querySelector('.closeSearchButton')

searchIcon.addEventListener('click',function(){
    searchPage.style.animation = 'searchslide 0.8s cubic-bezier(0.85, 0, 0.15, 1) forwards';
})
searchButton.addEventListener('click',function(){
    searchPage.style.animation = 'searchslideBack 0.8s cubic-bezier(0.85, 0, 0.15, 1) forwards'
})
