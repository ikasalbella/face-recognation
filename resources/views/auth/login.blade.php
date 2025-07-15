<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-white">

  <div class="w-full max-w-xs text-center">
    <div class="flex justify-center items-center mb-10">
      <img src="{{ asset('img/logo-idcloudhost.png') }}" alt="Logo" class="h-70 md:h-75" />
    </div>

    <form action="{{ route('login.store') }}" method="POST" class="space-y-4">
      @csrf
      <input type="text" name="email" placeholder="Email/Username" required
        class="w-full border-2 border-blue-700 px-4 py-3 rounded-md focus:outline-none" />

      <input type="password" name="password" placeholder="Password" required
        class="w-full border-2 border-blue-700 px-4 py-3 rounded-md focus:outline-none" />

      <button type="submit"
        class="w-full bg-blue-700 text-white font-bold py-3 rounded-md hover:bg-blue-800 transition">
        Login
      </button>

      @if($errors->has('akses'))
        <p class="text-red-500 text-sm mt-2">{{ $errors->first('akses') }}</p>
      @endif
    </form>

    <p class="text-sm text-gray-700 mt-4">
      Don't Have an Account?
      <a href="{{ route('signup') }}" class="font-bold text-blue-700 hover:underline">Sign Up</a>
    </p>
  </div>

</body>
</html>
