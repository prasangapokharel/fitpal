<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow:wght@400;600;700&display=swap');
        body {
            font-family: 'Barlow', sans-serif;
        }
    </style>
</head>
<body class="bg-blue-50 text-blue-900">

    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-800 to-blue-600 text-white text-center py-12 rounded-b-3xl">
        <h1 class="text-4xl font-bold">Contact Us</h1>
        <p class="text-lg mt-2">We’re here to help and answer any questions you might have.</p>
    </header>

    <!-- Contact Form -->
    <section class="max-w-3xl mx-auto bg-white mt-12 p-8 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold text-center text-blue-800 mb-6">Get in Touch</h2>
        <form class="space-y-6">
            <div>
                <label for="name" class="block text-lg font-semibold text-blue-800">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required
                    class="w-full mt-2 px-4 py-3 border-2 border-blue-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="email" class="block text-lg font-semibold text-blue-800">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" required
                    class="w-full mt-2 px-4 py-3 border-2 border-blue-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="message" class="block text-lg font-semibold text-blue-800">Your Message</label>
                <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required
                    class="w-full mt-2 px-4 py-3 border-2 border-blue-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <button type="submit"
                class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg rounded-lg transition duration-300">
                Send Message
            </button>
        </form>
    </section>

    <!-- Contact Info -->
    <section class="text-center mt-12">
        <h3 class="text-xl font-bold text-blue-800">Our Contact Information</h3>
        <p class="text-lg mt-2">Email: <a href="mailto:support@phonesium.com" class="text-blue-600 hover:underline">support@phonesium.com</a></p>
        <p class="text-lg">Phone: +1 234 567 890</p>
        <p class="text-lg">Address: 123 Blue Street, Blue City, BC 10101</p>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-800 text-white text-center py-4 mt-12">
        <p class="text-sm">&copy; 2024 Phonesium. All Rights Reserved.</p>
    </footer>

</body>
</html>
