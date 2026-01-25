import { motion } from "framer-motion";

export default function CalculatricePage() {
    return (
        <motion.section
            className="min-h-screen px-4 py-12 sm:py-16 md:py-20 pt-24 sm:pt-28 md:pt-32 bg-gradient-to-br from-blue-50 via-white to-orange-50"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration: 0.6 }}
        >
            <div className="container mx-auto max-w-4xl">
                {/* Header */}
                <motion.div
                    className="text-center mb-10 sm:mb-12"
                    initial={{ opacity: 0, y: -20 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.6, delay: 0.2 }}
                >
                    <div className="inline-block mb-6">
                        <motion.div
                            className="w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-[#ec682a] to-[#d45a20] rounded-2xl flex items-center justify-center shadow-2xl mx-auto"
                            animate={{
                                boxShadow: [
                                    "0 0 0 0px rgba(236, 104, 42, 0.4)",
                                    "0 0 0 15px rgba(236, 104, 42, 0)",
                                    "0 0 0 0px rgba(236, 104, 42, 0)",
                                ],
                            }}
                            transition={{ duration: 2, repeat: Infinity }}
                        >
                            <i className="fas fa-calculator text-white text-3xl sm:text-4xl"></i>
                        </motion.div>
                    </div>
                    <h2 className="text-4xl sm:text-5xl md:text-6xl font-bold text-[#5c5c5c] mb-4">
                        Calculatrice
                    </h2>
                    <div className="w-32 h-1.5 bg-gradient-to-r from-[#ec682a] to-[#d45a20] mx-auto mb-6"></div>
                    <p className="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto">
                        Calculate your grades and academic performance directly on
                        the platform
                    </p>
                </motion.div>

                {/* Main Card */}
                <motion.div
                    className="bg-white rounded-2xl shadow-xl p-8 sm:p-10 border-2 border-gray-100"
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.6, delay: 0.3 }}
                >
                    <div className="text-center mb-8">
                        <h3 className="text-2xl sm:text-3xl font-bold text-[#5c5c5c] mb-4">
                            Grade Calculator
                        </h3>
                        <p className="text-gray-600 text-base sm:text-lg mb-8">
                            Use our built-in calculator to calculate your grades,
                            averages, and academic performance all in one place.
                        </p>
                    </div>

                    {/* Features */}
                    <div className="grid sm:grid-cols-3 gap-6 mb-8">
                        {[
                            {
                                icon: "fas fa-percentage",
                                title: "Calculate Averages",
                                desc: "Compute course averages",
                            },
                            {
                                icon: "fas fa-chart-line",
                                title: "Track Progress",
                                desc: "Monitor academic progress",
                            },
                            {
                                icon: "fas fa-save",
                                title: "Save Results",
                                desc: "Save your calculations",
                            },
                        ].map((feature, index) => (
                            <motion.div
                                key={index}
                                className="text-center p-4 bg-gray-50 rounded-xl"
                                initial={{ opacity: 0, y: 20 }}
                                animate={{ opacity: 1, y: 0 }}
                                transition={{ duration: 0.5, delay: 0.4 + index * 0.1 }}
                                whileHover={{ scale: 1.05 }}
                            >
                                <div className="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mx-auto mb-3">
                                    <i
                                        className={`${feature.icon} text-white`}
                                    ></i>
                                </div>
                                <h4 className="font-bold text-[#5c5c5c] mb-2 text-sm">
                                    {feature.title}
                                </h4>
                                <p className="text-xs text-gray-600">
                                    {feature.desc}
                                </p>
                            </motion.div>
                        ))}
                    </div>

                    {/* CTA Button */}
                    <div className="text-center">
                        <motion.a
                            href="/calculator"
                            className="inline-flex items-center space-x-2 px-8 py-4 bg-gradient-to-r from-[#1e3a8a] to-[#3b82f6] text-white font-bold rounded-xl hover:shadow-xl transition-all no-underline"
                            whileHover={{ scale: 1.05 }}
                            whileTap={{ scale: 0.95 }}
                        >
                            <i className="fas fa-calculator"></i>
                            <span>Launch Calculator</span>
                        </motion.a>
                    </div>
                </motion.div>
            </div>
        </motion.section>
    );
}
