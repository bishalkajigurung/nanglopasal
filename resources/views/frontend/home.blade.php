<x-frontend-layout>
    <!-- ========== HERO SECTION ========== -->
    <section class="relative overflow-hidden bg-liner-to-br from-amber-50 to-orange-50/30 py-12 md:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-12">
                <!-- left content -->
                <div class="flex-1 text-center lg:text-left space-y-6">
                    <span
                        class="inline-block px-4 py-1.5 rounded-full text-sm font-semibold bg-white/70 backdrop-blur-sm shadow-sm"
                        style="color: var(--accent-color); border-left: 3px solid var(--primary-color);">
                        <i class="fas fa-fire-alt mr-1 text-primary"></i> Authentic Nepali Flavors
                    </span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight"
                        style="color: var(--text-color);">
                        Taste the <span style(--primary-color);">Heritage</span><br> of Himalaya
                    </h1>
                    <p class="text-gray-600 text-lg max-w-xl mx-auto lg:mx-0">
                        Discover handpicked traditional groceries, organic spices, and unique kitchenware delivered to
                        your doorstep.
                    </p>
                    <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                        <button
                            class="px-8 py-3 rounded-full text-white font-semibold text-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5"
                            style="background-color: var(--primary-color);">
                            Shop Now <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                        <button
                            class="px-8 py-3 rounded-full bg-white border-2 font-semibold text-lg transition hover:bg-gray-50 shadow-sm"
                            style="border-color: var(--primary-color); color: var(--primary-color);">
                            Explore Deals
                        </button>
                    </div>
                    <div class="flex items-center gap-6 justify-center lg:justify-start pt-4">
                        <div class="flex -space-x-2">
                            <div
                                class="w-10 h-10 rounded-full bg-gray-300 border-2 border-white flex items-center justify-center text-xs font-bold">
                                ⭐</div>
                            <div
                                class="w-10 h-10 rounded-full bg-gray-300 border-2 border-white flex items-center justify-center text-xs font-bold">
                                🍲</div>
                            <div
                                class="w-10 h-10 rounded-full bg-gray-300 border-2 border-white flex items-center justify-center text-xs font-bold">
                                🌿</div>
                        </div>
                        <div class="text-sm text-gray-500">Trusted by 10k+ <span class="font-semibold text-black">happy
                                customers</span></div>
                    </div>
                </div>
                <!-- right hero image / placeholder modern -->
                <div class="flex-1 flex justify-center">
                    <div
                        class="relative w-72 h-72 md:w-96 md:h-96 rounded-full bg-liner-to-tr from-primary/10 via-amber-100 to-white flex items-center justify-center shadow-xl">
                        <i class="fas fa-mountain text-8xl text-primary/40 absolute top-8 left-8"></i>
                        <div class="bg-white p-4 rounded-2xl shadow-2xl rotate-6 transform hover:rotate-0 transition">
                            <div class="bg-primary/10 rounded-xl p-4">
                                <i class="fas fa-drumstick-bite text-6xl" style(--primary-color);"></i>
                            </div>
                        </div>
                        <i class="fas fa-pepper-hot absolute bottom-12 right-8 text-5xl text-secondary/70"></i>
                        <i class="fas fa-leaf absolute top-1/2 -left-6 text-4xl"
                            style="color: var(--accent-color); opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- small abstract shapes -->
        <div class="absolute bottom-0 left-0 w-40 h-40 bg-primary/5 rounded-full blur-3xl -z-0"></div>
    </section>

    <!-- ========== PRODUCT CARD SECTION (E-commerce grid) ========== -->
    <section class="py-16 md:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-4">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold" style="color: var(--text-color);">Popular <span
                            style(--primary-color);">Products</span></h2>
                    <p class="text-gray-500 mt-2">Traditional quality, modern convenience</p>
                </div>
                <a href="{{ route('products') }}" class="flex items-center gap-2 text-primary font-semibold hover:underline transition">
                    View all <i class="fas fa-long-arrow-alt-right"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                @foreach ($products as $product)
                <x-product-card :product="$product"/>
                 @endforeach
            </div>
        </div>
    </section>

    <!-- Seller Request Registration Form Section -->
    <section class="py-16 md:py-24 bg-gradient-to-br from-gray-50 to-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-block px-4 py-1.5 rounded-full text-sm font-semibold bg-primary/10 mb-4"
                    style="color: var(--primary-color);">
                    <i class="fas fa-store mr-2"></i> Become a Seller
                </span>
                <h2 class="text-3xl md:text-4xl font-bold mb-4" style="color: var(--text-color);">
                    Sell With <span style="color: var(--primary-color);">Nanglo Pasal</span>
                </h2>
                <p class="text-gray-600 text-lg">
                    Join our marketplace and reach thousands of customers. Submit your request, and our team will review
                    and approve your seller account.
                </p>
            </div>

            <div class="max-w-3xl mx-auto">
                <!-- Form Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <!-- Form Header with progress indicator -->
                    <div class="px-6 py-5 sm:px-8 border-b border-gray-100"
                        style="background: linear-gradient(135deg, rgba(214,40,40,0.03) 0%, rgba(244,180,0,0.02) 100%);">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center bg-primary/10">
                                <i class="fas fa-user-check text-xl" style="color: var(--primary-color);"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-xl" style="color: var(--text-color);">Seller Registration
                                    Request</h3>
                                <p class="text-sm text-gray-500">Fill in the details below to get started</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Body -->
                    <form action="{{ route('seller.request') }}" method="POST" class="p-6 sm:p-8 space-y-6" id="sellerRegistrationForm">
                        @csrf
                        <!-- Name Field -->
                        <div class="space-y-2">
                            <label for="sellerName" class="block text-sm font-semibold text-gray-700">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400 text-sm"></i>
                                </div>
                                <input type="text" id="sellerName" name="name" required
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-transparent transition"
                                    placeholder="e.g., Rajesh Hamal" style="background-color: #fefefe;">

                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="space-y-2">
                            <label for="sellerEmail" class="block text-sm font-semibold text-gray-700">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400 text-sm"></i>
                                </div>
                                <input type="email" id="sellerEmail" name="email" required
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-transparent transition"
                                    placeholder="seller@example.com" style="background-color: #fefefe;">
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                            </div>
                        </div>

                        <!-- Shop Name Field -->
                        <div class="space-y-2">
                            <label for="shopName" class="block text-sm font-semibold text-gray-700">
                                Shop / Store Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-store text-gray-400 text-sm"></i>
                                </div>
                                <input type="text" id="shopName" name="shop_name" required
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-transparent transition"
                                    placeholder="e.g., Himalayan Mart, Kathmandu Bazaar"
                                    style="background-color: #fefefe;">
                                    @error('shop_name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                            </div>
                        </div>

                        <!-- Contact Number Field -->
                        <div class="space-y-2">
                            <label for="sellerContact" class="block text-sm font-semibold text-gray-700">
                                Contact Number <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone-alt text-gray-400 text-sm"></i>
                                </div>
                                <input type="tel" id="sellerContact" name="contact" required
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-transparent transition"
                                    placeholder="+977 9812345678" style="background-color: #fefefe;">
                                    @error('contact')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                            </div>
                        </div>

                        <!-- Terms & Conditions Checkbox -->
                        <div class="flex items-start gap-3">
                            <input type="checkbox" id="termsCheckbox" required
                                class="mt-1 w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary/50"
                                style="accent-color: var(--primary-color);">
                            <label for="termsCheckbox" class="text-sm text-gray-600">
                                I agree to the <a href="#" class="text-primary hover:underline"
                                    style="color: var(--primary-color);">Seller Terms & Conditions</a> and confirm that
                                the information provided is accurate.
                            </label>
                        </div>

                        <!-- Submit Button & Note -->
                        <div class="pt-4">
                            <button type="submit"
                                class="w-full py-3.5 rounded-xl font-bold text-white shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-lg"
                                style="background-color: var(--primary-color);">
                                <i class="fas fa-paper-plane"></i> Submit Registration Request
                            </button>
                            <p class="text-xs text-center text-gray-400 mt-4">
                                <i class="fas fa-clock mr-1"></i> Approval typically takes 2-3 business days. You'll
                                receive an email confirmation.
                            </p>
                        </div>
                    </form>

                    <!-- Success Message (Hidden by default) -->
                    <div id="successMessage"
                        class="hidden mx-6 sm:mx-8 mb-6 p-4 rounded-xl bg-green-50 border border-green-200">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            <div>
                                <h4 class="font-semibold text-green-800">Request Submitted Successfully!</h4>
                                <p class="text-sm text-green-700">Thank you for your interest. Our team will review
                                    your application and get back to you shortly.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Info Box: Why Sell With Us -->
                    <div class="bg-gray-50 px-6 sm:px-8 py-5 border-t border-gray-100">
                        <div class="flex flex-wrap gap-6 justify-between items-center">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-chart-line text-primary"></i>
                                <span class="text-sm text-gray-600">Reach 50k+ monthly shoppers</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-shield-alt text-primary"></i>
                                <span class="text-sm text-gray-600">Secure payment protection</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-headset text-primary"></i>
                                <span class="text-sm text-gray-600">Dedicated seller support</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- small trust badge / promotional banner -->
    <section class="bg-liner-to-r from-primary/5 to-secondary/5 py-12">
        <div class="container mx-auto px-4 text-center">
            <div class="flex flex-wrap justify-center gap-8 md:gap-16">
                <div class="flex items-center space-x-3"><i class="fas fa-truck-fast text-2xl"
                        style(--primary-color);"></i><span class="font-medium">Free shipping over
                        $35</span></div>
                <div class="flex items-center space-x-3"><i class="fas fa-lock text-2xl"
                        style(--primary-color);"></i><span class="font-medium">Secure payment</span></div>
                <div class="flex items-center space-x-3"><i class="fas fa-undo-alt text-2xl"
                        style(--primary-color);"></i><span class="font-medium">15 days return</span></div>
                <div class="flex items-center space-x-3"><i class="fas fa-phone-alt text-2xl"
                        style(--primary-color);"></i><span class="font-medium">24/7 support</span></div>
            </div>
        </div>
    </section>


</x-frontend-layout>
