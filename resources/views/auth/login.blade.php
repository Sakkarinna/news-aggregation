@extends('layouts.layout')

@section('title', 'Log in')

@section('content')
<div class="container mx-auto p-6 max-w-md">
    <!-- Session Status -->
    @if (session('status'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4 text-center">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4 text-center">{{ __('Log in') }}</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required autofocus autocomplete="username">
                @if ($errors->has('email'))
                    <span class="text-red-500 text-sm mt-1">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                <input id="password" type="password" name="password"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required autocomplete="current-password">
                @if ($errors->has('password'))
                    <span class="text-red-500 text-sm mt-1">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <!-- Remember Me -->
            <div class="mb-4 flex items-center">
                <input id="remember_me" type="checkbox"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" name="remember">
                <label for="remember_me" class="ml-2 block text-sm text-gray-900">{{ __('Remember me') }}</label>
            </div>

            <!-- Actions -->
            <div class="flex justify-between items-center">
                @if (Route::has('password.request'))
                    <a id="forgot-password-link" class="text-sm text-blue-600 hover:underline cursor-pointer">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Forgot Password Modal -->
<div id="forgot-password-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center">
    <div class="bg-white w-96 p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">{{ __('Contact Admin') }}</h2>
        <p class="mb-4 text-gray-700">
            {{ __('If you have forgotten your password, please contact our admin team to assist you with resetting your password.') }}
        </p>
        <p class="mb-4">
            <strong>{{ __('Admin Email:') }}</strong>
            <a href="mailto:202100282@my.apiu.edu" class="text-blue-600 hover:underline">202100282@my.apiu.edu</a>
        </p>
        <button id="close-modal" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            {{ __('Close') }}
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('forgot-password-modal');
        const link = document.getElementById('forgot-password-link');
        const closeModal = document.getElementById('close-modal');

        link.addEventListener('click', function () {
            modal.classList.remove('hidden');
        });

        closeModal.addEventListener('click', function () {
            modal.classList.add('hidden');
        });

        // Close modal when clicking outside of it
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
</script>
@endsection
