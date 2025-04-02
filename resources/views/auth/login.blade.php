@extends('layouts.app')

@section('content')
<main class="flex justify-center items-center min-h-screen bg-gray-100">
    <section class="w-full max-w-sm p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-center text-xl font-semibold text-gray-700 mb-4">Login</h2>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email Input -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                <input type="email" name="email" id="email"
                    class="w-full p-2 text-lg border rounded-md focus:ring focus:ring-blue-300 @error('email') border-red-500 @enderror"
                    value="{{ old('email') }}" required autofocus>
                @error('email')
                    <p class="text-red-500 text-base mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Input -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                <input type="password" name="password" id="password"
                    class="w-full p-2 text-lg border rounded-md focus:ring focus:ring-blue-300 @error('password') border-red-500 @enderror"
                    required>
                @error('password')
                    <p class="text-red-500 text-base mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-md text-lg font-medium">
                Log In
            </button>
        </form>

        <!-- Register Link -->
        <div class="text-center mt-4 text-sm text-gray-600">
            No account yet?
            <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Create Account</a>
        </div>
    </section>
</main>
@endsection
