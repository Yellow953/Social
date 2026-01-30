import './bootstrap';
import '../css/app.css';
import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

const appName = import.meta.env.VITE_APP_NAME || 'ESIB SOCIAL';

// Only initialize Inertia if the root element exists and has the data-page attribute
// This prevents errors on Blade-only pages (like admin pages)
const el = document.getElementById('app');
if (el && el.hasAttribute('data-page')) {
    try {
        createInertiaApp({
            title: (title) => (title ? `${title} | ${appName}` : `${appName} - Learning Platform for Social Sciences`),
            resolve: (name) => resolvePageComponent(`./Pages/${name}.jsx`, import.meta.glob('./Pages/**/*.jsx')),
            setup({ el, App, props }) {
                const root = createRoot(el);
                root.render(<App {...props} />);
            },
            progress: {
                color: '#ec682a',
            },
        });
    } catch (error) {
        console.error('Failed to initialize Inertia app:', error);
    }
}
