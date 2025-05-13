const btn = document.querySelector('.burger__menu')
const menu = document.querySelector('.right__menu')

const span1 = document.querySelector('.burger__menu-span1')
const span2 = document.querySelector('.burger__menu-span2')
const span3 = document.querySelector('.burger__menu-span3')


btn.addEventListener('click', () => {
  menu.classList.toggle('right__menu-active')
  span1.classList.toggle('burger__menu-span1-active')
  span2.classList.toggle('burger__menu-span2-active')
  span3.classList.toggle('burger__menu-span3-active')
})


