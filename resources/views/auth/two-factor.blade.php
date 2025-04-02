@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('path-to-your-logo.png') }}" alt="Logo" class="h-16">
        </div>

        <form action="{{ route('two-factor.verify') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Two-Factor Code</label>
                <input type="text" name="code" id="code" placeholder="Enter your Two Factor Authentication"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200" required>
            </div>
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                Verify
            </button>
        </form>

        @if ($errors->any())
        <div class="mt-4 p-3 bg-red-100 text-red-700 rounded-lg">
            @foreach ($errors->all() as $error)
            <p class="text-sm">{{ $error }}</p>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
