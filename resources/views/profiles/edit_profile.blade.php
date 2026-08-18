@php
    $layout = auth()->check() && auth()->user()->role === 'admin'
        ? 'layouts.admin_dashboard_layout'
        : 'layouts.layout';
@endphp

@extends($layout)

@section('title', 'Edit Profile')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6 text-center">Edit Profile</h1>
    <form action="{{ route('profile.update') }}" method="POST" class="max-w-lg mx-auto">
        @csrf
        @method('PATCH')

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-lg font-semibold text-gray-700">Name</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ auth()->user()->name }}"
                class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-lg font-semibold text-gray-700">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ auth()->user()->email }}"
                class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >
        </div>

        <!-- Current Password -->
        <div class="mb-4">
            <label for="current_password" class="block text-lg font-semibold text-gray-700">Current Password</label>
            <input
                type="password"
                id="current_password"
                name="current_password"
                class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >
            <span id="current-password-error" class="text-red-500 text-sm hidden"></span>
        </div>

        <!-- New Password -->
        <div class="mb-4">
            <label for="new_password" class="block text-lg font-semibold text-gray-700">New Password</label>
            <input
                type="password"
                id="new_password"
                name="new_password"
                class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >
            <span id="new-password-error" class="text-red-500 text-sm hidden"></span>
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="confirm_password" class="block text-lg font-semibold text-gray-700">Confirm Password</label>
            <input
                type="password"
                id="confirm_password"
                name="confirm_password"
                class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >
            <span id="confirm-password-error" class="text-red-500 text-sm hidden"></span>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button
                type="submit"
                class="px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-700 text-white rounded-full font-semibold hover:from-blue-600 hover:to-blue-800 transition duration-200 shadow-md hover:shadow-lg"
            >
                Save Changes
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('form');
        const currentPassword = document.getElementById('current_password');
        const newPassword = document.getElementById('new_password');
        const confirmPassword = document.getElementById('confirm_password');

        const currentPasswordError = document.getElementById('current-password-error');
        const newPasswordError = document.getElementById('new-password-error');
        const confirmPasswordError = document.getElementById('confirm-password-error');

        const validateNewPassword = () => {
            const value = newPassword.value;
            const rules = [
                { regex: /.{8,}/, message: 'Password must be at least 8 characters.' },
                { regex: /[0-9]/, message: 'Password must contain at least one number.' },
                { regex: /[!@#$%^&*(),.?":{}|<>]/, message: 'Password must contain at least one special character.' },
            ];

            const errors = rules.filter(rule => !rule.regex.test(value)).map(rule => rule.message);

            if (errors.length) {
                newPasswordError.textContent = errors.join(' ');
                newPasswordError.classList.remove('hidden');
                return false;
            }

            newPasswordError.classList.add('hidden');
            return true;
        };

        const validateConfirmPassword = () => {
            if (newPassword.value !== confirmPassword.value) {
                confirmPasswordError.textContent = 'Passwords do not match.';
                confirmPasswordError.classList.remove('hidden');
                return false;
            }

            confirmPasswordError.classList.add('hidden');
            return true;
        };

        form.addEventListener('submit', (event) => {
            const isNewPasswordValid = validateNewPassword();
            const isConfirmPasswordValid = validateConfirmPassword();

            if (!isNewPasswordValid || !isConfirmPasswordValid) {
                event.preventDefault();
            }
        });

        newPassword.addEventListener('input', validateNewPassword);
        confirmPassword.addEventListener('input', validateConfirmPassword);
    });
</script>
@endsection
