<?php
// contact.php

// Display success or error messages
if (isset($_GET['success'])) {
    echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">' . htmlspecialchars($_GET['success']) . '</div>';
}
if (isset($_GET['error'])) {
    echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">' . htmlspecialchars($_GET['error']) . '</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-100">
<div class="py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Contact Us</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Have questions or need assistance? Reach out to us and we'll be happy to help.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-start">
            <div class="bg-white p-8 rounded-lg shadow-sm">
                <h2 class="text-2xl font-bold mb-6">Send Us a Message</h2>
                <form class="space-y-6" action="contact_form_handler.php" method="POST">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Name
                        </label>
                        <input
                                type="text"
                                name="name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                placeholder="Enter your name"
                                required
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input
                                type="email"
                                name="email"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                placeholder="Enter your email"
                                required
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Message
                        </label>
                        <textarea
                                name="message"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                placeholder="Enter your message"
                                rows="4"
                                required
                        ></textarea>
                    </div>
                    <button
                            type="submit"
                            class="w-full bg-pink-500 text-white py-3 px-6 rounded-lg hover:bg-pink-600 transition-colors"
                    >
                        Send Message
                    </button>
                </form>
            </div>

            <div class="space-y-8">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <i data-lucide="mail" class="w-8 h-8 text-pink-500 mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">Email Us</h3>
                    <p class="text-gray-600">
                        Send us an email at <a href="mailto:rohannagar666@outlook.com" class="text-pink-500 hover:text-pink-600">support@example.com</a>.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <i data-lucide="phone" class="w-8 h-8 text-pink-500 mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">Call Us</h3>
                    <p class="text-gray-600">
                        Give us a call at <a href="tel:+1234567890" class="text-pink-500 hover:text-pink-600">+1 (234) 567-890</a>.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <i data-lucide="map-pin" class="w-8 h-8 text-pink-500 mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">Visit Us</h3>
                    <p class="text-gray-600">
                        123 Main St, City, State, ZIP
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