<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
     <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-white">

    {{-- Konten Utama --}}
    <div class="relative z-10 flex flex-col items-center justify-center px-6 py-10 min-h-screen">
        <img src="{{ asset('img/logo-idcloudhost.png') }}" alt="Logo" class="w-1/2 mb-10">


        <form action="{{ route('signup.store') }}" method="POST" class="w-full max-w-sm space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-bold mb-1">Full Name</label>
                <input type="text" name="name" id="name" required
                    class="w-full border border-blue-700 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <div>
                <label for="email" class="block text-sm font-bold mb-1">Email/Username</label>
                <input type="email" name="email" id="email" required
                    class="w-full border border-blue-700 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <div>
                <label for="password" class="block text-sm font-bold mb-1">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full border border-blue-700 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <button type="submit"
                class="w-full bg-blue-800 hover:bg-blue-900 text-white font-bold py-2 rounded-md transition">
                Sign Up
            </button>
        </form>

        <p class="mt-6 text-sm text-center">
            Already have an account?
            <a href="{{ route('login') }}" class="text-blue-800 font-semibold">Login</a>
        </p>
    </div>

</body>
</html>
