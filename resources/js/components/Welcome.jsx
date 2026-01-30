import React from 'react';

const Welcome = () => {
    return (
        <div className="min-vh-100 bg-light">
            {/* Navigation */}
            <nav className="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
                <div className="container">
                    <a className="navbar-brand fw-bold d-flex align-items-center" href="/">
                        <img src="/assets/images/logo.png" alt="ESIB Social" className="me-2" style={{ height: '36px', width: 'auto', objectFit: 'contain' }} />
                        <span>ESIB SOCIAL</span>
                    </a>
                    <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span className="navbar-toggler-icon"></span>
                    </button>
                    <div className="collapse navbar-collapse" id="navbarNav">
                        <ul className="navbar-nav ms-auto align-items-center">
                            <li className="nav-item">
                                <a className="nav-link" href="#features">Features</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href="#subscription">Subscription</a>
                            </li>
                            <li className="nav-item ms-2">
                                <a className="btn btn-primary" href="/login" style={{background: '#ec682a', border: 'none'}}>
                                    Login
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            {/* Hero Section */}
            <section className="py-5" style={{background: 'linear-gradient(135deg, #fff 0%, #f8f9fa 100%)'}}>
                <div className="container">
                    <div className="row align-items-center min-vh-75">
                        <div className="col-lg-6">
                            <h1 className="display-4 fw-bold mb-4" style={{color: '#5c5c5c'}}>
                                Your Complete Learning Platform for
                                <span className="d-block" style={{color: '#ec682a'}}>Social Sciences</span>
                            </h1>
                            <p className="lead text-muted mb-4">
                                Access courses, sessions, and materials organized by subject.
                                Everything you need for your academic success in one place.
                            </p>
                            <div className="d-flex gap-3 flex-wrap">
                                <a href="/register" className="btn btn-lg px-4 py-3 text-white fw-semibold"
                                   style={{background: '#ec682a', border: 'none'}}>
                                    <i className="bi bi-rocket-takeoff me-2"></i>
                                    Start Learning Free
                                </a>
                                <a href="#features" className="btn btn-lg btn-outline-secondary px-4 py-3 fw-semibold">
                                    <i className="bi bi-play-circle me-2"></i>
                                    Learn More
                                </a>
                            </div>
                            <div className="mt-4 d-flex align-items-center gap-4 text-muted small">
                                <div className="d-flex align-items-center">
                                    <i className="bi bi-check-circle-fill text-success me-2"></i>
                                    No credit card required
                                </div>
                                <div className="d-flex align-items-center">
                                    <i className="bi bi-shield-check text-primary me-2"></i>
                                    Secure & Protected
                                </div>
                            </div>
                        </div>
                        <div className="col-lg-6 text-center mt-5 mt-lg-0">
                            <div className="position-relative">
                                <div className="bg-white rounded-4 shadow-lg p-5" style={{border: '3px solid #ec682a'}}>
                                    <img src="/assets/images/logo.png" alt="ESIB Social" className="d-block mx-auto mb-3" style={{ maxHeight: '120px', width: 'auto', objectFit: 'contain' }} />
                                    <h3 className="fw-bold mb-2">ESIB SOCIAL</h3>
                                    <p className="text-muted mb-0">Your learning journey starts here</p>
                                </div>
                                <div className="position-absolute top-0 start-0 translate-middle bg-primary rounded-circle p-3 shadow"
                                     style={{background: '#ec682a', width: '60px', height: '60px', zIndex: 1}}>
                                    <i className="bi bi-graph-up-arrow text-white fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Features Section */}
            <section id="features" className="py-5 bg-white">
                <div className="container">
                    <div className="text-center mb-5">
                        <h2 className="display-5 fw-bold mb-3" style={{color: '#5c5c5c'}}>
                            Everything You Need to Succeed
                        </h2>
                        <p className="lead text-muted">Powerful features designed for modern learning</p>
                    </div>
                    <div className="row g-4">
                        <div className="col-md-6 col-lg-4">
                            <div className="card border-0 shadow-sm h-100 p-4">
                                <div className="bg-primary bg-opacity-10 rounded-3 p-3 d-inline-block mb-3"
                                     style={{background: 'rgba(236, 104, 42, 0.1) !important'}}>
                                    <i className="bi bi-diagram-3 fs-2" style={{color: '#ec682a'}}></i>
                                </div>
                                <h5 className="fw-bold mb-2">Organized by Subject</h5>
                                <p className="text-muted mb-0">
                                    Courses organized by subject matter, not just by year.
                                    Easy to find what you need when you need it.
                                </p>
                            </div>
                        </div>
                        <div className="col-md-6 col-lg-4">
                            <div className="card border-0 shadow-sm h-100 p-4">
                                <div className="bg-primary bg-opacity-10 rounded-3 p-3 d-inline-block mb-3"
                                     style={{background: 'rgba(236, 104, 42, 0.1) !important'}}>
                                    <i className="bi bi-calculator fs-2" style={{color: '#ec682a'}}></i>
                                </div>
                                <h5 className="fw-bold mb-2">Built-in Calculator</h5>
                                <p className="text-muted mb-0">
                                    No need to switch apps. Use our built-in calculator
                                    directly on the platform for your convenience.
                                </p>
                            </div>
                        </div>
                        <div className="col-md-6 col-lg-4">
                            <div className="card border-0 shadow-sm h-100 p-4">
                                <div className="bg-primary bg-opacity-10 rounded-3 p-3 d-inline-block mb-3"
                                     style={{background: 'rgba(236, 104, 42, 0.1) !important'}}>
                                    <i className="bi bi-phone fs-2" style={{color: '#ec682a'}}></i>
                                </div>
                                <h5 className="fw-bold mb-2">Synchronized Content</h5>
                                <p className="text-muted mb-0">
                                    All your courses, sessions, and materials synchronized
                                    across devices. Access anywhere, anytime.
                                </p>
                            </div>
                        </div>
                        <div className="col-md-6 col-lg-4">
                            <div className="card border-0 shadow-sm h-100 p-4">
                                <div className="bg-primary bg-opacity-10 rounded-3 p-3 d-inline-block mb-3"
                                     style={{background: 'rgba(236, 104, 42, 0.1) !important'}}>
                                    <i className="bi bi-shield-lock fs-2" style={{color: '#ec682a'}}></i>
                                </div>
                                <h5 className="fw-bold mb-2">Secure & Protected</h5>
                                <p className="text-muted mb-0">
                                    Advanced security with watermarking, screenshot detection,
                                    and single-device access protection.
                                </p>
                            </div>
                        </div>
                        <div className="col-md-6 col-lg-4">
                            <div className="card border-0 shadow-sm h-100 p-4">
                                <div className="bg-primary bg-opacity-10 rounded-3 p-3 d-inline-block mb-3"
                                     style={{background: 'rgba(236, 104, 42, 0.1) !important'}}>
                                    <i className="bi bi-bell fs-2" style={{color: '#ec682a'}}></i>
                                </div>
                                <h5 className="fw-bold mb-2">Real-time Notifications</h5>
                                <p className="text-muted mb-0">
                                    Get notified instantly when new sessions or courses
                                    are available. Never miss an update.
                                </p>
                            </div>
                        </div>
                        <div className="col-md-6 col-lg-4">
                            <div className="card border-0 shadow-sm h-100 p-4">
                                <div className="bg-primary bg-opacity-10 rounded-3 p-3 d-inline-block mb-3"
                                     style={{background: 'rgba(236, 104, 42, 0.1) !important'}}>
                                    <i className="bi bi-cloud-check fs-2" style={{color: '#ec682a'}}></i>
                                </div>
                                <h5 className="fw-bold mb-2">No Downloads Required</h5>
                                <p className="text-muted mb-0">
                                    Everything is accessible online. No need to download
                                    files. Stream and learn directly from your browser.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Subscription Section */}
            <section id="subscription" className="py-5" style={{background: 'linear-gradient(135deg, #ec682a 0%, #d45a20 100%)'}}>
                <div className="container">
                    <div className="row align-items-center">
                        <div className="col-lg-6 text-white mb-4 mb-lg-0">
                            <h2 className="display-5 fw-bold mb-3">Unlock Full Access with SOCIALPLUS</h2>
                            <p className="lead mb-4">
                                Get access to all locked sessions, premium content, and exclusive features.
                                Subscribe to SOCIALPLUS and take your learning to the next level.
                            </p>
                            <ul className="list-unstyled">
                                <li className="mb-3 d-flex align-items-start">
                                    <i className="bi bi-check-circle-fill me-3 fs-5"></i>
                                    <span>Access to all locked sessions and materials</span>
                                </li>
                                <li className="mb-3 d-flex align-items-start">
                                    <i className="bi bi-check-circle-fill me-3 fs-5"></i>
                                    <span>Priority support and notifications</span>
                                </li>
                                <li className="mb-3 d-flex align-items-start">
                                    <i className="bi bi-check-circle-fill me-3 fs-5"></i>
                                    <span>Advanced features and analytics</span>
                                </li>
                                <li className="mb-3 d-flex align-items-start">
                                    <i className="bi bi-check-circle-fill me-3 fs-5"></i>
                                    <span>Secure access with username and password</span>
                                </li>
                            </ul>
                        </div>
                        <div className="col-lg-6">
                            <div className="card shadow-lg border-0">
                                <div className="card-body p-5">
                                    <div className="text-center mb-4">
                                        <i className="bi bi-star-fill fs-1 mb-3" style={{color: '#ec682a'}}></i>
                                        <h3 className="fw-bold mb-2">SOCIALPLUS</h3>
                                        <p className="text-muted">Premium Subscription</p>
                                    </div>
                                    <div className="text-center mb-4">
                                        <span className="display-4 fw-bold" style={{color: '#ec682a'}}>Free</span>
                                        <span className="text-muted"> to start</span>
                                    </div>
                                    <a href="/register" className="btn w-100 btn-lg text-white fw-semibold py-3 mb-3"
                                       style={{background: '#ec682a', border: 'none'}}>
                                        <i className="bi bi-arrow-right-circle me-2"></i>
                                        Subscribe Now
                                    </a>
                                    <p className="text-center text-muted small mb-0">
                                        <i className="bi bi-lock me-1"></i>
                                        Secure subscription with password recovery
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section className="py-5 bg-white">
                <div className="container">
                    <div className="row justify-content-center">
                        <div className="col-lg-8 text-center">
                            <h2 className="display-6 fw-bold mb-3" style={{color: '#5c5c5c'}}>
                                Ready to Start Learning?
                            </h2>
                            <p className="lead text-muted mb-4">
                                Join thousands of students already using Social Plus to excel in their studies.
                            </p>
                            <div className="d-flex gap-3 justify-content-center flex-wrap">
                                <a href="/register" className="btn btn-lg px-5 py-3 text-white fw-semibold"
                                   style={{background: '#ec682a', border: 'none'}}>
                                    <i className="bi bi-person-plus me-2"></i>
                                    Create Free Account
                                </a>
                                <a href="/login" className="btn btn-lg btn-outline-secondary px-5 py-3 fw-semibold">
                                    <i className="bi bi-box-arrow-in-right me-2"></i>
                                    Sign In
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Footer */}
            <footer className="bg-dark text-white py-4">
                <div className="container">
                    <div className="row align-items-center">
                        <div className="col-md-6">
                            <p className="mb-0 small">
                                <i className="bi bi-c-circle me-1"></i>
                                2024 Social Plus. All rights reserved.
                            </p>
                        </div>
                        <div className="col-md-6 text-md-end mt-3 mt-md-0">
                            <a href="/login" className="text-white text-decoration-none me-3 small">Login</a>
                            <a href="/register" className="text-white text-decoration-none small">Register</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    );
};

export default Welcome;
