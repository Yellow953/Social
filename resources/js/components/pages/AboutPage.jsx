import { motion } from "framer-motion";

export default function AboutPage() {
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
        hidden: { opacity: 0, y: 30 },
        visible: {
            opacity: 1,
            y: 0,
            transition: {
                duration: 0.6,
            },
        },
    };

    const stats = [
        { number: "1000+", label: "Active Students", icon: "fas fa-users" },
        { number: "50+", label: "Courses", icon: "fas fa-book" },
        { number: "500+", label: "Video Sessions", icon: "fas fa-video" },
        { number: "24/7", label: "Support", icon: "fas fa-headset" },
    ];

    const values = [
        {
            icon: "fas fa-lightbulb",
            title: "Innovation",
            desc: "Cutting-edge learning platform with modern technology",
        },
        {
            icon: "fas fa-heart",
            title: "Accessibility",
            desc: "Making education accessible to all students",
        },
        {
            icon: "fas fa-rocket",
            title: "Excellence",
            desc: "Committed to academic excellence and student success",
        },
        {
            icon: "fas fa-handshake",
            title: "Community",
            desc: "Building a supportive learning community",
        },
    ];

    return (
        <motion.section
            className="min-h-screen px-4 py-12 sm:py-16 md:py-20 pt-24 sm:pt-28 md:pt-32 bg-gradient-to-br from-[#eef1f7] via-white to-orange-50"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration: 0.6 }}
        >
            <div className="container mx-auto max-w-7xl">
                {/* Hero Section */}
                <motion.div
                    className="text-center mb-12 sm:mb-16 md:mb-20"
                    initial={{ opacity: 0, y: -30 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.6, delay: 0.2 }}
                >
                    <motion.div
                        className="inline-block mb-6"
                        whileHover={{ scale: 1.05 }}
                        transition={{ type: "spring", stiffness: 300 }}
                    >
                        <img
                            src="/assets/images/logo-transparent.png"
                            alt="ESIB Social"
                            className="h-24 w-auto sm:h-32 object-contain drop-shadow-2xl mx-auto"
                        />
                    </motion.div>
                    <h2 className="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-[#5c5c5c] mb-4 sm:mb-6">
                        About{" "}
                        <span className="bg-gradient-to-r from-[#ec682a] to-[#d45a20] bg-clip-text text-transparent">
                            ESIB SOCIAL
                        </span>
                    </h2>
                    <div className="w-32 h-1.5 bg-gradient-to-r from-[#ec682a] to-[#d45a20] mx-auto mb-6 sm:mb-8"></div>
                    <p className="text-lg sm:text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto px-4 leading-relaxed">
                        Empowering students with organized, accessible, and
                        comprehensive learning resources for academic excellence
                    </p>
                </motion.div>

                {/* Stats Section */}
                <motion.div
                    className="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-12 sm:mb-16"
                    variants={containerVariants}
                    initial="hidden"
                    animate="visible"
                >
                    {stats.map((stat, index) => {
                        const isOrange = index % 2 === 0;
                        return (
                        <motion.div
                            key={index}
                            className={`bg-white rounded-2xl p-6 sm:p-8 shadow-lg border-2 border-gray-100 transition-all text-center ${isOrange ? "hover:border-[#ec682a]" : "hover:border-[#1a2744]"}`}
                            variants={itemVariants}
                            whileHover={{ scale: 1.05, y: -5 }}
                        >
                            <div className={`w-12 h-12 sm:w-16 sm:h-16 rounded-xl flex items-center justify-center mx-auto mb-3 sm:mb-4 ${isOrange ? "bg-gradient-to-br from-[#ec682a] to-[#c2410c]" : "bg-gradient-to-br from-[#1a2744] to-[#243b55]"}`}>
                                <i
                                    className={`${stat.icon} text-white text-lg sm:text-2xl`}
                                ></i>
                            </div>
                            <div className="text-3xl sm:text-4xl md:text-5xl font-bold text-[#5c5c5c] mb-2">
                                {stat.number}
                            </div>
                            <div className="text-xs sm:text-sm text-gray-600">
                                {stat.label}
                            </div>
                        </motion.div>
                        );
                    })}
                </motion.div>

                {/* Mission & Vision Cards */}
                <motion.div
                    className="grid sm:grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-10 md:gap-12 mb-12 sm:mb-16"
                    variants={containerVariants}
                    initial="hidden"
                    animate="visible"
                >
                    <motion.div
                        className="bg-gradient-to-br from-white to-[#eef1f7] rounded-3xl shadow-2xl p-8 sm:p-10 border-2 border-[#1a2744]/20 relative overflow-hidden"
                        variants={itemVariants}
                        whileHover={{ scale: 1.02, y: -5 }}
                    >
                        <div className="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#1a2744]/20 to-transparent rounded-bl-full"></div>
                        <div className="relative z-10">
                            <div className="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-[#ec682a] to-[#d45a20] rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                                <i className="fas fa-bullseye text-white text-2xl sm:text-3xl"></i>
                            </div>
                            <h3 className="text-2xl sm:text-3xl font-bold text-[#5c5c5c] mb-4 sm:mb-6">
                                Our Mission
                            </h3>
                            <p className="text-gray-600 text-base sm:text-lg leading-relaxed mb-4">
                                ESIB SOCIAL is your comprehensive learning
                                platform for social sciences. We provide
                                organized access to courses, sessions, and
                                materials to help you excel in your studies.
                            </p>
                            <p className="text-gray-600 text-base sm:text-lg leading-relaxed">
                                Our mission is to democratize access to quality
                                education and empower every student to achieve
                                their academic goals.
                            </p>
                        </div>
                    </motion.div>

                    <motion.div
                        className="bg-gradient-to-br from-white to-orange-50 rounded-3xl shadow-2xl p-8 sm:p-10 border-2 border-orange-200 relative overflow-hidden"
                        variants={itemVariants}
                        whileHover={{ scale: 1.02, y: -5 }}
                    >
                        <div className="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-400/20 to-transparent rounded-bl-full"></div>
                        <div className="relative z-10">
                            <div className="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-[#ec682a] to-[#d45a20] rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                                <i className="fas fa-eye text-white text-2xl sm:text-3xl"></i>
                            </div>
                            <h3 className="text-2xl sm:text-3xl font-bold text-[#5c5c5c] mb-4 sm:mb-6">
                                Our Vision
                            </h3>
                            <p className="text-gray-600 text-base sm:text-lg leading-relaxed mb-4">
                                To become the leading platform for social
                                sciences education, where courses are organized
                                by subject matter, making learning intuitive and
                                accessible.
                            </p>
                            <p className="text-gray-600 text-base sm:text-lg leading-relaxed">
                                We envision a future where every student has the
                                tools and resources they need to succeed,
                                regardless of their academic level or
                                background.
                            </p>
                        </div>
                    </motion.div>
                </motion.div>

                {/* CTA Section */}
                <motion.div
                    className="mt-12 sm:mt-16 text-center"
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.6, delay: 0.6 }}
                >
                    <div className="bg-gradient-to-r from-[#1a2744] to-[#243b55] rounded-2xl p-8 sm:p-12 shadow-2xl">
                        <h3 className="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-4 sm:mb-6">
                            Ready to Start Your Learning Journey?
                        </h3>
                        <p className="text-white/90 text-base sm:text-lg mb-6 sm:mb-8 max-w-2xl mx-auto">
                            Join thousands of students who are already using
                            ESIB SOCIAL to excel in their studies
                        </p>
                        <div className="flex flex-col sm:flex-row justify-center items-center gap-4">
                            <motion.a
                                href="/register"
                                className="px-4 py-2 bg-white text-[#1a2744] font-bold rounded-xl hover:shadow-xl transition-all no-underline text-lg"
                                whileHover={{ scale: 1.05 }}
                                whileTap={{ scale: 0.95 }}
                            >
                                Get Started Free
                            </motion.a>
                            <motion.a
                                href="/login"
                                className="px-4 py-2 bg-white/20 backdrop-blur-sm text-white font-bold rounded-xl border-2 border-white/50 hover:bg-white/30 transition-all no-underline text-lg"
                                whileHover={{ scale: 1.05 }}
                                whileTap={{ scale: 0.95 }}
                            >
                                Login
                            </motion.a>
                        </div>
                    </div>
                </motion.div>
            </div>
        </motion.section>
    );
}
