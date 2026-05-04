<x-frontend-layout>

    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo and Title -->
            <div class="text-center">
                <div class="flex justify-center mb-4">
                    <div class="h-16 w-16 rounded-full flex items-center justify-center shadow-lg"
                        style="background-color: var(--primary-color);">
                        <i class="fas fa-utensils text-3xl text-white"></i>
                    </div>
                </div>
                <h2 class="mt-4 text-3xl font-extrabold" style="color: var(--text-color);">
                    Welcome to <span style="color: var(--primary-color);">Nanglo Pasal</span>
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Sign in to continue shopping and discover authentic Nepali products
                </p>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-8 sm:px-8">
                    <!-- Welcome Message -->
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-100 mb-3">
                            <i class="fas fa-smile-wink text-xl" style="color: var(--accent-color);"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Sign in to your account</h3>
                        <p class="text-sm text-gray-500 mt-1">One click sign in with Google</p>
                    </div>

                    <!-- Google Login Button (Only Option) -->
                    <div class="space-y-6">
                        <a href="{{ route('google.redirect') }}"
                            class="w-full flex items-center justify-center gap-3 px-6 py-3.5 border border-gray-300 rounded-xl shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                    fill="#4285F4" />
                                <path
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                    fill="#34A853" />
                                <path
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                    fill="#FBBC05" />
                                <path
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                    fill="#EA4335" />
                            </svg>
                            <span class="font-medium">Continue with Google</span>
                        </a>
                    </div>

                    <!-- Divider -->
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-400">Secure Login</span>
                        </div>
                    </div>

                    <!-- Benefits Section -->
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3 text-gray-600">
                            <i class="fas fa-check-circle text-green-500 text-sm"></i>
                            <span>Fast checkout with saved addresses</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-600">
                            <i class="fas fa-check-circle text-green-500 text-sm"></i>
                            <span>Track your orders in real-time</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-600">
                            <i class="fas fa-check-circle text-green-500 text-sm"></i>
                            <span>Save favorite products to wishlist</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-600">
                            <i class="fas fa-check-circle text-green-500 text-sm"></i>
                            <span>Exclusive deals and offers</span>
                        </div>
                    </div>
                </div>

                <!-- Footer Note -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 text-center">
                    <p class="text-xs text-gray-500">
                        <i class="fas fa-lock mr-1"></i> Your privacy and security is our priority
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        By continuing, you agree to our <a href="#" class="text-primary hover:underline">Terms of
                            Service</a> and <a href="#" class="text-primary hover:underline">Privacy Policy</a>
                    </p>
                </div>
            </div>

            <!-- Guest Checkout Option (Optional - if you want to allow guest browsing) -->
            <div class="text-center">
                <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-primary transition">
                    <i class="fas fa-arrow-left mr-1"></i> Continue as guest
                </a>
            </div>
        </div>
    </div>
</x-frontend-layout>
