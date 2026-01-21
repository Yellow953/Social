import { Link } from '@inertiajs/react';
import { useEffect, useState } from 'react';

export default function Welcome() {
    const [scrolled, setScrolled] = useState(false);
    const [visible, setVisible] = useState(false);

    useEffect(() => {
        const handleScroll = () => {
            setScrolled(window.scrollY > 50);
        };
        window.addEventListener('scroll', handleScroll);
        setVisible(true);
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    const features = [
        {
            icon: 'bi-diagram-3',
            title: 'Organized by Subject',
            description: 'Courses organized by subject matter, not just by year. Easy to find what you need when you need it.',
            delay: '0',
            color: 'from-blue-500 to-blue-600'
        },
        {
            icon: 'bi-calculator',
            title: 'Built-in Calculator',
            description: 'No need to switch apps. Use our built-in calculator directly on the platform for your convenience.',
            delay: '100',
            color: 'from-purple-500 to-purple-600'
        },
        {
            icon: 'bi-phone',
            title: 'Synchronized Content',
            description: 'All your courses, sessions, and materials synchronized across devices. Access anywhere, anytime.',
            delay: '200',
            color: 'from-green-500 to-green-600'
        },
        {
            icon: 'bi-shield-lock',
            title: 'Secure & Protected',
            description: 'Advanced security with watermarking, screenshot detection, and single-device access protection.',
            delay: '300',
            color: 'from-red-500 to-red-600'
        },
        {
            icon: 'bi-bell',
            title: 'Real-time Notifications',
            description: 'Get notified instantly when new sessions or courses are available. Never miss an update.',
            delay: '400',
            color: 'from-yellow-500 to-yellow-600'
        },
        {
            icon: 'bi-cloud-check',
            title: 'No Downloads Required',
            description: 'Everything is accessible online. No need to download files. Stream and learn directly from your browser.',
            delay: '500',
            color: 'from-indigo-500 to-indigo-600'
        }
    ];

    const stats = [
        { number: '100+', label: 'Courses', icon: 'bi-book', color: 'text-blue-600' },
        { number: '50+', label: 'Sessions', icon: 'bi-play-circle', color: 'text-purple-600' },
        { number: '24/7', label: 'Access', icon: 'bi-clock', color: 'text-green-600' },
        { number: '1000+', label: 'Students', icon: 'bi-people', color: 'text-[#ec682a]' }
    ];

    const steps = [
        {
            number: '01',
            title: 'Sign Up',
            description: 'Create your free account in seconds with just your email and phone number.',
            icon: 'bi-person-plus'
        },
        {
            number: '02',
            title: 'Choose Your Path',
            description: 'Select your year and major to access personalized content organized by subject.',
            icon: 'bi-diagram-3'
        },
        {
            number: '03',
            title: 'Start Learning',
            description: 'Access courses, sessions, and materials all in one place, synchronized across devices.',
            icon: 'bi-rocket-takeoff'
        }
    ];

    return (
        <div className="min-h-screen bg-white">
            {/* Navigation */}
            <nav
                className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300 ${
                    scrolled
                        ? 'bg-white/95 backdrop-blur-md shadow-lg'
                        : 'bg-white/90 backdrop-blur-sm'
                }`}
            >
                <div className="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex items-center justify-between h-20">
                        <Link
                            href="/"
                            className="flex items-center space-x-2 group no-underline"
                        >
                            <div className="w-10 h-10 bg-gradient-to-br from-[#ec682a] to-[#d45a20] rounded-xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                <i className="bi bi-book-fill text-white text-xl"></i>
                            </div>
                            <span className="text-2xl font-bold text-[#5c5c5c]">
                                Social Plus
                            </span>
                        </Link>
                        <div className="hidden md:flex items-center space-x-6">
                            <a
                                href="#features"
                                className="text-[#5c5c5c] font-medium hover:text-[#ec682a] transition-colors duration-300 no-underline"
                                style={{ color: '#5c5c5c' }}
                            >
                                Features
                            </a>
                            <a
                                href="#how-it-works"
                                className="text-[#5c5c5c] font-medium hover:text-[#ec682a] transition-colors duration-300 no-underline"
                                style={{ color: '#5c5c5c' }}
                            >
                                How It Works
                            </a>
                            <a
                                href="#subscription"
                                className="text-[#5c5c5c] font-medium hover:text-[#ec682a] transition-colors duration-300 no-underline"
                                style={{ color: '#5c5c5c' }}
                            >
                                Pricing
                            </a>
                            <a
                                href="/login"
                                className="text-[#5c5c5c] font-medium hover:text-[#ec682a] transition-colors duration-300 no-underline"
                                style={{ color: '#5c5c5c' }}
                            >
                                Login
                            </a>
                            <a
                                href="/register"
                                className="px-5 py-2 bg-gradient-to-r from-[#ec682a] to-[#d45a20] text-white font-semibold rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300 no-underline"
                            >
                                Get Started
                            </a>
                        </div>
                        <button className="md:hidden text-[#5c5c5c]">
                            <i className="bi bi-list text-2xl"></i>
                        </button>
                    </div>
                </div>
            </nav>

            {/* Hero Section */}
            <section className="relative min-h-screen flex items-center justify-center overflow-hidden pt-20">
                {/* Gradient Background - Orange Gradient */}
                <div
                    className="absolute inset-0"
                    style={{
                        background: 'linear-gradient(135deg, #ec682a 0%, #d45a20 100%)'
                    }}
                ></div>

                {/* White Decorative Circles - Matching Login Page Style */}
                <div className="absolute inset-0" style={{ opacity: 0.1 }}>
                    <div className="absolute" style={{ top: '10%', left: '10%', width: '200px', height: '200px', background: 'white', borderRadius: '50%' }}></div>
                    <div className="absolute" style={{ top: '60%', right: '15%', width: '150px', height: '150px', background: 'white', borderRadius: '50%' }}></div>
                    <div className="absolute" style={{ bottom: '20%', left: '20%', width: '100px', height: '100px', background: 'white', borderRadius: '50%' }}></div>
                    <div className="absolute" style={{ top: '30%', right: '25%', width: '120px', height: '120px', background: 'white', borderRadius: '50%' }}></div>
                    <div className="absolute" style={{ bottom: '40%', right: '10%', width: '180px', height: '180px', background: 'white', borderRadius: '50%' }}></div>
                </div>

                <div className="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div className="grid lg:grid-cols-2 gap-12 items-center">
                        {/* Left Content */}
                        <div
                            className={`space-y-6 transform transition-all duration-1000 ${
                                visible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'
                            }`}
                        >
                            <div className="inline-block">
                                <span className="px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-semibold border border-white/30">
                                    🎓 Your Learning Platform
                                </span>
                            </div>
                            <h1 className="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight text-white">
                                Learn Social Sciences
                                <span className="block mt-2">
                                    Your Way
                                </span>
                            </h1>
                            <p className="text-xl text-white/90 leading-relaxed">
                                Access courses, sessions, and materials organized by subject. Everything you need for academic success.
                            </p>
                            <div className="flex flex-wrap gap-4">
                                <a
                                    href="/register"
                                    className="group px-8 py-4 bg-gradient-to-r from-[#ec682a] to-[#d45a20] text-white font-bold rounded-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 transform flex items-center space-x-2 no-underline"
                                >
                                    <i className="bi bi-rocket-takeoff text-xl group-hover:translate-x-1 transition-transform"></i>
                                    <span>Start Free</span>
                                </a>
                                <a
                                    href="#features"
                                    className="px-8 py-4 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-xl border-2 border-white/30 hover:bg-white/20 hover:shadow-lg transition-all duration-300 flex items-center space-x-2 no-underline"
                                >
                                    <i className="bi bi-play-circle text-xl"></i>
                                    <span>Learn More</span>
                                </a>
                            </div>
                        </div>

                        {/* Right Content - Visual */}
                        <div
                            className={`relative transform transition-all duration-1000 delay-300 ${
                                visible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'
                            }`}
                        >
                            <div className="relative">
                                {/* Main Card */}
                                <div className="relative bg-gradient-to-br from-white to-gray-50 rounded-3xl p-8 border-2 border-[#ec682a]/20 shadow-2xl transform hover:scale-105 transition-transform duration-500">
                                    <div className="absolute -top-3 -right-3 w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-xl">
                                        <i className="bi bi-star-fill text-white text-2xl"></i>
                                    </div>
                                    <div className="space-y-6">
                                        <div className="w-20 h-20 bg-gradient-to-br from-[#ec682a] to-[#d45a20] rounded-2xl flex items-center justify-center mx-auto shadow-lg">
                                            <i className="bi bi-book-half text-white text-4xl"></i>
                                        </div>
                                        <div className="text-center">
                                            <h3 className="text-2xl font-bold text-[#5c5c5c] mb-2">Social Plus</h3>
                                        </div>
                                        <div className="grid grid-cols-3 gap-4 pt-4">
                                            <div className="text-center p-3 bg-blue-50 rounded-xl">
                                                <div className="text-xl font-bold text-blue-600">100+</div>
                                                <div className="text-gray-600 text-sm">Courses</div>
                                            </div>
                                            <div className="text-center p-3 bg-purple-50 rounded-xl">
                                                <div className="text-xl font-bold text-purple-600">50+</div>
                                                <div className="text-gray-600 text-sm">Sessions</div>
                                            </div>
                                            <div className="text-center p-3 bg-green-50 rounded-xl">
                                                <div className="text-xl font-bold text-green-600">24/7</div>
                                                <div className="text-gray-600 text-sm">Access</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {/* Floating Elements */}
                                <div className="absolute -bottom-6 -left-6 w-16 h-16 bg-blue-500/20 backdrop-blur-sm rounded-xl flex items-center justify-center border-2 border-blue-300/50 animate-float shadow-lg">
                                    <i className="bi bi-graph-up-arrow text-blue-600 text-2xl"></i>
                                </div>
                                <div className="absolute -top-6 -right-6 w-16 h-16 bg-green-500/20 backdrop-blur-sm rounded-xl flex items-center justify-center border-2 border-green-300/50 animate-float delay-500 shadow-lg">
                                    <i className="bi bi-check-circle text-green-600 text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Scroll Indicator */}
                <div className="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                    <a href="#features" className="text-white/80 hover:text-white transition-colors no-underline">
                        <i className="bi bi-chevron-down text-3xl"></i>
                    </a>
                </div>
            </section>

            {/* Stats Section */}
            <section className="py-16 bg-gradient-to-r from-[#ec682a]/5 via-blue-50 to-purple-50 border-y border-gray-100">
                <div className="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
                        {stats.map((stat, index) => (
                            <div key={index} className="text-center p-6 bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                                <div className={`text-4xl mb-3 ${stat.color}`}>
                                    <i className={`bi ${stat.icon}`}></i>
                                </div>
                                <div className="text-4xl md:text-5xl font-bold text-[#5c5c5c] mb-2">
                                    {stat.number}
                                </div>
                                <div className="text-gray-600 font-medium">
                                    {stat.label}
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Features Section */}
            <section id="features" className="py-24 bg-gradient-to-b from-white to-gray-50 relative overflow-hidden">
                <div className="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#ec682a] via-blue-500 to-purple-500"></div>
                <div className="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <div className="inline-block mb-4">
                            <span className="px-4 py-2 bg-gradient-to-r from-[#ec682a]/10 to-blue-500/10 text-[#ec682a] rounded-full text-sm font-semibold border border-[#ec682a]/20">
                                Features
                            </span>
                        </div>
                        <h2 className="text-4xl md:text-5xl font-bold text-[#5c5c5c] mb-4">
                            Everything You Need to Succeed
                        </h2>
                        <p className="text-xl text-gray-600 max-w-2xl mx-auto">
                            Powerful features designed for modern learning
                        </p>
                    </div>
                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {features.map((feature, index) => (
                            <div
                                key={index}
                                className="group relative bg-white rounded-2xl p-8 border-2 border-gray-100 hover:border-[#ec682a]/50 transition-all duration-500 hover:shadow-2xl hover:-translate-y-2"
                                style={{
                                    animationDelay: `${feature.delay}ms`,
                                    animation: visible ? `fadeInUp 0.6s ease-out ${feature.delay}ms both` : 'none'
                                }}
                            >
                                <div className={`absolute top-0 left-0 w-full h-1 bg-gradient-to-r ${feature.color} rounded-t-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300`}></div>
                                <div className={`w-16 h-16 bg-gradient-to-br ${feature.color} rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg`}>
                                    <i className={`bi ${feature.icon} text-3xl text-white`}></i>
                                </div>
                                <h3 className="text-xl font-bold text-[#5c5c5c] mb-3 group-hover:text-[#ec682a] transition-colors">
                                    {feature.title}
                                </h3>
                                <p className="text-gray-600 leading-relaxed">
                                    {feature.description}
                                </p>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* How It Works Section */}
            <section id="how-it-works" className="py-24 bg-gradient-to-br from-blue-50 via-white to-purple-50 relative">
                <div className="absolute inset-0 opacity-5">
                    <div
                        className="absolute inset-0"
                        style={{
                            backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%235c5c5c' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`
                        }}
                    ></div>
                </div>
                <div className="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div className="text-center mb-16">
                        <div className="inline-block mb-4">
                            <span className="px-4 py-2 bg-gradient-to-r from-blue-500/10 to-purple-500/10 text-blue-600 rounded-full text-sm font-semibold border border-blue-500/20">
                                Process
                            </span>
                        </div>
                        <h2 className="text-4xl md:text-5xl font-bold text-[#5c5c5c] mb-4">
                            How It Works
                        </h2>
                        <p className="text-xl text-gray-600 max-w-2xl mx-auto">
                            Get started in three simple steps
                        </p>
                    </div>
                    <div className="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                        {steps.map((step, index) => (
                            <div key={index} className="relative">
                                {index < steps.length - 1 && (
                                    <div className="hidden md:block absolute top-20 left-full w-full h-1 bg-gradient-to-r from-[#ec682a] via-blue-500 to-purple-500 transform translate-x-4 z-0"></div>
                                )}
                                <div className="bg-white rounded-2xl p-8 border-2 border-gray-100 hover:border-[#ec682a]/50 hover:shadow-xl transition-all duration-300 text-center relative z-10">
                                    <div className="w-20 h-20 bg-gradient-to-br from-[#ec682a] to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:scale-110 transition-transform">
                                        <i className={`bi ${step.icon} text-white text-3xl`}></i>
                                    </div>
                                    <div className="text-sm font-bold text-[#ec682a] mb-2">STEP {step.number}</div>
                                    <h3 className="text-xl font-bold text-[#5c5c5c] mb-3">
                                        {step.title}
                                    </h3>
                                    <p className="text-gray-600 leading-relaxed">
                                        {step.description}
                                    </p>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Subscription Section */}
            <section id="subscription" className="py-24 bg-gradient-to-br from-[#ec682a] via-[#d45a20] to-[#ec682a] relative overflow-hidden">
                <div className="absolute inset-0 opacity-10">
                    <div
                        className="absolute inset-0"
                        style={{
                            backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`
                        }}
                    ></div>
                </div>
                <div className="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div className="text-center mb-16">
                        <div className="inline-block mb-4">
                            <span className="px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-semibold border border-white/30">
                                Pricing
                            </span>
                        </div>
                        <h2 className="text-4xl md:text-5xl font-bold text-white mb-4">
                            Unlock Full Access with SOCIALPLUS
                        </h2>
                        <p className="text-xl text-white/90 max-w-2xl mx-auto">
                            Get access to all locked sessions, premium content, and exclusive features.
                        </p>
                    </div>
                    <div className="grid lg:grid-cols-2 gap-12 items-center max-w-5xl mx-auto">
                        <div className="space-y-6 text-white">
                            <ul className="space-y-4">
                                {[
                                    'Access to all locked sessions and materials',
                                    'Priority support and notifications',
                                    'Advanced features and analytics',
                                    'Secure access with username and password'
                                ].map((item, index) => (
                                    <li key={index} className="flex items-start space-x-3">
                                        <div className="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i className="bi bi-check text-white text-sm font-bold"></i>
                                        </div>
                                        <span className="text-white/90 text-lg">{item}</span>
                                    </li>
                                ))}
                            </ul>
                        </div>
                        <div className="relative">
                            <div className="bg-white rounded-3xl p-8 shadow-2xl border-2 border-white/20">
                                <div className="text-center mb-8">
                                    <div className="w-20 h-20 bg-gradient-to-br from-[#ec682a] to-[#d45a20] rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                                        <i className="bi bi-star-fill text-white text-4xl"></i>
                                    </div>
                                    <h3 className="text-3xl font-bold text-[#5c5c5c] mb-2">SOCIALPLUS</h3>
                                    <p className="text-gray-600">Premium Subscription</p>
                                </div>
                                <div className="text-center mb-8">
                                    <div className="flex items-baseline justify-center space-x-2">
                                        <span className="text-6xl font-bold text-[#ec682a]">Free</span>
                                        <span className="text-gray-600 text-xl">to start</span>
                                    </div>
                                </div>
                                <a
                                    href="/register"
                                    className="block w-full px-8 py-4 bg-gradient-to-r from-[#ec682a] to-[#d45a20] text-white font-bold rounded-xl hover:shadow-xl hover:scale-105 transition-all duration-300 transform text-center mb-4 no-underline"
                                >
                                    <i className="bi bi-arrow-right-circle mr-2"></i>
                                    Subscribe Now
                                </a>
                                <p className="text-center text-gray-500 text-sm">
                                    <i className="bi bi-lock mr-1"></i>
                                    Secure subscription with password recovery
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section className="py-24 bg-gradient-to-br from-gray-50 via-white to-blue-50">
                <div className="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="max-w-3xl mx-auto text-center">
                        <h2 className="text-4xl md:text-5xl font-bold text-[#5c5c5c] mb-6">
                            Ready to Start Learning?
                        </h2>
                        <p className="text-xl text-gray-600 mb-10">
                            Join thousands of students already using Social Plus to excel in their studies.
                        </p>
                        <div className="flex flex-wrap justify-center gap-4">
                            <a
                                href="/register"
                                className="px-8 py-4 bg-gradient-to-r from-[#ec682a] to-[#d45a20] text-white font-bold rounded-xl hover:shadow-xl hover:scale-105 transition-all duration-300 transform flex items-center space-x-2 no-underline"
                            >
                                <i className="bi bi-person-plus text-xl"></i>
                                <span>Create Free Account</span>
                            </a>
                            <a
                                href="/login"
                                className="px-8 py-4 bg-white text-[#5c5c5c] font-semibold rounded-xl border-2 border-gray-200 hover:border-[#ec682a] hover:text-[#ec682a] hover:shadow-lg transition-all duration-300 flex items-center space-x-2 no-underline"
                            >
                                <i className="bi bi-box-arrow-in-right text-xl"></i>
                                <span>Sign In</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            {/* Footer */}
            <footer className="bg-gradient-to-br from-[#5c5c5c] to-gray-700 text-white py-16">
                <div className="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="grid md:grid-cols-4 gap-8 mb-12">
                        <div>
                            <div className="flex items-center space-x-2 mb-4">
                                <div className="w-10 h-10 bg-gradient-to-br from-[#ec682a] to-[#d45a20] rounded-xl flex items-center justify-center shadow-lg">
                                    <i className="bi bi-book-fill text-white"></i>
                                </div>
                                <span className="text-xl font-bold">Social Plus</span>
                            </div>
                            <p className="text-white/70 text-sm leading-relaxed">
                                Your complete learning platform for social sciences. Access courses, sessions, and materials all in one place.
                            </p>
                        </div>
                        <div>
                            <h4 className="font-bold mb-4">Platform</h4>
                            <ul className="space-y-2 text-sm">
                                <li>
                                    <a href="#features" className="text-white/70 hover:text-[#ec682a] transition-colors no-underline">
                                        Features
                                    </a>
                                </li>
                                <li>
                                    <a href="#how-it-works" className="text-white/70 hover:text-[#ec682a] transition-colors no-underline">
                                        How It Works
                                    </a>
                                </li>
                                <li>
                                    <a href="#subscription" className="text-white/70 hover:text-[#ec682a] transition-colors no-underline">
                                        Pricing
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h4 className="font-bold mb-4">Account</h4>
                            <ul className="space-y-2 text-sm">
                                <li>
                                    <a href="/login" className="text-white/70 hover:text-[#ec682a] transition-colors no-underline">
                                        Login
                                    </a>
                                </li>
                                <li>
                                    <a href="/register" className="text-white/70 hover:text-[#ec682a] transition-colors no-underline">
                                        Register
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h4 className="font-bold mb-4">Legal</h4>
                            <ul className="space-y-2 text-sm">
                                <li>
                                    <a href="/privacy" className="text-white/70 hover:text-[#ec682a] transition-colors no-underline">
                                        Privacy Policy
                                    </a>
                                </li>
                                <li>
                                    <a href="/terms" className="text-white/70 hover:text-[#ec682a] transition-colors no-underline">
                                        Terms of Service
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div className="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center">
                        <p className="text-white/70 text-sm mb-4 md:mb-0">
                            <i className="bi bi-c-circle mr-1"></i>
                            2024 Social Plus. All rights reserved.
                        </p>
                        <div className="flex space-x-4">
                            <a href="#" className="text-white/70 hover:text-[#ec682a] transition-colors no-underline">
                                <i className="bi bi-facebook text-xl"></i>
                            </a>
                            <a href="#" className="text-white/70 hover:text-[#ec682a] transition-colors no-underline">
                                <i className="bi bi-twitter text-xl"></i>
                            </a>
                            <a href="#" className="text-white/70 hover:text-[#ec682a] transition-colors no-underline">
                                <i className="bi bi-linkedin text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    );
}
