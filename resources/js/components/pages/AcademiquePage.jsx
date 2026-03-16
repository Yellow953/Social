import { useState } from "react";
import { motion } from "framer-motion";

const ALL_YEARS  = ['Sup', 'Spé', '1e', '2e', '3e'];
const ALL_MAJORS = [
    'Génie Informatique et Communications (GIC)',
    'Génie Mécanique (GM)',
    'Génie Industriel (GI)',
    'Génie Électrique (GE)',
    'Génie Chimique et Petrochimique (GCP)',
    'Génie Civil (GC)',
    'Concours',
];

export default function AcademiquePage() {
    const [selectedYear, setSelectedYear] = useState("");
    const [selectedMajor, setSelectedMajor] = useState("");

    return (
        <motion.section
            className="min-h-screen px-4 py-12 sm:py-16 md:py-20 pt-24 sm:pt-28 md:pt-32 bg-gradient-to-br from-[#eef1f7] via-white to-orange-50"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration: 0.6 }}
        >
            <div className="container mx-auto max-w-7xl">
                {/* Header */}
                <motion.div
                    className="text-center mb-10 sm:mb-12 md:mb-16"
                    initial={{ opacity: 0, y: -20 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.6, delay: 0.2 }}
                >
                    <div className="inline-block mb-6">
                        <div className="w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-[#ec682a] to-[#d45a20] rounded-2xl flex items-center justify-center shadow-2xl">
                            <i className="fas fa-book-open text-white text-3xl sm:text-4xl"></i>
                        </div>
                    </div>
                    <h2 className="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-[#5c5c5c] mb-4">
                        Académique
                    </h2>
                    <div className="w-32 h-1.5 bg-gradient-to-r from-[#ec682a] to-[#d45a20] mx-auto mb-4 sm:mb-6"></div>
                    <p className="text-lg sm:text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto px-4">
                        Explore courses and materials organized by year and
                        major. Find everything you need for your academic
                        journey.
                    </p>
                </motion.div>

                {/* Course Selection */}
                <motion.div
                    className="bg-white rounded-3xl shadow-2xl p-8 sm:p-10 mb-8 sm:mb-10 border-2 border-orange-200 relative overflow-hidden"
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.6, delay: 0.3 }}
                >
                    <div className="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-orange-400/10 to-transparent rounded-bl-full"></div>
                    <div className="relative z-10">
                        <div className="flex items-center mb-6 sm:mb-8">
                            <div className="w-12 h-12 bg-gradient-to-br from-[#ec682a] to-[#d45a20] rounded-xl flex items-center justify-center mr-4">
                                <i className="fas fa-filter text-white"></i>
                            </div>
                            <h3 className="text-2xl sm:text-3xl font-bold text-[#5c5c5c]">
                                Select Your Path
                            </h3>
                        </div>
                        <div className="grid sm:grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
                            <motion.div
                                whileHover={{ scale: 1.02 }}
                                transition={{ type: "spring", stiffness: 300 }}
                            >
                                <label className="block text-sm font-semibold text-gray-700 mb-3">
                                    Study Year
                                </label>
                                <select
                                    className="w-full px-5 py-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#ec682a] focus:border-[#ec682a] text-[#5c5c5c] bg-white text-base font-medium shadow-sm hover:border-[#ec682a] transition-all"
                                    value={selectedYear}
                                    onChange={(e) =>
                                        setSelectedYear(e.target.value)
                                    }
                                >
                                    <option value="">Select Year</option>
                                    {ALL_YEARS.map(y => (
                                        <option key={y} value={y}>{y}</option>
                                    ))}
                                </select>
                            </motion.div>
                            <motion.div
                                whileHover={{ scale: 1.02 }}
                                transition={{ type: "spring", stiffness: 300 }}
                            >
                                <label className="block text-sm font-semibold text-gray-700 mb-3">
                                    Major/Specialty
                                </label>
                                <select
                                    className="w-full px-5 py-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#ec682a] focus:border-[#ec682a] text-[#5c5c5c] bg-white text-base font-medium shadow-sm hover:border-[#ec682a] transition-all"
                                    value={selectedMajor}
                                    onChange={(e) =>
                                        setSelectedMajor(e.target.value)
                                    }
                                >
                                    <option value="">Select Major</option>
                                    {ALL_MAJORS.map(m => (
                                        <option key={m} value={m}>{m}</option>
                                    ))}
                                </select>
                            </motion.div>
                        </div>
                    </div>
                </motion.div>

                {/* Result / prompt area */}
                {selectedYear && selectedMajor ? (
                    <motion.div
                        key="cta"
                        className="bg-gradient-to-br from-white to-orange-50 rounded-3xl shadow-2xl p-12 sm:p-16 border-2 border-orange-200 relative overflow-hidden text-center"
                        initial={{ opacity: 0, y: 10 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{ duration: 0.3 }}
                    >
                        <div className="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-orange-400/10 to-transparent rounded-bl-full"></div>
                        <div className="relative z-10">
                            <div className="w-20 h-20 bg-gradient-to-br from-[#ec682a] to-[#d45a20] rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl">
                                <i className="fas fa-lock-open text-white text-3xl"></i>
                            </div>
                            <h3 className="text-2xl sm:text-3xl font-bold text-[#5c5c5c] mb-3">
                                {selectedYear} — {selectedMajor}
                            </h3>
                            <p className="text-gray-600 text-base sm:text-lg max-w-xl mx-auto mb-8">
                                Log in to browse all available courses and materials for this year and major.
                            </p>
                            <a
                                href="/login"
                                className="inline-block px-8 py-3 bg-gradient-to-r from-[#ec682a] to-[#d45a20] text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all"
                            >
                                <i className="fas fa-sign-in-alt mr-2"></i>Log in to access
                            </a>
                        </div>
                    </motion.div>
                ) : (
                    <motion.div
                        key="prompt"
                        className="bg-gradient-to-br from-white to-orange-50 rounded-3xl shadow-2xl p-12 sm:p-16 border-2 border-orange-200 relative overflow-hidden"
                        initial={{ opacity: 0, y: 10 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{ duration: 0.3 }}
                    >
                        <div className="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-orange-400/10 to-transparent rounded-bl-full"></div>
                        <div className="relative z-10 text-center py-8 sm:py-12">
                            <motion.div
                                className="w-24 h-24 sm:w-32 sm:h-32 bg-gradient-to-br from-[#ec682a] to-[#d45a20] rounded-2xl flex items-center justify-center mx-auto mb-6 sm:mb-8 shadow-2xl"
                                animate={{ rotate: [0, 5, -5, 0], scale: [1, 1.05, 1] }}
                                transition={{ duration: 3, repeat: Infinity, repeatDelay: 2 }}
                            >
                                <i className="fas fa-graduation-cap text-white text-4xl sm:text-5xl"></i>
                            </motion.div>
                            <h3 className="text-2xl sm:text-3xl md:text-4xl font-bold text-[#5c5c5c] mb-4 sm:mb-6">
                                Select Your Year and Major
                            </h3>
                            <p className="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto px-4 mb-6">
                                Choose your study year and major above to see what's available on the platform.
                            </p>
                            <div className="flex flex-wrap justify-center gap-4">
                                {ALL_YEARS.map((year) => (
                                    <motion.button
                                        key={year}
                                        onClick={() => setSelectedYear(year)}
                                        className="px-6 py-3 bg-white border-2 border-gray-200 rounded-xl hover:border-[#ec682a] hover:text-[#ec682a] transition-all font-medium"
                                        whileHover={{ scale: 1.05 }}
                                        whileTap={{ scale: 0.95 }}
                                    >
                                        {year}
                                    </motion.button>
                                ))}
                            </div>
                        </div>
                    </motion.div>
                )}
            </div>
        </motion.section>
    );
}
