document.addEventListener('DOMContentLoaded', function() {
    const mainMenu = document.querySelector('.nav-container');
    const closeMenu = document.querySelector('.closeMenu');
    const openMenu = document.querySelector('.burger-menu');
    const menu_items = document.querySelectorAll('nav .nav-container a');

    openMenu.addEventListener('click', show);
    closeMenu.addEventListener('click', close);

    menu_items.forEach(item => {
        item.addEventListener('click', function() {
            close();
        });
    });

    function show() {
        mainMenu.style.display = 'flex';
        mainMenu.style.top = '0';
    }

    function close() {
        mainMenu.style.top = '-100%';
    }
});