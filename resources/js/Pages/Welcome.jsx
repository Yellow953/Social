import { usePage } from '@inertiajs/react';
import Header from '../components/Header';
import Footer from '../components/Footer';
import HomePage from '../components/pages/HomePage';
import AboutPage from '../components/pages/AboutPage';
import AcademiquePage from '../components/pages/AcademiquePage';
import CalculatricePage from '../components/pages/CalculatricePage';

export default function Welcome({ page = 'home' }) {
    const { url } = usePage();
    
    // Get active tab from URL path
    const getActiveTab = () => {
        if (url === '/about') return 'about';
        if (url === '/academique') return 'academique';
        if (url === '/calculatrice') return 'calculatrice';
        return '';
    };

    const activeTab = getActiveTab();

    const renderPage = () => {
        switch (page) {
            case 'about':
                return <AboutPage />;
            case 'academique':
                return <AcademiquePage />;
            case 'calculatrice':
                return <CalculatricePage />;
            default:
                return <HomePage />;
        }
    };

    return (
        <div className="min-h-screen bg-white">
            <Header activeTab={activeTab} />
            
            {/* Main Content */}
            <div>
                {renderPage()}
            </div>

            <Footer />
        </div>
    );
}
