import { usePage, Head } from '@inertiajs/react';
import Header from '../components/Header';
import Footer from '../components/Footer';
import HomePage from '../components/pages/HomePage';
import AboutPage from '../components/pages/AboutPage';
import AcademiquePage from '../components/pages/AcademiquePage';
import CalculatricePage from '../components/pages/CalculatricePage';

const PAGE_SEO = {
    home: {
        title: 'ESIB SOCIAL',
        description: 'Your comprehensive learning platform for social sciences. Access courses, sessions, and materials organized by subject.',
    },
    about: {
        title: 'About',
        description: 'Learn about ESIB SOCIAL - our mission, vision, and how we empower students with organized learning resources for academic excellence.',
    },
    academique: {
        title: 'Académique',
        description: 'Explore academic resources, courses, and summaries for social sciences on ESIB SOCIAL.',
    },
    calculatrice: {
        title: 'Calculatrice',
        description: 'Use the built-in grade calculator and academic tools on ESIB SOCIAL.',
    },
};

export default function Welcome({ page = 'home' }) {
    const { url } = usePage();
    const seo = PAGE_SEO[page] || PAGE_SEO.home;
    const title = String(seo?.title ? `${seo.title} | ESIB SOCIAL` : 'ESIB SOCIAL - Learning Platform for Social Sciences');
    const description = String(seo?.description ?? PAGE_SEO.home.description ?? '');

    // Get active tab from URL path
    const getActiveTab = () => {
        if (url === '/about') return 'about';
        if (url === '/academique') return 'academique';
        if (url === '/calculatrice') return 'calculatrice';
        return '';
    };

    const activeTab = getActiveTab();

    const { props } = usePage();
    const homepageSlides = props.homepageSlides ?? [];

    const renderPage = () => {
        switch (page) {
            case 'about':
                return <AboutPage />;
            case 'academique':
                return <AcademiquePage />;
            case 'calculatrice':
                return <CalculatricePage />;
            default:
                return <HomePage homepageSlides={homepageSlides} />;
        }
    };

    return (
        <div className="min-h-screen bg-white">
            <Head>
                <title>{title}</title>
                <meta name="description" content={description} />
            </Head>
            <Header activeTab={activeTab} />
            
            {/* Main Content */}
            <div>
                {renderPage()}
            </div>

            <Footer />
        </div>
    );
}
