import { Link } from '@inertiajs/react';
import { motion } from 'framer-motion';

export default function Footer() {
    const containerVariants = {
        hidden: { opacity: 0 },
        visible: {
            opacity: 1,
            transition: {
                staggerChildren: 0.1
            }
        }
    };

    const itemVariants = {
        hidden: { opacity: 0, y: 20 },
        visible: {
            opacity: 1,
            y: 0,
            transition: {
                duration: 0.5
            }
        }
    };

    return (
        <motion.footer 
            className="bg-gradient-to-br from-[#1e3a8a] via-[#3b82f6] to-[#1e3a8a] py-10 sm:py-12 md:py-16 px-4 border-t-4 border-[#ec682a] overflow-visible" 
            style={{ borderTopLeftRadius: '3rem', borderTopRightRadius: '3rem' }}
            initial={{ opacity: 0 }}
            whileInView={{ opacity: 1 }}
            viewport={{ once: true, margin: "-100px" }}
            transition={{ duration: 0.6 }}
        >
            <div className="container mx-auto max-w-6xl">
                <motion.div 
                    className="grid sm:grid-cols-2 md:grid-cols-4 gap-8 sm:gap-10 md:gap-12 mb-8 sm:mb-10 md:mb-12"
                    variants={containerVariants}
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true }}
                >
                    {/* Brand Section */}
                    <motion.div className="sm:col-span-2 md:col-span-1" variants={itemVariants}>
                        <div className="flex items-center space-x-2 mb-3 sm:mb-4">
                            <div className="w-10 h-10 bg-gradient-to-br from-[#ec682a] to-[#d45a20] rounded-xl flex items-center justify-center">
                                <i className="fas fa-book text-white"></i>
                            </div>
                            <span className="text-lg sm:text-xl font-bold text-white">ESIB SOCIAL</span>
                        </div>
                        <p className="text-white/80 text-xs sm:text-sm leading-relaxed">
                            Your comprehensive learning platform for social sciences.
                        </p>
                    </motion.div>

                    {/* Quick Links */}
                    <motion.div variants={itemVariants}>
                        <h4 className="font-bold text-base sm:text-lg mb-3 sm:mb-4 text-white">Quick Links</h4>
                        <ul className="space-y-2">
                            <li>
                                <Link
                                    href="/"
                                    className="text-white/80 hover:text-white transition-colors text-xs sm:text-sm no-underline"
                                >
                                    Home
                                </Link>
                            </li>
                            <li>
                                <Link
                                    href="/about"
                                    className="text-white/80 hover:text-white transition-colors text-xs sm:text-sm no-underline"
                                >
                                    About
                                </Link>
                            </li>
                            <li>
                                <Link
                                    href="/academique"
                                    className="text-white/80 hover:text-white transition-colors text-xs sm:text-sm no-underline"
                                >
                                    Académique
                                </Link>
                            </li>
                            <li>
                                <Link
                                    href="/calculatrice"
                                    className="text-white/80 hover:text-white transition-colors text-xs sm:text-sm no-underline"
                                >
                                    Calculatrice
                                </Link>
                            </li>
                        </ul>
                    </motion.div>

                    {/* Resources */}
                    <motion.div variants={itemVariants}>
                        <h4 className="font-bold text-base sm:text-lg mb-3 sm:mb-4 text-white">Resources</h4>
                        <ul className="space-y-2">
                            <li>
                                <a href="/login" className="text-white/80 hover:text-white transition-colors text-xs sm:text-sm no-underline">
                                    Login
                                </a>
                            </li>
                            <li>
                                <a href="/register" className="text-white/80 hover:text-white transition-colors text-xs sm:text-sm no-underline">
                                    Sign Up
                                </a>
                            </li>
                            <li>
                                <a href="/calculator" className="text-white/80 hover:text-white transition-colors text-xs sm:text-sm no-underline">
                                    Calculator
                                </a>
                            </li>
                            <li>
                                <a href="/subscriptions" className="text-white/80 hover:text-white transition-colors text-xs sm:text-sm no-underline">
                                    SOCIALPLUS
                                </a>
                            </li>
                        </ul>
                    </motion.div>

                    {/* Social Media */}
                    <motion.div variants={itemVariants}>
                        <h4 className="font-bold text-base sm:text-lg mb-3 sm:mb-4 text-white">Connect</h4>
                        <div className="flex space-x-3 sm:space-x-4 mb-3 sm:mb-4">
                            <a
                                href="https://instagram.com"
                                target="_blank"
                                rel="noopener noreferrer"
                                className="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-[#ec682a] to-[#d45a20] hover:shadow-lg rounded-lg flex items-center justify-center transition-all"
                                aria-label="Instagram"
                            >
                                <i className="fab fa-instagram text-white text-sm sm:text-base"></i>
                            </a>
                            <a
                                href="https://facebook.com"
                                target="_blank"
                                rel="noopener noreferrer"
                                className="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-[#ec682a] to-[#d45a20] hover:shadow-lg rounded-lg flex items-center justify-center transition-all"
                                aria-label="Facebook"
                            >
                                <i className="fab fa-facebook text-white text-sm sm:text-base"></i>
                            </a>
                            <a
                                href="https://twitter.com"
                                target="_blank"
                                rel="noopener noreferrer"
                                className="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-[#ec682a] to-[#d45a20] hover:shadow-lg rounded-lg flex items-center justify-center transition-all"
                                aria-label="Twitter"
                            >
                                <i className="fab fa-twitter text-white text-sm sm:text-base"></i>
                            </a>
                        </div>
                        <p className="text-white/80 text-xs sm:text-sm">
                            Follow us for updates
                        </p>
                    </motion.div>
                </motion.div>

                {/* Bottom Bar */}
                <motion.div 
                    className="border-t border-white/20 pt-6 sm:pt-8 mt-6 sm:mt-8"
                    initial={{ opacity: 0 }}
                    whileInView={{ opacity: 1 }}
                    viewport={{ once: true }}
                    transition={{ duration: 0.6, delay: 0.3 }}
                >
                    <div className="flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0 text-center sm:text-left">
                        <p className="text-white/70 text-xs sm:text-sm">
                            © {new Date().getFullYear()} ESIB SOCIAL. All rights reserved.
                        </p>
                        <div className="flex flex-wrap justify-center sm:justify-end gap-4 sm:gap-6 text-xs sm:text-sm">
                            <a href="/privacy" className="text-white/70 hover:text-white transition-colors no-underline">
                                Privacy Policy
                            </a>
                            <a href="/terms" className="text-white/70 hover:text-white transition-colors no-underline">
                                Terms of Service
                            </a>
                        </div>
                    </div>
                </motion.div>
            </div>
        </motion.footer>
    );
}
