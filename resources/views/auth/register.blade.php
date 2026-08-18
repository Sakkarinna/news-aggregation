@extends('layouts.layout')

@section('title', 'Register')

@section('content')
<div class="container mx-auto p-6 max-w-md">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4 text-center">{{ __('Register') }}</h1>

        <form method="POST" action="{{ route('register') }}" id="register-form">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                <input id="name" type="text" name="name"
                       class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                       value="{{ old('name') }}" required autofocus autocomplete="name">
                <span id="name-error" class="text-red-500 text-sm mt-1 hidden"></span>
                @if ($errors->has('name'))
                    <span class="text-red-500 text-sm mt-1">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                <input id="email" type="email" name="email"
                       class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                       value="{{ old('email') }}" required autocomplete="username">
                <span id="email-error" class="text-red-500 text-sm mt-1 hidden"></span>
                @if ($errors->has('email'))
                    <span class="text-red-500 text-sm mt-1">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                <input id="password" type="password" name="password"
                       class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                       required autocomplete="new-password">
                <span id="password-error" class="text-red-500 text-sm mt-1 hidden"></span>
                @if ($errors->has('password'))
                    <span class="text-red-500 text-sm mt-1">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                       required autocomplete="new-password">
                <span id="password-confirm-error" class="text-red-500 text-sm mt-1 hidden"></span>
                @if ($errors->has('password_confirmation'))
                    <span class="text-red-500 text-sm mt-1">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>

            <div class="flex justify-between items-center mt-4">
                <a class="text-sm text-blue-600 hover:underline" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('register-form');
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const passwordConfirm = document.getElementById('password_confirmation');

        const nameError = document.getElementById('name-error');
        const emailError = document.getElementById('email-error');
        const passwordError = document.getElementById('password-error');
        const passwordConfirmError = document.getElementById('password-confirm-error');

        const validatePassword = () => {
            const value = password.value;
            const rules = [
                { regex: /.{8,}/, message: 'Password must be at least 8 characters.' },
                { regex: /[0-9]/, message: 'Password must contain at least one number.' },
                { regex: /[!@#$%^&*(),.?":{}|<>]/, message: 'Password must contain at least one special character.' },
            ];

            const errors = rules.filter(rule => !rule.regex.test(value)).map(rule => rule.message);

            if (errors.length) {
                passwordError.textContent = errors.join(' ');
                passwordError.classList.remove('hidden');
                return false;
            }

            passwordError.classList.add('hidden');
            return true;
        };

        const validateEmailAndName = () => {
            if (name.value && email.value && name.value.toLowerCase() === email.value.split('@')[0].toLowerCase()) {
                emailError.textContent = 'Email and Name cannot be the same.';
                emailError.classList.remove('hidden');
                return false;
            }

            emailError.classList.add('hidden');
            return true;
        };

        const validatePasswordConfirmation = () => {
            if (password.value !== passwordConfirm.value) {
                passwordConfirmError.textContent = 'Passwords do not match.';
                passwordConfirmError.classList.remove('hidden');
                return false;
            }

            passwordConfirmError.classList.add('hidden');
            return true;
        };

        form.addEventListener('submit', (event) => {
            const isPasswordValid = validatePassword();
            const isEmailAndNameValid = validateEmailAndName();
            const isPasswordConfirmValid = validatePasswordConfirmation();

            if (!isPasswordValid || !isEmailAndNameValid || !isPasswordConfirmValid) {
                event.preventDefault();
            }
        });

        password.addEventListener('input', validatePassword);
        email.addEventListener('input', validateEmailAndName);
        name.addEventListener('input', validateEmailAndName);
        passwordConfirm.addEventListener('input', validatePasswordConfirmation);
    });
</script>
@endsection
