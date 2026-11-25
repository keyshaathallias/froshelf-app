import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Mobile More / Account Bottom Sheet (untuk layar < lg / 360px)
    const mobileSheet = document.getElementById('mobile-menu-sheet');
    const mobileSheetBackdrop = document.getElementById('mobile-menu-backdrop');
    const openSheetButtons = document.querySelectorAll('[data-open-mobile-sheet]');
    const closeSheetButtons = document.querySelectorAll('[data-close-mobile-sheet]');

    const setSheetState = (open) => {
        if (!mobileSheet || !mobileSheetBackdrop) return;
        mobileSheet.classList.toggle('translate-y-full', !open);
        mobileSheet.classList.toggle('translate-y-0', open);
        mobileSheet.setAttribute('aria-hidden', String(!open));
        mobileSheetBackdrop.classList.toggle('hidden', !open);
        openSheetButtons.forEach((btn) => btn.setAttribute('aria-expanded', String(open)));
        document.body.classList.toggle('overflow-hidden', open);
    };

    openSheetButtons.forEach((btn) => btn.addEventListener('click', () => setSheetState(true)));
    closeSheetButtons.forEach((btn) => btn.addEventListener('click', () => setSheetState(false)));
    mobileSheetBackdrop?.addEventListener('click', () => setSheetState(false));

    // 2. Right-Edge Slide-Over Guidance Drawer (FR-00C)
    const guidanceDrawer = document.getElementById('guidance-drawer');
    const guidanceBackdrop = document.getElementById('guidance-drawer-backdrop');
    const openGuidanceButtons = document.querySelectorAll('[data-open-guidance]');
    const closeGuidanceButtons = document.querySelectorAll('[data-close-guidance]');

    const setGuidanceState = (open) => {
        if (!guidanceDrawer || !guidanceBackdrop) return;
        guidanceDrawer.classList.toggle('translate-x-full', !open);
        guidanceDrawer.classList.toggle('translate-x-0', open);
        guidanceDrawer.setAttribute('aria-hidden', String(!open));
        guidanceBackdrop.classList.toggle('hidden', !open);
        openGuidanceButtons.forEach((btn) => btn.setAttribute('aria-expanded', String(open)));
        document.body.classList.toggle('overflow-hidden', open);
    };

    openGuidanceButtons.forEach((btn) => btn.addEventListener('click', () => setGuidanceState(true)));
    closeGuidanceButtons.forEach((btn) => btn.addEventListener('click', () => setGuidanceState(false)));
    guidanceBackdrop?.addEventListener('click', () => setGuidanceState(false));

    // Tutup overlay dengan Escape
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setSheetState(false);
            setGuidanceState(false);
        }
    });

    // 3. Toggle lihat/sembunyikan kata sandi di halaman Login
    document.querySelectorAll('[data-toggle-password]').forEach((button) => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-toggle-password');
            const input = targetId ? document.getElementById(targetId) : null;
            if (!input) return;

            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            button.setAttribute('aria-pressed', String(isPassword));
            button.setAttribute('aria-label', isPassword ? 'Sembunyikan kata sandi' : 'Lihat kata sandi');

            button.querySelector('[data-eye-open]')?.classList.toggle('hidden', isPassword);
            button.querySelector('[data-eye-closed]')?.classList.toggle('hidden', !isPassword);
        });
    });

    // 4. Isi cepat akun demo pada halaman Login
    document.querySelectorAll('[data-demo-email]').forEach((button) => {
        button.addEventListener('click', () => {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            if (emailInput) {
                emailInput.value = button.getAttribute('data-demo-email') || '';
                emailInput.focus();
            }
            if (passwordInput) {
                passwordInput.value = button.getAttribute('data-demo-password') || '';
            }
        });
    });

    // 5. Segmented Role Switcher pada halaman Pusat Panduan (/guidance)
    const guidanceTabs = document.querySelectorAll('[data-guidance-tab]');
    const guidancePanels = document.querySelectorAll('[data-guidance-panel]');

    if (guidanceTabs.length > 0 && guidancePanels.length > 0) {
        const activateTab = (role) => {
            guidanceTabs.forEach((tab) => {
                const isActive = tab.getAttribute('data-guidance-tab') === role;
                tab.setAttribute('aria-selected', String(isActive));
                tab.classList.toggle('bg-white', isActive);
                tab.classList.toggle('text-slate-900', isActive);
                tab.classList.toggle('shadow-xs', isActive);
                tab.classList.toggle('text-slate-600', !isActive);
                tab.classList.toggle('hover:text-slate-900', !isActive);
            });

            guidancePanels.forEach((panel) => {
                const isActive = panel.getAttribute('data-guidance-panel') === role;
                panel.classList.toggle('hidden', !isActive);
            });
        };

        guidanceTabs.forEach((tab) => {
            tab.addEventListener('click', () => {
                const role = tab.getAttribute('data-guidance-tab');
                if (role) activateTab(role);
            });
        });
    }

    // 6. Accordion FAQ pada halaman Pusat Panduan
    document.querySelectorAll('[data-faq-trigger]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const contentId = trigger.getAttribute('aria-controls');
            const content = contentId ? document.getElementById(contentId) : null;
            const icon = trigger.querySelector('[data-faq-icon]');
            if (!content) return;

            const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
            trigger.setAttribute('aria-expanded', String(!isExpanded));
            content.classList.toggle('hidden', isExpanded);
            icon?.classList.toggle('rotate-180', !isExpanded);
        });
    });

    // 7. Tombol tutup notifikasi flash
    document.querySelectorAll('[data-dismiss]').forEach((button) => {
        button.addEventListener('click', () => {
            button.closest('[data-dismissible]')?.remove();
        });
    });
});
