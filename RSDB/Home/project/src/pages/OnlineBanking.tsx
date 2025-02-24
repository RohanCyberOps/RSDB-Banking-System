import { motion } from 'framer-motion';
import { Lock, Shield, Key } from 'lucide-react';

export default function OnlineBanking() {
  return (
    <div className="py-16 px-4 sm:px-6 lg:px-8">
      <div className="max-w-7xl mx-auto">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
          className="text-center mb-16"
        >
          <h1 className="text-4xl font-bold text-gray-900 mb-4">Online Banking Login</h1>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Access your accounts securely and manage your finances with ease.
          </p>
        </motion.div>

        <div className="grid md:grid-cols-2 gap-12 items-start">
          <motion.div
            initial={{ opacity: 0, x: -20 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.6, delay: 0.2 }}
            className="bg-white p-8 rounded-lg shadow-sm"
          >
            <h2 className="text-2xl font-bold mb-6">Login to Your Account</h2>
            <form className="space-y-6">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  User ID
                </label>
                <input
                  type="text"
                  className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                  placeholder="Enter your user ID"
                />
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Password
                </label>
                <input
                  type="password"
                  className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                  placeholder="Enter your password"
                />
              </div>
              <div className="flex items-center justify-between">
                <label className="flex items-center">
                  <input type="checkbox" className="rounded border-gray-300 text-pink-500 focus:ring-pink-500" />
                  <span className="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
                <a href="#" className="text-sm text-pink-500 hover:text-pink-600">
                  Forgot password?
                </a>
              </div>
              <motion.button
                whileHover={{ scale: 1.02 }}
                whileTap={{ scale: 0.98 }}
                className="w-full bg-pink-500 text-white py-3 px-6 rounded-lg hover:bg-pink-600 transition-colors"
              >
                Login
              </motion.button>
            </form>
          </motion.div>

          <motion.div
            initial={{ opacity: 0, x: 20 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.6, delay: 0.4 }}
            className="space-y-8"
          >
            <div className="bg-white p-6 rounded-lg shadow-sm">
              <Lock className="w-8 h-8 text-pink-500 mb-4" />
              <h3 className="text-lg font-semibold mb-2">Secure Banking</h3>
              <p className="text-gray-600">
                Our online banking platform uses advanced encryption and security measures to protect your information.
              </p>
            </div>
            <div className="bg-white p-6 rounded-lg shadow-sm">
              <Shield className="w-8 h-8 text-pink-500 mb-4" />
              <h3 className="text-lg font-semibold mb-2">Protected Access</h3>
              <p className="text-gray-600">
                Multi-factor authentication and regular security updates ensure your account stays safe.
              </p>
            </div>
            <div className="bg-white p-6 rounded-lg shadow-sm">
              <Key className="w-8 h-8 text-pink-500 mb-4" />
              <h3 className="text-lg font-semibold mb-2">First Time User?</h3>
              <p className="text-gray-600">
                New to online banking? 
                <a href="#" className="text-pink-500 hover:text-pink-600 ml-1">
                  Register here
                </a>
              </p>
            </div>
          </motion.div>
        </div>
      </div>
    </div>
  );
}