<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SportVenue</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-500 to-purple-600 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <!-- Logo/Header -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="w-24 h-24 rounded-full overflow-hidden bg-white shadow-md">
                        <img
                            src="{{ asset('images/logo/logo-talapas.png') }}"
                            alt="Talapas SportVenue"
                            class="w-full h-full object-cover" >
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">Talapas SportVenue</h2>
                <p class="text-gray-600 mt-2">Reset Password</p>
            </div>

            <!-- Success Message -->
            @if (session('status'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
                    <div class="flex">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                        </svg>
                        <p class="text-green-700 text-sm">{{ session('status') }}</p>
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                        </svg>
                        <p class="text-red-700 text-sm">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <!-- Forgot Password Form -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="masukkan email Anda" value="{{ old('email') }}">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 shadow-lg hover:shadow-xl">
                    Kirim Link Reset Password
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Kembali ke
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold">Login</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>