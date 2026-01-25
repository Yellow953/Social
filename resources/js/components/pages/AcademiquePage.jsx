import { useState } from "react";
import { motion, AnimatePresence } from "framer-motion";

export default function AcademiquePage() {
    const [selectedYear, setSelectedYear] = useState("");
    const [selectedMajor, setSelectedMajor] = useState("");

    // Sample courses data (would come from backend in real implementation)
    const sampleCourses = {
        "Year 1": {
            GM: [
                { name: "Maths discrète", sessions: 12, materials: 5 },
                { name: "Analyse générale", sessions: 15, materials: 6 },
                { name: "Mécanique 1", sessions: 10, materials: 4 },
            ],
            GIC: [
                { name: "Maths discrète", sessions: 12, materials: 5 },
                { name: "Analyse générale", sessions: 15, materials: 6 },
                { name: "Informatique 1", sessions: 18, materials: 7 },
            ],
        },
        "Year 2": {
            GM: [
                { name: "Maths avancées", sessions: 14, materials: 6 },
                { name: "Physique 2", sessions: 16, materials: 7 },
                { name: "Mécanique 2", sessions: 12, materials: 5 },
            ],
            GIC: [
                { name: "Algorithmes", sessions: 20, materials: 8 },
                { name: "Structures de données", sessions: 18, materials: 7 },
                { name: "Réseaux", sessions: 15, materials: 6 },
            ],
        },
    };

    const materials = [
        { name: "Pariel", icon: "fas fa-file-alt", count: 25 },
        { name: "Final", icon: "fas fa-file-pdf", count: 18 },
        { name: "TC", icon: "fas fa-clipboard", count: 12 },
        { name: "Cours et résumer", icon: "fas fa-book", count: 30 },
        { name: "TP", icon: "fas fa-flask", count: 15 },
    ];

    const getCoursesForSelection = () => {
        if (selectedYear && selectedMajor) {
            return sampleCourses[selectedYear]?.[selectedMajor] || [];
        }
        return [];
    };

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
        hidden: { opacity: 0, x: -20 },
        visible: {
            opacity: 1,
            x: 0,
            transition: {
                duration: 0.5,
            },
        },
    };

    return (
        <motion.section
            className="min-h-screen px-4 py-12 sm:py-16 md:py-20 pt-24 sm:pt-28 md:pt-32 bg-gradient-to-br from-blue-50 via-white to-orange-50"
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
                                    <option value="Year 1">Year 1</option>
                                    <option value="Year 2">Year 2</option>
                                    <option value="Year 3">Year 3</option>
                                    <option value="Year 4">Year 4</option>
                                    <option value="Year 5">Year 5</option>
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
                                    <option value="GM">GM</option>
                                    <option value="GIC">GIC</option>
                                    <option value="Other">Other</option>
                                </select>
                            </motion.div>
                        </div>
                    </div>
                </motion.div>

                {/* Course Materials Display */}
                <AnimatePresence mode="wait">
                    {selectedYear && selectedMajor && (
                        <motion.div
                            className="space-y-6 sm:space-y-8"
                            initial={{ opacity: 0, scale: 0.95 }}
                            animate={{ opacity: 1, scale: 1 }}
                            exit={{ opacity: 0, scale: 0.95 }}
                            transition={{ duration: 0.3 }}
                        >
                            {/* Header Card */}
                            <motion.div
                                className="bg-gradient-to-r from-[#1e3a8a] to-[#3b82f6] rounded-2xl p-6 sm:p-8 text-white shadow-2xl"
                                initial={{ opacity: 0, y: -20 }}
                                animate={{ opacity: 1, y: 0 }}
                                transition={{ duration: 0.5 }}
                            >
                                <h3 className="text-3xl sm:text-4xl font-bold mb-2">
                                    SUP_{selectedMajor}
                                </h3>
                                <p className="text-white/90 text-base sm:text-lg">
                                    {selectedYear} •{" "}
                                    {getCoursesForSelection().length} Courses
                                    Available
                                </p>
                            </motion.div>

                            {/* Courses Grid */}
                            <motion.div
                                className="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8"
                                variants={containerVariants}
                                initial="hidden"
                                animate="visible"
                            >
                                {getCoursesForSelection().map(
                                    (course, index) => (
                                        <motion.div
                                            key={index}
                                            className="bg-white rounded-2xl p-6 sm:p-8 shadow-lg border-2 border-gray-100 hover:border-[#ec682a] transition-all"
                                            variants={itemVariants}
                                            whileHover={{
                                                scale: 1.03,
                                                y: -5,
                                                boxShadow:
                                                    "0 20px 40px rgba(0,0,0,0.1)",
                                            }}
                                        >
                                            <div className="flex items-start justify-between mb-4">
                                                <div className="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                                    <i className="fas fa-book text-white"></i>
                                                </div>
                                                <span className="text-xs font-semibold text-[#ec682a] bg-orange-50 px-3 py-1 rounded-full">
                                                    {course.sessions} Sessions
                                                </span>
                                            </div>
                                            <h4 className="text-xl sm:text-2xl font-bold text-[#5c5c5c] mb-3">
                                                {course.name}
                                            </h4>
                                            <div className="flex items-center text-gray-600 text-sm">
                                                <i className="fas fa-file-alt text-[#ec682a] mr-2"></i>
                                                <span>
                                                    {course.materials} Materials
                                                </span>
                                            </div>
                                        </motion.div>
                                    ),
                                )}
                            </motion.div>

                            {/* Materials Section */}
                            <motion.div
                                className="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-xl p-6 sm:p-8 border-2 border-orange-200"
                                initial={{ opacity: 0, y: 20 }}
                                animate={{ opacity: 1, y: 0 }}
                                transition={{ duration: 0.5, delay: 0.3 }}
                            >
                                <h4 className="font-bold text-xl sm:text-2xl text-[#5c5c5c] mb-6 flex items-center">
                                    <i className="fas fa-folder-open me-3 text-[#ec682a] text-2xl"></i>
                                    Available Materials
                                </h4>
                                <div className="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
                                    {materials.map((material, index) => (
                                        <motion.div
                                            key={index}
                                            className="bg-white rounded-xl p-4 sm:p-6 text-center hover:shadow-lg transition-all border-2 border-gray-100 hover:border-[#ec682a]"
                                            whileHover={{ scale: 1.05, y: -3 }}
                                        >
                                            <div className="w-12 h-12 bg-gradient-to-br from-[#ec682a] to-[#d45a20] rounded-lg flex items-center justify-center mx-auto mb-3">
                                                <i
                                                    className={`${material.icon} text-white`}
                                                ></i>
                                            </div>
                                            <h5 className="font-bold text-[#5c5c5c] mb-1 text-sm sm:text-base">
                                                {material.name}
                                            </h5>
                                            <p className="text-xs text-gray-500">
                                                {material.count} files
                                            </p>
                                        </motion.div>
                                    ))}
                                </div>
                            </motion.div>
                        </motion.div>
                    )}

                    {/* Default View when no selection */}
                    {(!selectedYear || !selectedMajor) && (
                        <motion.div
                            className="bg-gradient-to-br from-white to-orange-50 rounded-3xl shadow-2xl p-12 sm:p-16 border-2 border-orange-200 relative overflow-hidden"
                            initial={{ opacity: 0, scale: 0.95 }}
                            animate={{ opacity: 1, scale: 1 }}
                            exit={{ opacity: 0, scale: 0.95 }}
                            transition={{ duration: 0.3 }}
                        >
                            <div className="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-orange-400/10 to-transparent rounded-bl-full"></div>
                            <div className="relative z-10 text-center py-8 sm:py-12">
                                <motion.div
                                    className="w-24 h-24 sm:w-32 sm:h-32 bg-gradient-to-br from-[#ec682a] to-[#d45a20] rounded-2xl flex items-center justify-center mx-auto mb-6 sm:mb-8 shadow-2xl"
                                    animate={{
                                        rotate: [0, 5, -5, 0],
                                        scale: [1, 1.05, 1],
                                    }}
                                    transition={{
                                        duration: 3,
                                        repeat: Infinity,
                                        repeatDelay: 2,
                                    }}
                                >
                                    <i className="fas fa-graduation-cap text-white text-4xl sm:text-5xl"></i>
                                </motion.div>
                                <h3 className="text-2xl sm:text-3xl md:text-4xl font-bold text-[#5c5c5c] mb-4 sm:mb-6">
                                    Select Your Year and Major
                                </h3>
                                <p className="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto px-4 mb-6">
                                    Choose your study year and major above to
                                    view available courses and materials
                                    tailored to your academic path.
                                </p>
                                <div className="flex flex-wrap justify-center gap-4">
                                    {[
                                        "Year 1",
                                        "Year 2",
                                        "Year 3",
                                        "Year 4",
                                        "Year 5",
                                    ].map((year, index) => (
                                        <motion.button
                                            key={index}
                                            onClick={() =>
                                                setSelectedYear(year)
                                            }
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
                </AnimatePresence>
            </div>
        </motion.section>
    );
}
