document.addEventListener('DOMContentLoaded', () => {

    const viewContainer = document.getElementById('view-container');
    const themeToggle = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');
    const navLoginBtn = document.getElementById('nav-login-btn');
    const html = document.documentElement;

    /* =========================
       1️⃣  THEME SYSTEM
    ========================== */

    const initTheme = () => {
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
            html.classList.add('dark');
            if (themeIcon) themeIcon.classList.replace('fa-moon', 'fa-sun');
        }
    };

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                if (themeIcon) themeIcon.classList.replace('fa-sun', 'fa-moon');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                if (themeIcon) themeIcon.classList.replace('fa-moon', 'fa-sun');
            }
        });
    }

    /* =========================
       2️⃣  SPA ROUTER
    ========================== */

    const routes = {
        '#/': 'home-template',
        '#/login': 'login-template'
    };

    const renderView = () => {
        const hash = window.location.hash || '#/';
        const templateId = routes[hash] || 'home-template';
        const template = document.getElementById(templateId);

        if (!template) return;

        viewContainer.innerHTML = '';
        viewContainer.appendChild(template.content.cloneNode(true));

        // Navbar button switch
        if (hash === '#/login') {
            navLoginBtn.textContent = 'BACK TO HOME';
            navLoginBtn.href = '#/';
        } else {
            navLoginBtn.textContent = 'LOG IN';
            navLoginBtn.href = '#/login';
        }

        // Initialise login page logic
        if (hash === '#/login') {
            initLoginLogic();
        }
    };

    window.addEventListener('hashchange', renderView);

    /* =========================
       3️⃣  LOGIN PAGE LOGIC
    ========================== */

    const initLoginLogic = () => {

        // Mask dd/mm/yyyy
        const dobInput = document.getElementById('dob');

        if (dobInput) {
            dobInput.addEventListener('input', function (e) {

                let value = e.target.value.replace(/\D/g, '').slice(0, 8);

                if (value.length >= 5) {
                    value = value.slice(0, 2) + '/' +
                            value.slice(2, 4) + '/' +
                            value.slice(4);
                } 
                else if (value.length >= 3) {
                    value = value.slice(0, 2) + '/' +
                            value.slice(2);
                }

                e.target.value = value;
            });
        }

        // IMPORTANT ⚠️
        // On NE met PAS preventDefault()
        // Pour laisser le formulaire envoyer au PHP
    };

    /* =========================
       INITIAL LOAD
    ========================== */

    initTheme();
    renderView();

});
