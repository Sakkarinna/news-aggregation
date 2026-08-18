@extends('layouts.admin_dashboard_layout')

@section('title', 'Register User')

@section('content')
<div class="container mx-auto mt-8 p-6 bg-white shadow-lg rounded-lg">
    <h1 class="text-3xl font-bold mb-6 text-center">Register User</h1>
    <form id="register-user-form" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-lg font-semibold text-gray-700 mb-1">Name</label>
            <input
                type="text"
                id="name"
                name="name"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required
            >
            <span id="name-error" class="text-red-500 text-sm hidden"></span>
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-lg font-semibold text-gray-700 mb-1">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required
            >
            <span id="email-error" class="text-red-500 text-sm hidden"></span>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-lg font-semibold text-gray-700 mb-1">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required
            >
            <span id="password-error" class="text-red-500 text-sm hidden"></span>
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-lg font-semibold text-gray-700 mb-1">Confirm Password</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required
            >
            <span id="password-confirm-error" class="text-red-500 text-sm hidden"></span>
        </div>

        <!-- Role -->
        <div>
            <label for="role" class="block text-lg font-semibold text-gray-700 mb-1">Role</label>
            <select
                id="role"
                name="role"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required
            >
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button
                type="submit"
                class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200"
            >
                Register
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('register-user-form');
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
                { regex: /.{8,}/, message: 'Password must be at least 8 characters long.' },
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
