import { motion } from 'framer-motion';
import { Shield, Users, Trophy } from 'lucide-react';

export default function About() {
  const stats = [
    { label: "Years of Experience", value: "25+" },
    { label: "Satisfied Customers", value: "1M+" },
    { label: "Countries Served", value: "50+" },
    { label: "Digital Transactions", value: "₹100B+" },
  ];

  const values = [
    {
      icon: Shield,
      title: "Trust & Security",
      description: "Your security is our top priority. We employ state-of-the-art encryption and security measures."
    },
    {
      icon: Users,
      title: "Customer First",
      description: "We believe in putting our customers first and providing exceptional service at every touchpoint."
    },
    {
      icon: Trophy,
      title: "Excellence",
      description: "We strive for excellence in everything we do, from our products to our customer service."
    }
  ];

  return (
    <div className="py-16 px-4 sm:px-6 lg:px-8">
      <div className="max-w-7xl mx-auto">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
          className="text-center"
        >
          <h1 className="text-4xl font-bold text-gray-900 mb-4">About RSDB Bank</h1>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            We're more than just a bank. We're your partner in financial success, committed to providing innovative solutions and exceptional service.
          </p>
        </motion.div>

        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, delay: 0.2 }}
          className="mt-16 grid grid-cols-2 gap-4 sm:grid-cols-4"
        >
          {stats.map((stat, index) => (
            <motion.div
              key={stat.label}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6, delay: 0.1 * index }}
              className="bg-white p-6 rounded-lg shadow-sm text-center"
            >
              <div className="text-3xl font-bold text-pink-500">{stat.value}</div>
              <div className="text-sm text-gray-600 mt-1">{stat.label}</div>
            </motion.div>
          ))}
        </motion.div>

        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, delay: 0.4 }}
          className="mt-20"
        >
          <h2 className="text-3xl font-bold text-center mb-12">Our Values</h2>
          <div className="grid md:grid-cols-3 gap-8">
            {values.map((value, index) => (
              <motion.div
                key={value.title}
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: 0.2 * index }}
                className="bg-white p-6 rounded-lg shadow-sm text-center"
              >
                <value.icon className="w-12 h-12 text-pink-500 mx-auto mb-4" />
                <h3 className="text-xl font-semibold mb-2">{value.title}</h3>
                <p className="text-gray-600">{value.description}</p>
              </motion.div>
            ))}
          </div>
        </motion.div>
      </div>
    </div>
  );
}