import { Link } from "@inertiajs/react";
import { useState } from "react";
import { motion, AnimatePresence } from "framer-motion";

export default function Header({ activeTab }) {
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

    return (
        <nav
            className="fixed top-0 left-0 right-0 z-50 bg-white/50 backdrop-blur-md shadow-lg border-b border-gray-100/50 overflow-visible"
            style={{
                borderBottomLeftRadius: "3rem",
                borderBottomRightRadius: "3rem",
            }}
        >
            <div className="container mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex items-center justify-between h-20">
                    <Link
                        href="/"
                        className="flex items-center space-x-3 no-underline mr-8 group"
                        onClick={(e) => {
                            e.preventDefault();
                            setActiveTab("");
                            window.history.pushState(
                                null,
                                "",
                                window.location.pathname,
                            );
                        }}
                    >
                        <img
                            src="/assets/images/logo-transparent.png"
                            alt="ESIB Social"
                            className="w-12 h-12 object-contain group-hover:scale-110 transition-transform"
                        />
                        <span className="text-xl sm:text-2xl font-bold bg-gradient-to-r from-[#1a2744] to-[#243b55] bg-clip-text text-transparent">
                            ESIB SOCIAL
                        </span>
                    </Link>

                    {/* Desktop Navigation */}
                    <div className="hidden md:flex items-center space-x-1 flex-1 max-w-2xl mx-8">
                        <Link
                            href="/about"
                            className={`px-4 py-2 font-medium text-sm rounded-lg transition-all ${
                                activeTab === "about"
                                    ? "text-[#ec682a] border-b-2 border-[#ec682a]"
                                    : "text-[#5c5c5c] hover:text-[#ec682a]"
                            } no-underline`}
                        >
                            About
                        </Link>
                        <Link
                            href="/academique"
                            className={`px-4 py-2 font-medium text-sm rounded-lg transition-all ${
                                activeTab === "academique"
                                    ? "text-[#ec682a] border-b-2 border-[#ec682a]"
                                    : "text-[#5c5c5c] hover:text-[#ec682a]"
                            } no-underline`}
                        >
                            Académique
                        </Link>
                        <Link
                            href="/calculatrice"
                            className={`px-4 py-2 font-medium text-sm rounded-lg transition-all ${
                                activeTab === "calculatrice"
                                    ? "text-[#ec682a] border-b-2 border-[#ec682a]"
                                    : "text-[#5c5c5c] hover:text-[#ec682a]"
                            } no-underline`}
                        >
                            Calculatrice
                        </Link>
                    </div>

                    {/* Desktop Login Button */}
                    <a
                        href="/login"
                        className="hidden sm:flex px-5 py-2.5 rounded-full bg-gradient-to-br from-[#ec682a] to-[#d45a20] text-white items-center space-x-2 hover:shadow-lg hover:scale-105 transition-all shadow-md no-underline"
                        title="Login"
                    >
                        <i className="fas fa-sign-in-alt text-sm"></i>
                        <span className="text-sm font-bold">Login</span>
                    </a>

                    {/* Mobile Menu Button */}
                    <button
                        onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                        className="md:hidden w-10 h-10 rounded-lg bg-gradient-to-br from-[#ec682a] to-[#d45a20] text-white flex items-center justify-center shadow-md"
                        aria-label="Toggle menu"
                    >
                        <i
                            className={`fas ${mobileMenuOpen ? "fa-times" : "fa-bars"}`}
                        ></i>
                    </button>
                </div>

                {/* Mobile Menu */}
                <AnimatePresence>
                    {mobileMenuOpen && (
                        <motion.div
                            initial={{ opacity: 0, height: 0 }}
                            animate={{ opacity: 1, height: "auto" }}
                            exit={{ opacity: 0, height: 0 }}
                            transition={{ duration: 0.3 }}
                            className="md:hidden overflow-hidden"
                        >
                            <div className="py-4 space-y-2">
                                <Link
                                    href="/about"
                                    onClick={() => setMobileMenuOpen(false)}
                                    className={`block w-full text-left px-4 py-3 font-medium text-sm rounded-lg transition-all ${
                                        activeTab === "about"
                                            ? "text-[#ec682a] border-l-4 border-[#ec682a] bg-orange-50/50"
                                            : "text-[#5c5c5c] hover:text-[#ec682a] hover:bg-orange-50/30"
                                    } no-underline`}
                                >
                                    About
                                </Link>
                                <Link
                                    href="/academique"
                                    onClick={() => setMobileMenuOpen(false)}
                                    className={`block w-full text-left px-4 py-3 font-medium text-sm rounded-lg transition-all ${
                                        activeTab === "academique"
                                            ? "text-[#ec682a] border-l-4 border-[#ec682a] bg-orange-50/50"
                                            : "text-[#5c5c5c] hover:text-[#ec682a] hover:bg-orange-50/30"
                                    } no-underline`}
                                >
                                    Académique
                                </Link>
                                <Link
                                    href="/calculatrice"
                                    onClick={() => setMobileMenuOpen(false)}
                                    className={`block w-full text-left px-4 py-3 font-medium text-sm rounded-lg transition-all ${
                                        activeTab === "calculatrice"
                                            ? "text-[#ec682a] border-l-4 border-[#ec682a] bg-orange-50/50"
                                            : "text-[#5c5c5c] hover:text-[#ec682a] hover:bg-orange-50/30"
                                    } no-underline`}
                                >
                                    Calculatrice
                                </Link>
                                <a
                                    href="/login"
                                    className="block w-full text-center px-5 py-3.5 rounded-full bg-gradient-to-br from-[#ec682a] to-[#d45a20] text-white font-bold text-base shadow-md no-underline mt-4"
                                    onClick={() => setMobileMenuOpen(false)}
                                >
                                    <i className="fas fa-sign-in-alt mr-2"></i>
                                    Login
                                </a>
                            </div>
                        </motion.div>
                    )}
                </AnimatePresence>
            </div>
        </nav>
    );
}
