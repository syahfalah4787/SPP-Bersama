import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// ===== Smooth Page Transitions =====
document.addEventListener('DOMContentLoaded', () => {
    const TRANSITION_MS = 250;

    // Intercept link clicks for smooth exit
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a[href]');
        if (!link) return;

        const href = link.getAttribute('href');

        // Skip: external links, anchors, new-tab, javascript:, #, mailto, etc.
        if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:'))  return;
        if (link.target === '_blank' || link.hasAttribute('download')) return;
        if (e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;
        if (link.origin && link.origin !== window.location.origin) return;

        e.preventDefault();
        document.body.classList.add('page-leaving');
        setTimeout(() => { window.location.href = href; }, TRANSITION_MS);
    });

    // Intercept form submissions for smooth exit
    document.addEventListener('submit', (e) => {
        const form = e.target;
        if (form.dataset.noTransition) return;

        document.body.classList.add('page-leaving');
        e.preventDefault();
        setTimeout(() => { form.submit(); }, TRANSITION_MS);
    }, true);

    // Handle browser back/forward — re-animate entry
    window.addEventListener('pageshow', (e) => {
        if (e.persisted) {
            document.body.classList.remove('page-leaving');
            document.body.style.animation = 'none';
            requestAnimationFrame(() => {
                document.body.style.animation = '';
            });
        }
    });
});
