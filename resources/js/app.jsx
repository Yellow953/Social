import './bootstrap';
import '../css/app.css';
import React from 'react';
import { createRoot } from 'react-dom/client';
import Welcome from './components/Welcome';

const rootElement = document.getElementById('welcome-root');

if (rootElement) {
    const root = createRoot(rootElement);
    root.render(
        <React.StrictMode>
            <Welcome />
        </React.StrictMode>
    );
} else {
    console.error('Welcome root element not found');
}
