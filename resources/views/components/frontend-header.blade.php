<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm shadow-sm border-b border-gray-100">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between py-3 md:py-4 gap-3">
            <!-- Logo -->
            <div class="flex items-center space-x-1">
                <i class="fas fa-utensils text-2xl" style(--primary-color);"></i>
                <span class="font-bold text-2xl tracking-tight" style="color: var(--text-color);">Nanglo<span
                        style(--primary-color);">Pasal</span></span>
            </div>

            <!-- Desktop Navigation + Products dropdown (for md+) -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('home') }}" class="font-medium text-gray-700 hover:text-primary transition">Home</a>
                <div class="relative group">
                    <a href="{{ route('products') }}"
                        class="flex items-center gap-1 font-medium text-gray-700 hover:text-primary transition focus:outline-none">
                        Products </a>
                </div>
            </div>

            <!-- Search Bar (flexible) -->
            <div class="flex-1 max-w-md mx-2 md:mx-4">
                <div class="relative">
                    <form action="{{ route('products') }}" method="GET">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="q" placeholder="Search for authentic Nepali products..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-full bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-opacity-50 text-sm transition focus:border-transparent"
                            style="focus:ring-color: var(--primary-color);">
                    </form>
                </div>
            </div>

            <!-- Login Button and Cart Icon (responsive) -->
            <div class="flex items-center gap-3">
                @if (Auth::guard('web')->user())
                    <a href="{{ route('carts') }}" class="relative">
                        <button class="p-2 rounded-full hover:bg-gray-100 transition relative">
                            <i class="fas fa-shopping-bag text-xl" style="color: var(--text-color);"></i>
                            <span
                                class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 text-xs font-bold text-white rounded-full"
                                style="background-color: var(--primary-color);">{{ Auth::guard('web')->user()->carts->count() }}</span>
                        </button>
                    </a>


                    <button id="profileButton" data-dropdown-toggle="profile"
                    class="flex items-center"
                    type="button">
                    <i class="fas fa-user text-xl" style="color: var(--text-color);"></i>
                        <svg class="w-4 h-4 ms-1.5 -me-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 9-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="profile"
                        class="z-10 hidden bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-44">
                        <ul class="p-2 text-sm text-body font-medium" aria-labelledby="profileButton">
                            <li>
                                <a href="{{ route('carts') }}"
                                    class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Cart</a>
                            </li>
                            <li>
                                <a href="{{ route('orders') }}"
                                    class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Order</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Sign
                                    out</a>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="hidden sm:flex items-center gap-2 px-5 py-2 rounded-full font-semibold text-white transition shadow-sm hover:shadow-md"
                        style="background-color: var(--primary-color);">
                        <i class="fas fa-user-alt text-sm"></i> Sign In
                    </a>
                @endif

                <!-- Mobile friendly cart & menu icon -->
                <button class="sm:hidden p-2 rounded-full hover:bg-gray-100 transition">
                    <i class="fas fa-user text-xl" style(--primary-color);"></i>
                </button>
                <!-- Mobile menu button -->
                <button class="md:hidden p-2 rounded-full hover:bg-gray-100 transition">
                    <i class="fas fa-bars text-xl text-gray-700"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- Mobile dropdown simple (hidden by default, can be expanded with js, but we keep static for demo) -->
</header>
