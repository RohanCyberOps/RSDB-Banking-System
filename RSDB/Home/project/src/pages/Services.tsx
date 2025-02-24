import { motion } from 'framer-motion';
import { CreditCard, Wallet, PiggyBank, Building2, ArrowRightCircle, Smartphone } from 'lucide-react';

export default function Services() {
  const services = [
    {
      icon: CreditCard,
      title: "Credit Cards",
      description: "Premium credit cards with exclusive rewards and benefits tailored to your lifestyle."
    },
    {
      icon: Wallet,
      title: "Personal Banking",
      description: "Comprehensive personal banking solutions for your daily financial needs."
    },
    {
      icon: PiggyBank,
      title: "Savings Accounts",
      description: "High-yield savings accounts to help you reach your financial goals faster."
    },
    {
      icon: Building2,
      title: "Mortgage Loans",
      description: "Competitive mortgage rates and flexible terms for your dream home."
    },
    {
      icon: Smartphone,
      title: "Mobile Banking",
      description: "Secure and convenient banking from your mobile device, anywhere, anytime."
    },
    {
      icon: ArrowRightCircle,
      title: "Investment Services",
      description: "Expert guidance and diverse investment options for wealth creation."
    }
  ];

  return (
    <div className="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50">
      <div className="max-w-7xl mx-auto">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
          className="text-center"
        >
          <h1 className="text-4xl font-bold text-gray-900 mb-4">Our Services</h1>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Discover our comprehensive range of banking services designed to meet all your financial needs.
          </p>
        </motion.div>

        <motion.div
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ duration: 0.6, delay: 0.2 }}
          className="mt-16 grid gap-8 md:grid-cols-2 lg:grid-cols-3"
        >
          {services.map((service, index) => (
            <motion.div
              key={service.title}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6, delay: index * 0.1 }}
              className="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow"
            >
              <service.icon className="w-12 h-12 text-pink-500 mb-4" />
              <h3 className="text-xl font-semibold mb-2">{service.title}</h3>
              <p className="text-gray-600">{service.description}</p>
              <motion.button
                whileHover={{ scale: 1.05 }}
                whileTap={{ scale: 0.95 }}
                className="mt-4 text-pink-500 font-medium flex items-center"
              >
                Learn More
                <ArrowRightCircle className="w-4 h-4 ml-2" />
              </motion.button>
            </motion.div>
          ))}
        </motion.div>
      </div>
    </div>
  );
}