let searchOpen = document.getElementById('mobile-search-open');
let searchClose = document.getElementById('mobile-search-close');
let searchForm = document.querySelector('form.search');
searchOpen.addEventListener('click', () => {
    searchForm.style.display = 'grid';
});
searchClose.addEventListener('click', () => {
    searchForm.style.display = 'none';
});