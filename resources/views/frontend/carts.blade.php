<x-frontend-layout>
<div class="bg-gray-50 py-8 md:py-12 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-sm text-gray-500">
            <a href="/" class="hover:text-primary transition">Home</a>
            <i class="fas fa-chevron-right mx-2 text-xs mt-1"></i>
            <span class="text-gray-800 font-medium">Shopping Cart</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold" style="color: var(--text-color);">Shopping Cart</h1>
                <p class="text-gray-500 mt-1">{{ $carts->count() }} item(s) in your cart</p>
            </div>
            <a href="/" class="mt-4 md:mt-0 inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-gray-300 hover:border-primary hover:text-primary transition">
                <i class="fas fa-arrow-left"></i> Continue Shopping
            </a>
        </div>

        @if($carts->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-6">
                    @php 
                        $groupedCarts = $carts->groupBy('seller_id'); 
                        $grandTotal = 0; 
                    @endphp

                    @foreach($groupedCarts as $sellerId => $sellerCarts)
                        @php
                            $seller = $sellerCarts->first()->seller;
                            $sellerTotal = 0;
                        @endphp

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <!-- Seller Header -->
                            <div class="px-6 py-4 border-b bg-gray-50">
                                <h2 class="font-bold text-lg">{{ $seller->shop_name ?? 'Seller' }}</h2>
                            </div>

                            <div class="divide-y divide-gray-100">
                                @foreach($sellerCarts as $cart)
                                    @php
                                        $variant = $cart->productVarient;
                                        $product = $cart->product;
                                        $image = 'https://placehold.co/300x300/e2e8f0/64748b?text=Product';
                                        if($variant && $variant->image) {
                                            $imgs = (array)$variant->image;
                                            $image = !empty($imgs[0]) ? asset('storage/' . $imgs[0]) : $image;
                                        }
                                        $subtotal = $cart->amount * $cart->qty;
                                        $sellerTotal += $subtotal;
                                        $grandTotal += $subtotal;
                                    @endphp

                                    <div class="p-6 flex flex-col md:flex-row gap-6 items-center">
                                        <!-- Image -->
                                        <a href="/product/{{ $product->id }}" class="w-28 h-28 flex-shrink-0 bg-gray-100 rounded-xl overflow-hidden">
                                            <img src="{{ $image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        </a>

                                        <!-- Details -->
                                        <div class="flex-1">
                                            <a href="/product/{{ $product->id }}" class="font-semibold text-lg hover:text-primary">
                                                {{ $product->name }}
                                            </a>
                                            <p class="text-sm text-gray-500 mt-1">{{ $variant->title ?? 'Default Variant' }}</p>
                                            <p class="text-xl font-bold mt-2" style="color: var(--primary-color);">
                                                NPR {{ number_format($cart->amount, 2) }}
                                            </p>
                                        </div>

                                        <!-- Quantity & Actions -->
                                        <div class="flex flex-col items-end gap-4">
                                            <!-- Quantity Update Form -->
                                            <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="flex items-center border border-gray-300 rounded-full">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" onclick="changeQty(this, -1)" 
                                                        class="px-4 py-2.5 hover:bg-gray-100 transition">-</button>
                                                <input type="number" name="qty" value="{{ $cart->qty }}" 
                                                       class="w-14 text-center outline-none font-medium" min="1">
                                                <button type="button" onclick="changeQty(this, 1)" 
                                                        class="px-4 py-2.5 hover:bg-gray-100 transition">+</button>
                                            </form>

                                            <div class="text-right">
                                                <p class="text-sm text-gray-500">Subtotal</p>
                                                <p class="font-bold text-lg">NPR {{ number_format($subtotal, 2) }}</p>
                                            </div>

                                            <!-- Remove -->
                                            <form action="{{ route('cart.destroy', $cart->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-600 flex items-center gap-1 text-sm">
                                                    <i class="fas fa-trash"></i> Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="px-6 py-4 bg-gray-50 border-t text-right font-semibold">
                                Seller Total: NPR {{ number_format($sellerTotal, 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border p-6 sticky top-24">
                        <h2 class="text-2xl font-bold mb-6">Order Summary</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between text-lg">
                                <span>Subtotal</span>
                                <span>NPR {{ number_format($grandTotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-green-600">
                                <span>Shipping</span>
                                <span>Free</span>
                            </div>
                            <hr>
                            <div class="flex justify-between text-xl font-bold">
                                <span>Total</span>
                                <span>NPR {{ number_format($grandTotal, 2) }}</span>
                            </div>
                        </div>

                        <button class="w-full mt-8 py-4 rounded-full text-white font-bold text-lg"
                                style="background-color: var(--primary-color);">
                            Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-20 bg-white rounded-2xl">
                <i class="fas fa-shopping-cart text-7xl text-gray-300 mb-6"></i>
                <h2 class="text-2xl font-bold mb-2">Your cart is empty</h2>
                <a href="/" class="inline-block px-8 py-3 rounded-full text-white font-semibold mt-4"
                   style="background-color: var(--primary-color);">Start Shopping</a>
            </div>
        @endif
    </div>
</div>

<!-- Quantity JavaScript -->
<script>
function changeQty(btn, change) {
    const form = btn.closest('form');
    const qtyInput = form.querySelector('input[name="qty"]');
    let currentQty = parseInt(qtyInput.value);

    currentQty += change;
    if (currentQty < 1) currentQty = 1;

    qtyInput.value = currentQty;
    form.submit();   // Auto submit on change
}
</script>

</x-frontend-layout>