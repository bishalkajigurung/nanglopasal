<x-frontend-layout>
<div class="bg-gray-50 py-8 md:py-12 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-sm text-gray-500">
            <a href="/" class="hover:text-primary transition">Home</a>
            <i class="fas fa-chevron-right mx-2 text-xs mt-1"></i>
            <a href="{{ route('carts') }}" class="hover:text-primary transition">Cart</a>
            <i class="fas fa-chevron-right mx-2 text-xs mt-1"></i>
            <span class="text-gray-800 font-medium">Checkout</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Left Side - Form -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">

                    <h1 class="text-3xl font-bold mb-6" style="color: var(--text-color);">Checkout</h1>

                    <form action="{{ route('checkout.store', $seller->id) }}" method="POST">
                        @csrf

                        <input type="hidden" name="seller_id" value="{{ $seller->id }}">

                        <!-- Contact Information -->
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                                <i class="fas fa-user"></i> Contact Information
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                                    <input type="text" name="contact"
                                            value="{{ old('contact', Auth::user()->delivery_address->contact ?? '') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary"
                                           placeholder="9XXXXXXXXX" required>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Address -->
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                                <i class="fas fa-map-marker-alt"></i> Delivery Address
                            </h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <textarea name="address_detail" rows="3"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary"
                                        placeholder="House No, Street, Area, City, Near Landmark" required>{{ old('address_detail', Auth::user()->delivery_address->address_detail ?? '')}}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                                <i class="fas fa-credit-card"></i> Payment Method
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Cash on Delivery -->
                                <label class="payment-option border-2 border-gray-200 rounded-2xl p-5 cursor-pointer hover:border-primary transition">
                                    <input type="radio" name="payment_method" value="cod" checked class="hidden">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center text-green-600">
                                            <i class="fas fa-money-bill-wave text-2xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold">Cash on Delivery (COD)</p>
                                            <p class="text-sm text-gray-500">Pay when you receive the product</p>
                                        </div>
                                    </div>
                                </label>

                                <!-- Khalti -->
                            @if ($seller->khalti_secret_key)
                             <label class="payment-option border-2 border-gray-200 rounded-2xl p-5 cursor-pointer hover:border-primary transition">
                                    <input type="radio" name="payment_method" value="khalti" class="hidden">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                                            <span class="font-bold text-purple-600">K</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold">Pay with Khalti</p>
                                            <p class="text-sm text-gray-500">Digital Wallet - Instant Payment</p>
                                        </div>
                                    </div>
                                </label>
                            @endif
                            </div>
                        </div>

                        <button type="submit"
                                class="w-full mt-10 py-4 rounded-2xl text-white font-bold text-lg shadow-md hover:shadow-lg transition"
                                style="background-color: var(--primary-color);">
                            <i class="fas fa-lock mr-2"></i> Place Order • NPR {{ number_format($carts->sum(fn($c) => $c->amount * $c->qty), 2) }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Side - Order Summary -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 sticky top-24">

                    <h2 class="text-2xl font-bold mb-6">Order Summary</h2>

                    <div class="space-y-6 max-h-[500px] overflow-auto">
                        @foreach($carts as $cart)
                            @php
                                $variant = $cart->productVarient;
                                $image = $variant && $variant->image
                                    ? asset('storage/' . ((array)$variant->image)[0])
                                    : 'https://placehold.co/80x80/e2e8f0/64748b?text=Img';
                            @endphp
                            <div class="flex gap-4">
                                <img src="{{ $image }}" alt=""
                                     class="w-16 h-16 object-cover rounded-xl">
                                <div class="flex-1">
                                    <p class="font-medium line-clamp-2">{{ $cart->product->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $variant->title ?? '' }}</p>
                                    <p class="text-sm">Qty: {{ $cart->qty }}</p>
                                </div>
                                <div class="text-right font-semibold">
                                    NPR {{ number_format($cart->amount * $cart->qty, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t my-6"></div>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">NPR {{ number_format($carts->sum(fn($c) => $c->amount * $c->qty), 2) }}</span>
                        </div>
                        <div class="flex justify-between text-green-600">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold pt-4 border-t">
                            <span>Total</span>
                            <span>NPR {{ number_format($carts->sum(fn($c) => $c->amount * $c->qty), 2) }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Simple Payment Option Styling -->
<script>
document.querySelectorAll('.payment-option').forEach(option => {
    option.addEventListener('click', function() {
        document.querySelectorAll('.payment-option').forEach(opt => {
            opt.classList.remove('border-primary', 'bg-blue-50');
        });
        this.classList.add('border-primary', 'bg-blue-50');
        this.querySelector('input').checked = true;
    });
});
</script>

</x-frontend-layout>
