<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-md px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-6">Change Your Password</h2>

            <form method="POST" action="{{ route('first.password.update') }}">
                @csrf

                <!-- Password -->
                {{-- <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        New Password
                    </label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                            class="mt-1 block w-full pr-10 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring focus:ring-blue-200">
                        <button type="button" onclick="togglePassword('password')" 
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 dark:text-gray-300">
                            <svg id="eye-icon-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div> --}}

                <div class="mb-4">
    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        New Password
    </label>
    <div class="flex items-center space-x-2 mt-1">
        <input id="password" type="password" name="password" required
            class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring focus:ring-blue-200">
        <button type="button" onclick="togglePassword('password')" 
            class="text-gray-500 dark:text-gray-300">
            <svg id="eye-icon-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </button>
    </div>
    @error('password')
        <span class="text-sm text-red-600">{{ $message }}</span>
    @enderror
</div>



                <!-- Confirm Password -->
                {{-- <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Confirm Password
                    </label>
                    <div class="relative">
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="mt-1 block w-full pr-10 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring focus:ring-blue-200">
                        <button type="button" onclick="togglePassword('password_confirmation')" 
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 dark:text-gray-300">
                            <svg id="eye-icon-password_confirmation" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div> --}}

                <div class="mb-4">
    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        Confirm Password
    </label>
    <div class="flex items-center space-x-2 mt-1">
        <input id="password_confirmation" type="password" name="password_confirmation" required
            class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring focus:ring-blue-200">
        <button type="button" onclick="togglePassword('password_confirmation')" 
            class="text-gray-500 dark:text-gray-300">
            <svg id="eye-icon-password_confirmation" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </button>
    </div>
    @error('password_confirmation')
        <span class="text-sm text-red-600">{{ $message }}</span>
    @enderror
</div>



                <div class="flex items-center justify-center">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-4 rounded-md transition duration-200">
                        Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toggle Password Visibility -->
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = document.getElementById('eye-icon-' + id);

            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            icon.innerHTML = isPassword
                ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 012.316-3.568M9.88 9.88a3 3 0 104.24 4.24m-4.24-4.24L3 3m18 18l-6-6"/>`
                : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
        }
    </script>
</x-app-layout>
