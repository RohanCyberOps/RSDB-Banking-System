<?php
// online.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Banking Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://unpkg.com/framer-motion@latest/dist/framer-motion.js"></script>
</head>
<body class="bg-gray-50">
<div class="py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Online Banking Login</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Access your accounts securely and manage your finances with ease.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-start">
            <div class="bg-white p-8 rounded-lg shadow-sm">
                <h2 class="text-2xl font-bold mb-6">Login to Your Account</h2>
                <form class="space-y-6" action="./SecureAuthSystem/login.php" method="POST">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            User ID
                        </label>
                        <input
                            type="text"
                            name="user_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                            placeholder="Enter your user ID"
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <input
                            type="password"
                            name="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                            placeholder="Enter your password"
                        />
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-pink-500 focus:ring-pink-500" />
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        <a href="#" class="text-sm text-pink-500 hover:text-pink-600">
                            Forgot password?
                        </a>
                    </div>
                    <button
                        type="submit"
                        class="w-full bg-pink-500 text-white py-3 px-6 rounded-lg hover:bg-pink-600 transition-colors"
                    >
                        Login
                    </button>
                </form>
            </div>

            <div class="space-y-8">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <i data-lucide="lock" class="w-8 h-8 text-pink-500 mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">Secure Banking</h3>
                    <p class="text-gray-600">
                        Our online banking platform uses advanced encryption and security measures to protect your information.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <i data-lucide="shield" class="w-8 h-8 text-pink-500 mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">Protected Access</h3>
                    <p class="text-gray-600">
                        Multi-factor authentication and regular security updates ensure your account stays safe.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <i data-lucide="key" class="w-8 h-8 text-pink-500 mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">First Time User?</h3>
                    <p class="text-gray-600">
                        New to online banking?
                        <a href="./Register.php" class="text-pink-500 hover:text-pink-600 ml-1">
                            Register here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons(); // Initialize Lucide icons
</script>
</body>
</html>