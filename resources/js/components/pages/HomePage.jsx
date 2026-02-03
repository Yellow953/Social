import { useState, useEffect } from "react";
import { motion } from "framer-motion";

export default function HomePage() {
    const [carouselIndex, setCarouselIndex] = useState(0);

    const contentBoxes = [
        {
            id: 1,
            title: "Welcome to ESIB SOCIAL",
            description:
                "Your comprehensive learning platform for social sciences. Access courses, sessions, and materials organized by subject.",
            icon: "fas fa-graduation-cap",
        },
        {
            id: 2,
            title: "Premium Content Access",
            description:
                "Subscribe to SOCIALPLUS to unlock all locked sessions and premium materials. Get approved by admin for full access.",
            icon: "fas fa-star",
        },
        {
            id: 3,
            title: "Organized by Subject",
            description:
                "Courses organized by subject matter, not just by year. Easy to find what you need when you need it.",
            icon: "fas fa-book-open",
        },
    ];

    const nextCarousel = () => {
        setCarouselIndex((prev) => (prev + 1) % contentBoxes.length);
    };

    const prevCarousel = () => {
        setCarouselIndex(
            (prev) => (prev - 1 + contentBoxes.length) % contentBoxes.length,
        );
    };

    // Auto-play carousel
    useEffect(() => {
        const interval = setInterval(() => {
            setCarouselIndex((prev) => (prev + 1) % contentBoxes.length);
        }, 5000);
        return () => clearInterval(interval);
    }, [contentBoxes.length]);

    const containerVariants = {
        hidden: { opacity: 0 },
        visible: {
            opacity: 1,
            transition: {
                staggerChildren: 0.1,
            },
        },
    };

    const itemVariants = {
        hidden: { opacity: 0, y: 20 },
        visible: {
            opacity: 1,
            y: 0,
            transition: {
                duration: 0.5,
            },
        },
    };

    return (
        <>
            {/* Hero Section */}
            <motion.section
                className="relative py-12 sm:py-16 md:py-24 px-4 overflow-hidden"
                style={{
                    background:
                        "linear-gradient(135deg, #1a2744 0%, #243b55 50%, #2a3f5c 100%)",
                    paddingTop: "7rem",
                }}
                initial={{ opacity: 0 }}
                animate={{ opacity: 1 }}
                transition={{ duration: 0.6 }}
            >
                {/* Decorative Bubbles */}
                <div
                    className="absolute top-0 left-0 w-full h-full"
                    style={{ opacity: 0.4 }}
                >
                    <div
                        className="absolute animate-pulse"
                        style={{
                            top: "10%",
                            left: "10%",
                            width: "200px",
                            height: "200px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                        }}
                    ></div>
                    <div
                        className="absolute animate-pulse"
                        style={{
                            top: "60%",
                            right: "15%",
                            width: "150px",
                            height: "150px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                            animationDelay: "1s",
                        }}
                    ></div>
                    <div
                        className="absolute animate-pulse"
                        style={{
                            bottom: "20%",
                            left: "20%",
                            width: "100px",
                            height: "100px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                            animationDelay: "2s",
                        }}
                    ></div>
                    <div
                        className="absolute animate-pulse"
                        style={{
                            top: "30%",
                            right: "30%",
                            width: "120px",
                            height: "120px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                            animationDelay: "0.5s",
                        }}
                    ></div>
                    <div
                        className="absolute animate-pulse"
                        style={{
                            bottom: "40%",
                            right: "10%",
                            width: "80px",
                            height: "80px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                            animationDelay: "1.5s",
                        }}
                    ></div>
                    <div
                        className="absolute animate-pulse"
                        style={{
                            top: "50%",
                            left: "50%",
                            width: "60px",
                            height: "60px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                            animationDelay: "0.8s",
                        }}
                    ></div>
                    <div
                        className="absolute animate-pulse"
                        style={{
                            top: "5%",
                            right: "5%",
                            width: "90px",
                            height: "90px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                            animationDelay: "1.2s",
                        }}
                    ></div>
                    <div
                        className="absolute animate-pulse"
                        style={{
                            bottom: "10%",
                            left: "5%",
                            width: "70px",
                            height: "70px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                            animationDelay: "0.3s",
                        }}
                    ></div>
                    <div
                        className="absolute animate-pulse"
                        style={{
                            top: "75%",
                            left: "40%",
                            width: "110px",
                            height: "110px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                            animationDelay: "1.8s",
                        }}
                    ></div>
                    <div
                        className="absolute animate-pulse"
                        style={{
                            top: "15%",
                            right: "50%",
                            width: "85px",
                            height: "85px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                            animationDelay: "0.6s",
                        }}
                    ></div>
                    <div
                        className="absolute animate-pulse"
                        style={{
                            bottom: "5%",
                            right: "25%",
                            width: "95px",
                            height: "95px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                            animationDelay: "1.4s",
                        }}
                    ></div>
                    <div
                        className="absolute animate-pulse"
                        style={{
                            top: "40%",
                            left: "5%",
                            width: "75px",
                            height: "75px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                            animationDelay: "2.2s",
                        }}
                    ></div>
                </div>

                <div className="container mx-auto max-w-6xl relative z-10">
                    {/* Logo */}
                    <motion.div
                        className="flex justify-center mb-4 sm:mb-6"
                        initial={{ opacity: 0, y: -20 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{ duration: 0.5 }}
                    >
                        <img
                            src="/assets/images/logo-transparent.png"
                            alt="ESIB Social"
                            className="h-16 sm:h-20 md:h-24 w-auto object-contain drop-shadow-lg"
                        />
                    </motion.div>
                    {/* Main Title with Gradient */}
                    <motion.div
                        className="text-center mb-6 sm:mb-8"
                        initial={{ opacity: 0, y: -30 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{ duration: 0.6, delay: 0.2 }}
                    >
                        <h1
                            className="text-4xl sm:text-6xl md:text-8xl lg:text-9xl font-bold mb-4"
                            style={{
                                background:
                                    "linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%)",
                                WebkitBackgroundClip: "text",
                                WebkitTextFillColor: "transparent",
                                textShadow: "0 4px 20px rgba(255,255,255,0.3)",
                            }}
                        >
                            ESIB SOCIAL
                        </h1>
                        <div className="w-24 sm:w-32 h-1 bg-gradient-to-r from-[#ec682a] to-[#d45a20] mx-auto mb-4 sm:mb-6"></div>
                    </motion.div>
                    <motion.p
                        className="text-lg sm:text-xl md:text-2xl text-center text-white mb-8 sm:mb-12 max-w-3xl mx-auto font-medium px-4"
                        style={{ textShadow: "0 2px 10px rgba(0,0,0,0.2)" }}
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                        transition={{ duration: 0.6, delay: 0.4 }}
                    >
                        Your comprehensive learning platform for social sciences
                    </motion.p>

                    {/* CTA Buttons */}
                    <motion.div
                        className="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4 mb-12 sm:mb-16 px-4"
                        initial={{ opacity: 0, y: 20 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{ duration: 0.6, delay: 0.6 }}
                    >
                        <a
                            href="/register"
                            className="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-[#ec682a] to-[#d45a20] text-white font-bold rounded-xl hover:shadow-2xl hover:scale-105 transition-all no-underline text-base sm:text-lg transform text-center"
                        >
                            Get Started Free
                        </a>
                        <a
                            href="/login"
                            className="w-full sm:w-auto px-6 py-3 bg-white/10 backdrop-blur-sm text-white font-bold rounded-xl border-2 border-white/30 hover:bg-white/20 hover:border-white/50 transition-all no-underline text-base sm:text-lg text-center"
                        >
                            Login
                        </a>
                    </motion.div>

                    {/* Content Boxes Carousel */}
                    <motion.div
                        className="w-full max-w-5xl mx-auto relative px-4"
                        initial={{ opacity: 0, scale: 0.9 }}
                        animate={{ opacity: 1, scale: 1 }}
                        transition={{ duration: 0.6, delay: 0.8 }}
                    >
                        <div className="relative overflow-hidden rounded-xl">
                            <motion.div
                                className="flex transition-transform duration-500 ease-in-out"
                                style={{
                                    transform: `translateX(-${carouselIndex * 100}%)`,
                                }}
                                key={carouselIndex}
                                initial={{ opacity: 0, x: 50 }}
                                animate={{ opacity: 1, x: 0 }}
                                transition={{ duration: 0.5 }}
                            >
                                {contentBoxes.map((box) => (
                                    <div
                                        key={box.id}
                                        className="min-w-full bg-white rounded-xl p-6 sm:p-8 md:p-12 border-2 shadow-lg flex flex-col items-center text-center"
                                        style={{ borderColor: "#ec682a" }}
                                    >
                                        <div className="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-[#ec682a] to-[#d45a20] rounded-xl flex items-center justify-center mb-4 sm:mb-6">
                                            <i
                                                className={`${box.icon} text-white text-2xl sm:text-3xl`}
                                            ></i>
                                        </div>
                                        <h3 className="text-2xl sm:text-3xl font-bold text-[#5c5c5c] mb-3 sm:mb-4">
                                            {box.title}
                                        </h3>
                                        <p className="text-gray-600 text-base sm:text-lg max-w-2xl">
                                            {box.description}
                                        </p>
                                    </div>
                                ))}
                            </motion.div>
                        </div>

                        {/* Carousel Navigation */}
                        <div className="flex justify-center items-center mt-6 sm:mt-8 space-x-3">
                            {contentBoxes.map((_, index) => (
                                <button
                                    key={index}
                                    onClick={() => setCarouselIndex(index)}
                                    className={`rounded-full transition-all ${
                                        index === carouselIndex
                                            ? "bg-gradient-to-r from-[#ec682a] to-[#d45a20] w-5 h-5 shadow-md"
                                            : "bg-gray-300 w-3 h-3 hover:bg-gray-400"
                                    }`}
                                    aria-label={`Go to slide ${index + 1}`}
                                />
                            ))}
                        </div>

                        {/* Previous Button */}
                        <button
                            onClick={prevCarousel}
                            className="absolute left-2 sm:left-4 top-1/2 transform -translate-y-1/2 bg-white/95 backdrop-blur-md text-[#ec682a] w-10 h-10 sm:w-14 sm:h-14 rounded-full flex items-center justify-center hover:bg-white hover:shadow-2xl transition-all shadow-xl z-10 border-2 border-orange-100"
                            aria-label="Previous slide"
                        >
                            <i className="fas fa-chevron-left text-sm sm:text-xl"></i>
                        </button>

                        {/* Next Button */}
                        <button
                            onClick={nextCarousel}
                            className="absolute right-2 sm:right-4 top-1/2 transform -translate-y-1/2 bg-white/95 backdrop-blur-md text-[#ec682a] w-10 h-10 sm:w-14 sm:h-14 rounded-full flex items-center justify-center hover:bg-white hover:shadow-2xl transition-all shadow-xl z-10 border-2 border-orange-100"
                            aria-label="Next slide"
                        >
                            <i className="fas fa-chevron-right text-sm sm:text-xl"></i>
                        </button>
                    </motion.div>
                </div>
            </motion.section>

            {/* Features Section */}
            <motion.section
                className="py-12 sm:py-16 md:py-24 px-4 bg-gradient-to-br from-gray-50 via-white to-[#eef1f7]"
                initial={{ opacity: 0 }}
                whileInView={{ opacity: 1 }}
                viewport={{ once: true, margin: "-100px" }}
                transition={{ duration: 0.6 }}
            >
                <div className="container mx-auto max-w-6xl">
                    <motion.div
                        className="text-center mb-8 sm:mb-12 md:mb-16"
                        initial={{ opacity: 0, y: 20 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.6 }}
                    >
                        <h2 className="text-3xl sm:text-4xl md:text-5xl font-bold text-[#5c5c5c] mb-4">
                            Why Choose ESIB SOCIAL?
                        </h2>
                        <div className="w-24 h-1 bg-gradient-to-r from-[#ec682a] to-[#d45a20] mx-auto mb-4"></div>
                        <p className="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto px-4">
                            Discover the features that make learning easier and
                            more effective
                        </p>
                    </motion.div>

                    <motion.div
                        className="grid sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-8"
                        variants={containerVariants}
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: "-50px" }}
                    >
                        {[
                            {
                                icon: "fas fa-book-open",
                                title: "Organized by Subject",
                                desc: "Courses organized by subject matter, making it easy to find what you need",
                            },
                            {
                                icon: "fas fa-lock",
                                title: "Secure Access",
                                desc: "Premium content protected with SOCIALPLUS subscription system",
                            },
                            {
                                icon: "fas fa-users",
                                title: "Community Learning",
                                desc: "Join thousands of students learning together",
                            },
                            {
                                icon: "fas fa-calculator",
                                title: "Built-in Tools",
                                desc: "Calculate grades and track your academic performance",
                            },
                            {
                                icon: "fas fa-clock",
                                title: "Track Progress",
                                desc: "Monitor your learning progress and session access logs",
                            },
                            {
                                icon: "fas fa-mobile-alt",
                                title: "Single Device",
                                desc: "Secure single-device login for account protection",
                            },
                        ].map((feature, index) => {
                            const isOrange = index % 2 === 0;
                            return (
                            <motion.div
                                key={index}
                                className={`group bg-white rounded-2xl p-6 sm:p-8 border-2 border-gray-200 transition-all shadow-md hover:shadow-2xl transform hover:-translate-y-2 ${isOrange ? "hover:border-[#ec682a]" : "hover:border-[#1a2744]"}`}
                                variants={itemVariants}
                                whileHover={{ scale: 1.02 }}
                            >
                                <div className={`w-14 h-14 sm:w-16 sm:h-16 rounded-xl flex items-center justify-center mb-4 sm:mb-6 group-hover:scale-110 transition-transform ${isOrange ? "bg-gradient-to-br from-[#ec682a] to-[#c2410c]" : "bg-gradient-to-br from-[#1a2744] to-[#243b55]"}`}>
                                    <i
                                        className={`${feature.icon} text-white text-xl sm:text-2xl`}
                                    ></i>
                                </div>
                                <h3 className="text-lg sm:text-xl font-bold text-[#5c5c5c] mb-2 sm:mb-3">
                                    {feature.title}
                                </h3>
                                <p className="text-gray-600 text-sm sm:text-base leading-relaxed">
                                    {feature.desc}
                                </p>
                            </motion.div>
                            );
                        })}
                    </motion.div>
                </div>
            </motion.section>

            {/* Stats Section */}
            <motion.section
                className="py-12 sm:py-16 md:py-20 px-4 bg-gradient-to-br from-[#ec682a] to-[#d45a20]"
                initial={{ opacity: 0 }}
                whileInView={{ opacity: 1 }}
                viewport={{ once: true, margin: "-100px" }}
                transition={{ duration: 0.6 }}
            >
                <div className="container mx-auto max-w-6xl">
                    <motion.div
                        className="grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8 text-center text-white"
                        variants={containerVariants}
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                    >
                        {[
                            { number: "1000+", label: "Active Students" },
                            { number: "50+", label: "Courses Available" },
                            { number: "500+", label: "Video Sessions" },
                            { number: "24/7", label: "Access Anytime" },
                        ].map((stat, index) => (
                            <motion.div key={index} variants={itemVariants}>
                                <div className="text-3xl sm:text-4xl md:text-5xl font-bold mb-2">
                                    {stat.number}
                                </div>
                                <div className="text-sm sm:text-base md:text-lg opacity-90">
                                    {stat.label}
                                </div>
                            </motion.div>
                        ))}
                    </motion.div>
                </div>
            </motion.section>

            {/* CTA Section */}
            <motion.section
                className="py-12 sm:py-16 md:py-24 px-4 relative overflow-hidden"
                style={{
                    background:
                        "linear-gradient(135deg, #1a2744 0%, #243b55 100%)",
                }}
                initial={{ opacity: 0 }}
                whileInView={{ opacity: 1 }}
                viewport={{ once: true, margin: "-100px" }}
                transition={{ duration: 0.6 }}
            >
                <div className="absolute inset-0 opacity-20">
                    <div
                        className="absolute animate-pulse"
                        style={{
                            top: "20%",
                            left: "10%",
                            width: "150px",
                            height: "150px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                        }}
                    ></div>
                    <div
                        className="absolute animate-pulse"
                        style={{
                            bottom: "20%",
                            right: "10%",
                            width: "120px",
                            height: "120px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                            animationDelay: "1s",
                        }}
                    ></div>
                    <div
                        className="absolute animate-pulse"
                        style={{
                            top: "10%",
                            right: "20%",
                            width: "100px",
                            height: "100px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                            animationDelay: "0.5s",
                        }}
                    ></div>
                    <div
                        className="absolute animate-pulse"
                        style={{
                            bottom: "10%",
                            left: "20%",
                            width: "90px",
                            height: "90px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                            animationDelay: "1.5s",
                        }}
                    ></div>
                    <div
                        className="absolute animate-pulse"
                        style={{
                            top: "50%",
                            left: "5%",
                            width: "80px",
                            height: "80px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                            animationDelay: "0.8s",
                        }}
                    ></div>
                    <div
                        className="absolute animate-pulse"
                        style={{
                            top: "50%",
                            right: "5%",
                            width: "110px",
                            height: "110px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                            animationDelay: "1.2s",
                        }}
                    ></div>
                    <div
                        className="absolute animate-pulse"
                        style={{
                            top: "30%",
                            left: "50%",
                            width: "70px",
                            height: "70px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                            animationDelay: "0.3s",
                        }}
                    ></div>
                    <div
                        className="absolute animate-pulse"
                        style={{
                            bottom: "30%",
                            right: "30%",
                            width: "95px",
                            height: "95px",
                            background: "#ff6b35",
                            borderRadius: "50%",
                            animationDelay: "1.8s",
                        }}
                    ></div>
                </div>
                <div className="container mx-auto max-w-4xl text-center relative z-10">
                    <motion.h2
                        className="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4 sm:mb-6 px-4"
                        initial={{ opacity: 0, y: 20 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.6 }}
                    >
                        Ready to Start Learning?
                    </motion.h2>
                    <motion.p
                        className="text-lg sm:text-xl text-white/90 mb-8 sm:mb-10 max-w-2xl mx-auto px-4"
                        initial={{ opacity: 0, y: 20 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.6, delay: 0.2 }}
                    >
                        Join ESIB SOCIAL today and unlock access to premium
                        courses and materials
                    </motion.p>
                    <motion.div
                        className="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4 px-4"
                        initial={{ opacity: 0, y: 20 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.6, delay: 0.4 }}
                    >
                        <a
                            href="/register"
                            className="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-[#ec682a] to-[#d45a20] text-white font-bold rounded-xl hover:shadow-2xl hover:scale-105 transition-all no-underline text-base sm:text-lg transform text-center"
                        >
                            Create Account
                        </a>
                        <a
                            href="/login"
                            className="w-full sm:w-auto px-6 py-3 bg-white/10 backdrop-blur-sm text-white font-bold rounded-xl border-2 border-white/30 hover:bg-white/20 hover:border-white/50 transition-all no-underline text-base sm:text-lg text-center"
                        >
                            Login
                        </a>
                    </motion.div>
                </div>
            </motion.section>

            {/* Social Media & Contact Section */}
            <motion.section
                className="py-12 sm:py-16 md:py-20 px-4 bg-gradient-to-br from-[#eef1f7] via-white to-orange-50"
                initial={{ opacity: 0 }}
                whileInView={{ opacity: 1 }}
                viewport={{ once: true, margin: "-100px" }}
                transition={{ duration: 0.6 }}
            >
                <div className="container mx-auto max-w-6xl">
                    <motion.div
                        className="text-center mb-8 sm:mb-12"
                        initial={{ opacity: 0, y: 20 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.6 }}
                    >
                        <h2 className="text-2xl sm:text-3xl md:text-4xl font-bold text-[#5c5c5c] mb-4">
                            Stay Connected
                        </h2>
                        <p className="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto px-4">
                            Follow us on social media for updates,
                            announcements, and learning tips
                        </p>
                    </motion.div>

                    <motion.div
                        className="flex flex-wrap justify-center items-center gap-4 sm:gap-6 mb-8 sm:mb-12"
                        variants={containerVariants}
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                    >
                        {[
                            {
                                href: "https://instagram.com",
                                icon: "fab fa-instagram",
                                label: "Instagram",
                                color: "from-[#ec682a] to-[#d45a20]",
                            },
                            {
                                href: "https://facebook.com",
                                icon: "fab fa-facebook",
                                label: "Facebook",
                                color: "bg-[#1a2744]",
                            },
                            {
                                href: "https://twitter.com",
                                icon: "fab fa-twitter",
                                label: "Twitter",
                                color: "bg-sky-500",
                            },
                            {
                                href: "https://linkedin.com",
                                icon: "fab fa-linkedin",
                                label: "LinkedIn",
                                color: "bg-[#243b55]",
                            },
                        ].map((social, index) => (
                            <motion.a
                                key={index}
                                href={social.href}
                                target="_blank"
                                rel="noopener noreferrer"
                                className={`flex items-center space-x-2 sm:space-x-3 px-4 sm:px-6 py-3 sm:py-4 ${social.color.includes("from") ? `bg-gradient-to-r ${social.color}` : social.color} !text-white rounded-xl hover:shadow-xl transition-all no-underline font-medium transform hover:scale-105 text-sm sm:text-base`}
                                variants={itemVariants}
                                whileHover={{ scale: 1.1 }}
                                whileTap={{ scale: 0.95 }}
                            >
                                <i
                                    className={`${social.icon} text-lg sm:text-2xl !text-white`}
                                ></i>
                                <span className="!text-white">{social.label}</span>
                            </motion.a>
                        ))}
                    </motion.div>

                    <motion.div
                        className="text-center pt-6 sm:pt-8 border-t border-gray-200"
                        initial={{ opacity: 0 }}
                        whileInView={{ opacity: 1 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.6, delay: 0.3 }}
                    >
                        <p className="text-gray-600 mb-4 text-sm sm:text-base">
                            Have questions? We're here to help!
                        </p>
                        <a
                            href="mailto:support@esibsocial.com"
                            className="inline-flex items-center space-x-2 text-[#ec682a] hover:text-[#d45a20] transition-colors no-underline font-medium text-sm sm:text-base"
                        >
                            <i className="fas fa-envelope"></i>
                            <span>Contact Support</span>
                        </a>
                    </motion.div>
                </div>
            </motion.section>
        </>
    );
}
