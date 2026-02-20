document.addEventListener('DOMContentLoaded', () => {

    const viewContainer = document.getElementById('view-container');
    const themeToggle = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');
    const navLoginBtn = document.getElementById('nav-login-btn');
    const html = document.documentElement;

    // Theme
    const initTheme = () => {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            html.classList.add('dark');
            themeIcon.classList.replace('fa-moon', 'fa-sun');
        }
    };

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                themeIcon.classList.replace('fa-sun', 'fa-moon');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                themeIcon.classList.replace('fa-moon', 'fa-sun');
            }
        });
    }

    // Router
    const routes = {
        '#/': 'home-template',
        '#/login': 'login-template'
    };

    const renderView = () => {
        const hash = window.location.hash || '#/';
        const templateId = routes[hash] || 'home-template';
        const template = document.getElementById(templateId);

        viewContainer.innerHTML = '';
        viewContainer.appendChild(template.content.cloneNode(true));

        if (hash === '#/login') {
            navLoginBtn.textContent = 'BACK TO HOME';
            navLoginBtn.href = '#/';
            initLoginLogic();
        } else {
            navLoginBtn.textContent = 'LOG IN';
            navLoginBtn.href = '#/login';
        }
    };

    window.addEventListener('hashchange', renderView);

    // Login logic (mask only — no preventDefault)
    const initLoginLogic = () => {
        const dobInput = document.getElementById('dob');

        if (dobInput) {
            dobInput.addEventListener('input', function(e) {
                let v = e.target.value.replace(/\D/g, '').slice(0, 8);
                if (v.length >= 5) {
                    v = v.slice(0, 2) + '/' + v.slice(2, 4) + '/' + v.slice(4);
                } else if (v.length >= 3) {
                    v = v.slice(0, 2) + '/' + v.slice(2);
                }
                e.target.value = v;
            });
        }
    };

    initTheme();
    renderView();
});
