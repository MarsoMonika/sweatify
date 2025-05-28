<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Sweatify!</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-r from-gray-800 via-gray-900 to-black flex items-center justify-center h-screen">
<div class="text-center p-8 bg-gray-800 shadow-lg rounded-xl max-w-sm w-full">
    <!-- Logo Section -->
    <div class="mb-6">
        <x-application-logo class="block h-160 w-auto mx-auto mb-4 text-blue-500" />
    </div>

    <h1 class="text-4xl font-bold text-white mb-4">Welcome to Sweatify! 💪</h1>
    <p class="text-gray-300 text-lg mb-6">The best workout planner application. Start your fitness journey today!</p>

    <div class="flex justify-center space-x-4">
        <a href="{{ route('login') }}" class="px-6 py-3 bg-blue-700 text-white rounded-full text-lg font-semibold hover:bg-blue-800 transition duration-200 ease-in-out shadow-lg transform hover:scale-105">
            Login
        </a>
        <a href="{{ route('register') }}" class="px-6 py-3 bg-green-700 text-white rounded-full text-lg font-semibold hover:bg-green-800 transition duration-200 ease-in-out shadow-lg transform hover:scale-105">
            Register
        </a>
    </div>
</div>
</body>

</html>
