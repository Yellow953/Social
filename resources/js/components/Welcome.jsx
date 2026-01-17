import React from 'react';

const Welcome = () => {
    return (
        <div className="bg-light">
            {/* Navigation */}
            <nav className="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
                <div className="container">
                    <a className="navbar-brand fw-bold d-flex align-items-center" href="/">
                        <i className="bi bi-book-fill me-2 fs-4" style={{color: '#ec682a'}}></i>
                        <span className="fs-4">Social Plus</span>
                    </a>
                    <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span className="navbar-toggler-icon"></span>
                    </button>
                    <div className="collapse navbar-collapse" id="navbarNav">
                        <ul className="navbar-nav ms-auto align-items-center">
                            <li className="nav-item">
                                <a className="nav-link fw-semibold" href="#features">Features</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link fw-semibold" href="#how-it-works">How It Works</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link fw-semibold" href="#subscription">Pricing</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link fw-semibold" href="#faq">FAQ</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link fw-semibold" href="/login">Login</a>
                            </li>
                            <li className="nav-item ms-2">
                                <a className="btn btn-primary btn-lg px-4" href="/register" style={{background: '#ec682a', border: 'none'}}>
                                    Get Started
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            {/* Hero Section - Enhanced */}
            <section className="position-relative overflow-hidden" style={{
                background: 'linear-gradient(135deg, #ec682a 0%, #d45a20 30%, #5c5c5c 100%)',
                minHeight: '95vh',
                paddingTop: '100px',
                paddingBottom: '80px'
            }}>
                {/* Animated Background Elements */}
                <div className="position-absolute top-0 start-0 w-100 h-100" style={{opacity: 0.15, zIndex: 1}}>
                    <div className="position-absolute rounded-circle" style={{
                        top: '-10%',
                        right: '10%',
                        width: '500px',
                        height: '500px',
                        background: 'white',
                        filter: 'blur(80px)',
                        animation: 'float 6s ease-in-out infinite'
                    }}></div>
                    <div className="position-absolute rounded-circle" style={{
                        bottom: '-15%',
                        left: '5%',
                        width: '400px',
                        height: '400px',
                        background: 'white',
                        filter: 'blur(80px)',
                        animation: 'float 8s ease-in-out infinite 2s'
                    }}></div>
                    <div className="position-absolute rounded-circle" style={{
                        top: '50%',
                        left: '50%',
                        transform: 'translate(-50%, -50%)',
                        width: '600px',
                        height: '600px',
                        background: 'white',
                        filter: 'blur(100px)',
                        animation: 'float 10s ease-in-out infinite 1s'
                    }}></div>
                </div>

                <div className="container position-relative" style={{zIndex: 2}}>
                    <div className="row align-items-center">
                        <div className="col-lg-6 text-white mb-5 mb-lg-0">
                            {/* Trust Badge */}
                            <div className="mb-4">
                                <span className="badge px-4 py-2 rounded-pill" style={{
                                    background: 'rgba(255, 255, 255, 0.2)',
                                    backdropFilter: 'blur(10px)',
                                    border: '1px solid rgba(255, 255, 255, 0.3)',
                                    fontSize: '0.95rem',
                                    fontWeight: '600'
                                }}>
                                    <i className="bi bi-star-fill me-2"></i>Trusted by Thousands of Students
                                </span>
                            </div>

                            {/* Main Headline */}
                            <h1 className="display-1 fw-bold mb-4 lh-sm" style={{
                                fontSize: 'clamp(2.5rem, 6vw, 4.5rem)',
                                lineHeight: '1.1',
                                textShadow: '0 4px 20px rgba(0,0,0,0.3)',
                                marginBottom: '1.5rem'
                            }}>
                                Master Social Sciences
                                <span className="d-block mt-2" style={{
                                    background: 'linear-gradient(135deg, #fff 0%, rgba(255,255,255,0.9) 100%)',
                                    WebkitBackgroundClip: 'text',
                                    WebkitTextFillColor: 'transparent',
                                    backgroundClip: 'text'
                                }}>Like Never Before</span>
                            </h1>

                            {/* Subheadline */}
                            <p className="lead fs-3 mb-5" style={{
                                lineHeight: '1.7',
                                opacity: 0.95,
                                textShadow: '0 2px 10px rgba(0,0,0,0.2)',
                                fontWeight: '400'
                            }}>
                                Access courses, sessions, and materials organized by subject.
                                Everything you need for academic excellence in one powerful platform.
                            </p>

                            {/* CTA Buttons */}
                            <div className="d-flex gap-3 flex-wrap mb-5">
                                <a href="/register" className="btn btn-lg px-5 py-3 text-dark fw-bold rounded-pill shadow-lg"
                                   style={{
                                       background: 'white',
                                       border: 'none',
                                       fontSize: '1.1rem',
                                       transition: 'all 0.3s ease'
                                   }}
                                   onMouseEnter={(e) => {
                                       e.target.style.transform = 'translateY(-3px)';
                                       e.target.style.boxShadow = '0 12px 35px rgba(0,0,0,0.3)';
                                   }}
                                   onMouseLeave={(e) => {
                                       e.target.style.transform = 'translateY(0)';
                                       e.target.style.boxShadow = '0 5px 20px rgba(0,0,0,0.2)';
                                   }}>
                                    <i className="bi bi-rocket-takeoff me-2"></i>
                                    Start Free Today
                                </a>
                                <a href="#features" className="btn btn-lg px-5 py-3 fw-bold rounded-pill"
                                   style={{
                                       background: 'rgba(255, 255, 255, 0.15)',
                                       backdropFilter: 'blur(10px)',
                                       border: '2px solid rgba(255, 255, 255, 0.3)',
                                       color: 'white',
                                       fontSize: '1.1rem',
                                       transition: 'all 0.3s ease'
                                   }}
                                   onMouseEnter={(e) => {
                                       e.target.style.background = 'rgba(255, 255, 255, 0.25)';
                                       e.target.style.transform = 'translateY(-3px)';
                                   }}
                                   onMouseLeave={(e) => {
                                       e.target.style.background = 'rgba(255, 255, 255, 0.15)';
                                       e.target.style.transform = 'translateY(0)';
                                   }}>
                                    <i className="bi bi-play-circle me-2"></i>
                                    Watch Demo
                                </a>
                            </div>

                            {/* Trust Indicators */}
                            <div className="d-flex align-items-center gap-4 flex-wrap">
                                <div className="d-flex align-items-center">
                                    <div className="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                                        <i className="bi bi-check-circle-fill text-white fs-5"></i>
                                    </div>
                                    <div>
                                        <div className="fw-bold">No Credit Card</div>
                                        <div className="small opacity-75">Free to start</div>
                                    </div>
                                </div>
                                <div className="d-flex align-items-center">
                                    <div className="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                                        <i className="bi bi-shield-check text-white fs-5"></i>
                                    </div>
                                    <div>
                                        <div className="fw-bold">100% Secure</div>
                                        <div className="small opacity-75">Encrypted & Protected</div>
                                    </div>
                                </div>
                                <div className="d-flex align-items-center">
                                    <div className="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                                        <i className="bi bi-lightning-charge text-white fs-5"></i>
                                    </div>
                                    <div>
                                        <div className="fw-bold">Instant Access</div>
                                        <div className="small opacity-75">Start immediately</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Right Side - Enhanced Visual Elements */}
                        <div className="col-lg-6 position-relative">
                            <div className="position-relative" style={{height: '650px'}}>
                                {/* Main Card */}
                                <div className="position-absolute top-50 start-50 translate-middle"
                                     style={{
                                         width: '90%',
                                         maxWidth: '520px',
                                         transform: 'translate(-50%, -50%)'
                                     }}>
                                    <div className="bg-white rounded-4 shadow-xl p-5 border-0" style={{
                                        backdropFilter: 'blur(20px)',
                                        background: 'rgba(255, 255, 255, 0.98)',
                                        animation: 'slideUp 0.8s ease-out'
                                    }}>
                                        <div className="text-center mb-4">
                                            <div className="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                 style={{
                                                     width: '130px',
                                                     height: '130px',
                                                     background: 'rgba(236, 104, 42, 0.1) !important',
                                                     animation: 'pulse 2s ease-in-out infinite'
                                                 }}>
                                                <i className="bi bi-book-half" style={{fontSize: '4.5rem', color: '#ec682a'}}></i>
                                            </div>
                                            <h2 className="fw-bold mb-2 fs-2" style={{color: '#5c5c5c'}}>Social Plus</h2>
                                            <p className="text-muted mb-0 fs-5">Your learning journey starts here</p>
                                        </div>

                                        {/* Stats Grid */}
                                        <div className="row g-3 mt-4">
                                            <div className="col-4 text-center">
                                                <div className="fw-bold fs-3 mb-1" style={{color: '#ec682a'}}>1000+</div>
                                                <div className="text-muted small fw-semibold">Students</div>
                                            </div>
                                            <div className="col-4 text-center border-start border-end">
                                                <div className="fw-bold fs-3 mb-1" style={{color: '#ec682a'}}>500+</div>
                                                <div className="text-muted small fw-semibold">Courses</div>
                                            </div>
                                            <div className="col-4 text-center">
                                                <div className="fw-bold fs-3 mb-1" style={{color: '#ec682a'}}>24/7</div>
                                                <div className="text-muted small fw-semibold">Access</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {/* Floating Elements */}
                                <div className="position-absolute top-0 start-0 bg-white rounded-3 shadow-lg p-3"
                                     style={{
                                         width: '140px',
                                         animation: 'float 3s ease-in-out infinite',
                                         zIndex: 3
                                     }}>
                                    <div className="d-flex align-items-center">
                                        <div className="bg-success rounded-circle p-2 me-2">
                                            <i className="bi bi-check text-white"></i>
                                        </div>
                                        <div>
                                            <div className="fw-bold small">Active</div>
                                            <div className="text-muted" style={{fontSize: '0.7rem'}}>Learning</div>
                                        </div>
                                    </div>
                                </div>

                                <div className="position-absolute bottom-0 end-0 bg-white rounded-3 shadow-lg p-3"
                                     style={{
                                         width: '160px',
                                         animation: 'float 3s ease-in-out infinite 1.5s',
                                         zIndex: 3
                                     }}>
                                    <div className="d-flex align-items-center">
                                        <div className="bg-primary rounded-circle p-2 me-2" style={{background: '#ec682a'}}>
                                            <i className="bi bi-graph-up text-white"></i>
                                        </div>
                                        <div>
                                            <div className="fw-bold small">Growing</div>
                                            <div className="text-muted" style={{fontSize: '0.7rem'}}>Daily</div>
                                        </div>
                                    </div>
                                </div>

                                <div className="position-absolute top-50 end-0 translate-middle-y bg-white rounded-3 shadow-lg p-3"
                                     style={{
                                         width: '150px',
                                         animation: 'float 3s ease-in-out infinite 0.75s',
                                         zIndex: 3
                                     }}>
                                    <div className="d-flex align-items-center">
                                        <div className="bg-info rounded-circle p-2 me-2">
                                            <i className="bi bi-star text-white"></i>
                                        </div>
                                        <div>
                                            <div className="fw-bold small">Premium</div>
                                            <div className="text-muted" style={{fontSize: '0.7rem'}}>Content</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Scroll Indicator */}
                <div className="position-absolute bottom-0 start-50 translate-middle-x mb-4" style={{zIndex: 2}}>
                    <a href="#features" className="text-white text-decoration-none">
                        <div className="d-flex flex-column align-items-center">
                            <span className="small mb-2 opacity-75">Scroll to explore</span>
                            <i className="bi bi-chevron-down fs-4" style={{animation: 'bounce 2s infinite'}}></i>
                        </div>
                    </a>
                </div>

                {/* CSS Animations */}
                <style>{`
                    @keyframes float {
                        0%, 100% { transform: translateY(0px); }
                        50% { transform: translateY(-20px); }
                    }
                    @keyframes bounce {
                        0%, 100% { transform: translateY(0); }
                        50% { transform: translateY(10px); }
                    }
                    @keyframes slideUp {
                        from {
                            opacity: 0;
                            transform: translate(-50%, -40%);
                        }
                        to {
                            opacity: 1;
                            transform: translate(-50%, -50%);
                        }
                    }
                    @keyframes pulse {
                        0%, 100% { transform: scale(1); }
                        50% { transform: scale(1.05); }
                    }
                `}</style>
            </section>

            {/* Stats Section */}
            <section className="py-5 bg-white border-top border-bottom">
                <div className="container">
                    <div className="row g-4 text-center">
                        <div className="col-md-3 col-6">
                            <div className="p-4">
                                <div className="display-4 fw-bold mb-2" style={{color: '#ec682a'}}>1000+</div>
                                <div className="text-muted fw-semibold">Active Students</div>
                            </div>
                        </div>
                        <div className="col-md-3 col-6">
                            <div className="p-4">
                                <div className="display-4 fw-bold mb-2" style={{color: '#ec682a'}}>500+</div>
                                <div className="text-muted fw-semibold">Available Courses</div>
                            </div>
                        </div>
                        <div className="col-md-3 col-6">
                            <div className="p-4">
                                <div className="display-4 fw-bold mb-2" style={{color: '#ec682a'}}>50+</div>
                                <div className="text-muted fw-semibold">Subjects</div>
                            </div>
                        </div>
                        <div className="col-md-3 col-6">
                            <div className="p-4">
                                <div className="display-4 fw-bold mb-2" style={{color: '#ec682a'}}>99%</div>
                                <div className="text-muted fw-semibold">Satisfaction Rate</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Features Section - Expanded */}
            <section id="features" className="py-5 bg-light">
                <div className="container">
                    <div className="text-center mb-5">
                        <h2 className="display-4 fw-bold mb-3" style={{color: '#5c5c5c'}}>
                            Everything You Need to Succeed
                        </h2>
                        <p className="lead text-muted fs-5">Powerful features designed for modern learning</p>
                    </div>
                    <div className="row g-4 mb-5">
                        <div className="col-md-6 col-lg-4">
                            <div className="card border-0 shadow-sm h-100 p-4 hover-shadow" style={{transition: 'all 0.3s'}}>
                                <div className="bg-primary bg-opacity-10 rounded-3 p-4 d-inline-block mb-3"
                                     style={{background: 'rgba(236, 104, 42, 0.1) !important'}}>
                                    <i className="bi bi-diagram-3" style={{fontSize: '2.5rem', color: '#ec682a'}}></i>
                                </div>
                                <h4 className="fw-bold mb-3">Organized by Subject</h4>
                                <p className="text-muted mb-0">
                                    Courses organized by subject matter, not just by year.
                                    Easy to find what you need when you need it. Each subject
                                    can be assigned to multiple years and specializations.
                                </p>
                            </div>
                        </div>
                        <div className="col-md-6 col-lg-4">
                            <div className="card border-0 shadow-sm h-100 p-4">
                                <div className="bg-primary bg-opacity-10 rounded-3 p-4 d-inline-block mb-3"
                                     style={{background: 'rgba(236, 104, 42, 0.1) !important'}}>
                                    <i className="bi bi-calculator" style={{fontSize: '2.5rem', color: '#ec682a'}}></i>
                                </div>
                                <h4 className="fw-bold mb-3">Built-in Calculator</h4>
                                <p className="text-muted mb-0">
                                    No need to switch apps or visit external sites. Use our
                                    built-in calculator directly on the platform for your convenience.
                                    Always accessible when you need it.
                                </p>
                            </div>
                        </div>
                        <div className="col-md-6 col-lg-4">
                            <div className="card border-0 shadow-sm h-100 p-4">
                                <div className="bg-primary bg-opacity-10 rounded-3 p-4 d-inline-block mb-3"
                                     style={{background: 'rgba(236, 104, 42, 0.1) !important'}}>
                                    <i className="bi bi-phone" style={{fontSize: '2.5rem', color: '#ec682a'}}></i>
                                </div>
                                <h4 className="fw-bold mb-3">Synchronized Content</h4>
                                <p className="text-muted mb-0">
                                    All your courses, sessions, and materials (TP included)
                                    synchronized across devices. Access anywhere, anytime.
                                    Everything stays in sync automatically.
                                </p>
                            </div>
                        </div>
                        <div className="col-md-6 col-lg-4">
                            <div className="card border-0 shadow-sm h-100 p-4">
                                <div className="bg-primary bg-opacity-10 rounded-3 p-4 d-inline-block mb-3"
                                     style={{background: 'rgba(236, 104, 42, 0.1) !important'}}>
                                    <i className="bi bi-shield-lock" style={{fontSize: '2.5rem', color: '#ec682a'}}></i>
                                </div>
                                <h4 className="fw-bold mb-3">Advanced Security</h4>
                                <p className="text-muted mb-0">
                                    Watermarking with your username, screenshot detection,
                                    single-device access protection, and comprehensive data logs.
                                    Your content is fully protected.
                                </p>
                            </div>
                        </div>
                        <div className="col-md-6 col-lg-4">
                            <div className="card border-0 shadow-sm h-100 p-4">
                                <div className="bg-primary bg-opacity-10 rounded-3 p-4 d-inline-block mb-3"
                                     style={{background: 'rgba(236, 104, 42, 0.1) !important'}}>
                                    <i className="bi bi-bell" style={{fontSize: '2.5rem', color: '#ec682a'}}></i>
                                </div>
                                <h4 className="fw-bold mb-3">Real-time Notifications</h4>
                                <p className="text-muted mb-0">
                                    Get notified instantly when new sessions or courses
                                    are available. Stay updated with all platform announcements.
                                    Never miss important updates.
                                </p>
                            </div>
                        </div>
                        <div className="col-md-6 col-lg-4">
                            <div className="card border-0 shadow-sm h-100 p-4">
                                <div className="bg-primary bg-opacity-10 rounded-3 p-4 d-inline-block mb-3"
                                     style={{background: 'rgba(236, 104, 42, 0.1) !important'}}>
                                    <i className="bi bi-cloud-check" style={{fontSize: '2.5rem', color: '#ec682a'}}></i>
                                </div>
                                <h4 className="fw-bold mb-3">No Downloads Required</h4>
                                <p className="text-muted mb-0">
                                    Everything is accessible online. No need to download
                                    files. Stream and learn directly from your browser.
                                    Fast and efficient access.
                                </p>
                            </div>
                        </div>
                        <div className="col-md-6 col-lg-4">
                            <div className="card border-0 shadow-sm h-100 p-4">
                                <div className="bg-primary bg-opacity-10 rounded-3 p-4 d-inline-block mb-3"
                                     style={{background: 'rgba(236, 104, 42, 0.1) !important'}}>
                                    <i className="bi bi-lock" style={{fontSize: '2.5rem', color: '#ec682a'}}></i>
                                </div>
                                <h4 className="fw-bold mb-3">Session Locking</h4>
                                <p className="text-muted mb-0">
                                    Administrators can lock specific sessions. Locked sessions
                                    require SOCIALPLUS subscription to access. Full control
                                    over content availability.
                                </p>
                            </div>
                        </div>
                        <div className="col-md-6 col-lg-4">
                            <div className="card border-0 shadow-sm h-100 p-4">
                                <div className="bg-primary bg-opacity-10 rounded-3 p-4 d-inline-block mb-3"
                                     style={{background: 'rgba(236, 104, 42, 0.1) !important'}}>
                                    <i className="bi bi-graph-up" style={{fontSize: '2.5rem', color: '#ec682a'}}></i>
                                </div>
                                <h4 className="fw-bold mb-3">Data Logs & Analytics</h4>
                                <p className="text-muted mb-0">
                                    Complete tracking of who accessed which session and when.
                                    Detailed logs for administrators. Full transparency and
                                    accountability.
                                </p>
                            </div>
                        </div>
                        <div className="col-md-6 col-lg-4">
                            <div className="card border-0 shadow-sm h-100 p-4">
                                <div className="bg-primary bg-opacity-10 rounded-3 p-4 d-inline-block mb-3"
                                     style={{background: 'rgba(236, 104, 42, 0.1) !important'}}>
                                    <i className="bi bi-people" style={{fontSize: '2.5rem', color: '#ec682a'}}></i>
                                </div>
                                <h4 className="fw-bold mb-3">Flexible Organization</h4>
                                <p className="text-muted mb-0">
                                    At the beginning of each year, easily redistribute subjects
                                    by specialty and year. Each subject can belong to multiple
                                    years and branches. Complete flexibility.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* How It Works Section */}
            <section id="how-it-works" className="py-5 bg-white">
                <div className="container">
                    <div className="text-center mb-5">
                        <h2 className="display-4 fw-bold mb-3" style={{color: '#5c5c5c'}}>How It Works</h2>
                        <p className="lead text-muted fs-5">Get started in three simple steps</p>
                    </div>
                    <div className="row g-4">
                        <div className="col-md-4">
                            <div className="text-center p-4">
                                <div className="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                     style={{width: '100px', height: '100px', background: 'rgba(236, 104, 42, 0.1) !important'}}>
                                    <span className="display-4 fw-bold" style={{color: '#ec682a'}}>1</span>
                                </div>
                                <h4 className="fw-bold mb-3">Create Your Account</h4>
                                <p className="text-muted">
                                    Sign up with your email and phone number. It's free and takes less than a minute.
                                    No credit card required to get started.
                                </p>
                            </div>
                        </div>
                        <div className="col-md-4">
                            <div className="text-center p-4">
                                <div className="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                     style={{width: '100px', height: '100px', background: 'rgba(236, 104, 42, 0.1) !important'}}>
                                    <span className="display-4 fw-bold" style={{color: '#ec682a'}}>2</span>
                                </div>
                                <h4 className="fw-bold mb-3">Browse & Access Content</h4>
                                <p className="text-muted">
                                    Explore courses organized by subject. Access free content immediately.
                                    Locked sessions are clearly marked and require SOCIALPLUS subscription.
                                </p>
                            </div>
                        </div>
                        <div className="col-md-4">
                            <div className="text-center p-4">
                                <div className="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                     style={{width: '100px', height: '100px', background: 'rgba(236, 104, 42, 0.1) !important'}}>
                                    <span className="display-4 fw-bold" style={{color: '#ec682a'}}>3</span>
                                </div>
                                <h4 className="fw-bold mb-3">Upgrade to SOCIALPLUS</h4>
                                <p className="text-muted">
                                    Unlock all locked sessions and premium features with SOCIALPLUS subscription.
                                    Get full access to everything the platform has to offer.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Subscription Section - Enhanced */}
            <section id="subscription" className="py-5" style={{background: 'linear-gradient(135deg, #ec682a 0%, #d45a20 50%, #5c5c5c 100%)'}}>
                <div className="container">
                    <div className="text-center mb-5 text-white">
                        <h2 className="display-4 fw-bold mb-3">Unlock Full Access with SOCIALPLUS</h2>
                        <p className="lead fs-5 mb-0">Premium features for serious learners</p>
                    </div>
                    <div className="row align-items-center">
                        <div className="col-lg-6 text-white mb-4 mb-lg-0">
                            <h3 className="fw-bold mb-4 fs-2">What You Get</h3>
                            <ul className="list-unstyled">
                                <li className="mb-3 d-flex align-items-start">
                                    <i className="bi bi-check-circle-fill me-3 fs-4"></i>
                                    <div>
                                        <strong>Access to all locked sessions and materials</strong>
                                        <p className="mb-0 small opacity-90">Unlock premium content instantly</p>
                                    </div>
                                </li>
                                <li className="mb-3 d-flex align-items-start">
                                    <i className="bi bi-check-circle-fill me-3 fs-4"></i>
                                    <div>
                                        <strong>Priority support and notifications</strong>
                                        <p className="mb-0 small opacity-90">Get help when you need it</p>
                                    </div>
                                </li>
                                <li className="mb-3 d-flex align-items-start">
                                    <i className="bi bi-check-circle-fill me-3 fs-4"></i>
                                    <div>
                                        <strong>Advanced features and analytics</strong>
                                        <p className="mb-0 small opacity-90">Track your learning progress</p>
                                    </div>
                                </li>
                                <li className="mb-3 d-flex align-items-start">
                                    <i className="bi bi-check-circle-fill me-3 fs-4"></i>
                                    <div>
                                        <strong>Secure access with username and password</strong>
                                        <p className="mb-0 small opacity-90">Password recovery included</p>
                                    </div>
                                </li>
                                <li className="mb-3 d-flex align-items-start">
                                    <i className="bi bi-check-circle-fill me-3 fs-4"></i>
                                    <div>
                                        <strong>No device restrictions</strong>
                                        <p className="mb-0 small opacity-90">Access from any device</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div className="col-lg-6">
                            <div className="card shadow-lg border-0">
                                <div className="card-body p-5">
                                    <div className="text-center mb-4">
                                        <div className="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                             style={{width: '100px', height: '100px', background: 'rgba(236, 104, 42, 0.1) !important'}}>
                                            <i className="bi bi-star-fill fs-1" style={{color: '#ec682a'}}></i>
                                        </div>
                                        <h3 className="fw-bold mb-2">SOCIALPLUS</h3>
                                        <p className="text-muted">Premium Subscription</p>
                                    </div>
                                    <div className="text-center mb-4">
                                        <span className="display-3 fw-bold" style={{color: '#ec682a'}}>Free</span>
                                        <span className="text-muted fs-4"> to start</span>
                                        <p className="text-muted small mt-2">Upgrade anytime for full access</p>
                                    </div>
                                    <a href="/register" className="btn w-100 btn-lg text-white fw-bold py-3 mb-3"
                                       style={{background: 'linear-gradient(135deg, #ec682a 0%, #d45a20 100%)', border: 'none', fontSize: '1.1rem'}}>
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

            {/* FAQ Section */}
            <section id="faq" className="py-5 bg-light">
                <div className="container">
                    <div className="text-center mb-5">
                        <h2 className="display-4 fw-bold mb-3" style={{color: '#5c5c5c'}}>Frequently Asked Questions</h2>
                        <p className="lead text-muted">Everything you need to know</p>
                    </div>
                    <div className="row justify-content-center">
                        <div className="col-lg-8">
                            <div className="accordion" id="faqAccordion">
                                <div className="accordion-item border-0 shadow-sm mb-3">
                                    <h2 className="accordion-header">
                                        <button className="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                            What is SOCIALPLUS subscription?
                                        </button>
                                    </h2>
                                    <div id="faq1" className="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                        <div className="accordion-body text-muted">
                                            SOCIALPLUS is our premium subscription that gives you access to all locked sessions and premium content.
                                            It requires a username and password account and unlocks all features of the platform.
                                        </div>
                                    </div>
                                </div>
                                <div className="accordion-item border-0 shadow-sm mb-3">
                                    <h2 className="accordion-header">
                                        <button className="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                            How does the subject organization work?
                                        </button>
                                    </h2>
                                    <div id="faq2" className="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div className="accordion-body text-muted">
                                            Courses are organized by subject matter, not just by year. Each subject can be assigned to multiple years
                                            and specializations. At the beginning of each academic year, administrators can easily redistribute subjects
                                            by specialty and year.
                                        </div>
                                    </div>
                                </div>
                                <div className="accordion-item border-0 shadow-sm mb-3">
                                    <h2 className="accordion-header">
                                        <button className="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                            Can I access my account from multiple devices?
                                        </button>
                                    </h2>
                                    <div id="faq3" className="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div className="accordion-body text-muted">
                                            For security reasons, your account can only be accessed from one device at a time. If you try to access
                                            from another device while logged in elsewhere, you'll be automatically logged out from the previous device.
                                        </div>
                                    </div>
                                </div>
                                <div className="accordion-item border-0 shadow-sm mb-3">
                                    <h2 className="accordion-header">
                                        <button className="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                            What is the watermark feature?
                                        </button>
                                    </h2>
                                    <div id="faq4" className="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div className="accordion-body text-muted">
                                            Locked sessions display your username as a watermark. This watermark is designed to be visible but
                                            doesn't interfere with content readability. It helps protect intellectual property and prevent unauthorized sharing.
                                        </div>
                                    </div>
                                </div>
                                <div className="accordion-item border-0 shadow-sm mb-3">
                                    <h2 className="accordion-header">
                                        <button className="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                            Can I download content from the platform?
                                        </button>
                                    </h2>
                                    <div id="faq5" className="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div className="accordion-body text-muted">
                                            No, downloads are not allowed. All content is streamed directly from the platform to ensure security
                                            and protect intellectual property. Everything is accessible online through your browser.
                                        </div>
                                    </div>
                                </div>
                                <div className="accordion-item border-0 shadow-sm mb-3">
                                    <h2 className="accordion-header">
                                        <button className="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                            How do I recover my password?
                                        </button>
                                    </h2>
                                    <div id="faq6" className="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div className="accordion-body text-muted">
                                            Click "Forgot password?" on the login page, enter your email address, and we'll send you a password reset link.
                                            Follow the instructions in the email to create a new password.
                                        </div>
                                    </div>
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
                            <h2 className="display-5 fw-bold mb-3" style={{color: '#5c5c5c'}}>
                                Ready to Start Learning?
                            </h2>
                            <p className="lead text-muted fs-5 mb-5">
                                Join thousands of students already using Social Plus to excel in their studies.
                                Start your journey today - it's free!
                            </p>
                            <div className="d-flex gap-3 justify-content-center flex-wrap">
                                <a href="/register" className="btn btn-lg px-5 py-3 text-white fw-bold"
                                   style={{background: 'linear-gradient(135deg, #ec682a 0%, #d45a20 100%)', border: 'none', fontSize: '1.1rem'}}>
                                    <i className="bi bi-person-plus me-2"></i>
                                    Create Free Account
                                </a>
                                <a href="/login" className="btn btn-lg btn-outline-secondary px-5 py-3 fw-bold" style={{fontSize: '1.1rem'}}>
                                    <i className="bi bi-box-arrow-in-right me-2"></i>
                                    Sign In
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Footer - Enhanced */}
            <footer className="bg-dark text-white py-5">
                <div className="container">
                    <div className="row g-4">
                        <div className="col-md-4">
                            <h5 className="fw-bold mb-3">
                                <i className="bi bi-book-fill me-2" style={{color: '#ec682a'}}></i>
                                Social Plus
                            </h5>
                            <p className="text-muted small">
                                Your complete learning platform for social sciences.
                                Access courses, sessions, and materials organized by subject.
                            </p>
                        </div>
                        <div className="col-md-2">
                            <h6 className="fw-bold mb-3">Quick Links</h6>
                            <ul className="list-unstyled">
                                <li className="mb-2"><a href="/" className="text-white-50 text-decoration-none small">Home</a></li>
                                <li className="mb-2"><a href="#features" className="text-white-50 text-decoration-none small">Features</a></li>
                                <li className="mb-2"><a href="#subscription" className="text-white-50 text-decoration-none small">Pricing</a></li>
                                <li className="mb-2"><a href="#faq" className="text-white-50 text-decoration-none small">FAQ</a></li>
                            </ul>
                        </div>
                        <div className="col-md-2">
                            <h6 className="fw-bold mb-3">Legal</h6>
                            <ul className="list-unstyled">
                                <li className="mb-2"><a href="/terms" className="text-white-50 text-decoration-none small">Terms</a></li>
                                <li className="mb-2"><a href="/privacy" className="text-white-50 text-decoration-none small">Privacy</a></li>
                            </ul>
                        </div>
                        <div className="col-md-2">
                            <h6 className="fw-bold mb-3">Account</h6>
                            <ul className="list-unstyled">
                                <li className="mb-2"><a href="/login" className="text-white-50 text-decoration-none small">Login</a></li>
                                <li className="mb-2"><a href="/register" className="text-white-50 text-decoration-none small">Register</a></li>
                            </ul>
                        </div>
                        <div className="col-md-2">
                            <h6 className="fw-bold mb-3">Contact</h6>
                            <ul className="list-unstyled">
                                <li className="mb-2"><a href="#" className="text-white-50 text-decoration-none small">Support</a></li>
                                <li className="mb-2"><a href="#" className="text-white-50 text-decoration-none small">Help Center</a></li>
                            </ul>
                        </div>
                    </div>
                    <hr className="my-4 border-secondary" />
                    <div className="row align-items-center">
                        <div className="col-md-6">
                            <p className="mb-0 small text-muted">
                                <i className="bi bi-c-circle me-1"></i>
                                2024 Social Plus. All rights reserved.
                            </p>
                        </div>
                        <div className="col-md-6 text-md-end mt-3 mt-md-0">
                            <div className="d-flex gap-3 justify-content-md-end">
                                <a href="#" className="text-white-50"><i className="bi bi-facebook fs-5"></i></a>
                                <a href="#" className="text-white-50"><i className="bi bi-twitter fs-5"></i></a>
                                <a href="#" className="text-white-50"><i className="bi bi-linkedin fs-5"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    );
};

export default Welcome;
