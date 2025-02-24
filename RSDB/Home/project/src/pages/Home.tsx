import { motion } from 'framer-motion';

export default function Home() {
  return (
    <div className="max-w-7xl mx-auto px-6 py-12 md:py-24">
      <div className="grid md:grid-cols-2 gap-12 items-center">
        <motion.div
          initial={{ opacity: 0, x: -50 }}
          animate={{ opacity: 1, x: 0 }}
          transition={{ duration: 0.8, delay: 0.2 }}
        >
          <motion.h1 
            className="text-3xl md:text-4xl lg:text-5xl font-bold leading-tight"
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6, delay: 0.4 }}
          >
            Get the access of your account
            <br />
            now in the comfort of your home
          </motion.h1>
          <motion.p 
            className="mt-6 text-gray-600 leading-relaxed"
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6, delay: 0.6 }}
          >
            No more waiting in the long queues, transfer the money very conveniently with the help of our RSDB Bank System, a digital wallet platform and online payment system developed to power in-app, online, and in-person contactless transactions with mobile phones.
          </motion.p>
          <motion.button 
            className="mt-8 px-8 py-3 border-2 border-pink-400 text-pink-500 rounded-lg hover:bg-pink-50 transition-colors relative overflow-hidden group"
            whileHover={{ scale: 1.05 }}
            whileTap={{ scale: 0.95 }}
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6, delay: 0.8 }}
          >
            <span className="relative z-10">Register Yourself</span>
            <motion.div 
              className="absolute inset-0 bg-pink-100 transform origin-left"
              initial={{ scaleX: 0 }}
              whileHover={{ scaleX: 1 }}
              transition={{ duration: 0.3 }}
            />
          </motion.button>
        </motion.div>
        <motion.div 
          className="relative"
          initial={{ opacity: 0, x: 50 }}
          animate={{ opacity: 1, x: 0 }}
          transition={{ duration: 0.8, delay: 0.4 }}
        >
          <motion.div 
            className="w-full h-full"
            animate={{ 
              y: [0, -10, 0],
            }}
            transition={{ 
              duration: 4,
              repeat: Infinity,
              ease: "easeInOut"
            }}
          >
            <img
              src="https://static.vecteezy.com/system/resources/previews/003/715/680/non_2x/online-e-banking-app-wallet-or-bank-credit-card-illustration-with-technology-data-protection-and-payment-security-for-digital-payments-through-smartphones-vector.jpg"
              alt="Banking illustration"
              className="w-full h-full object-contain"
            />
          </motion.div>
        </motion.div>
      </div>
    </div>
  );
}