<x-frontend-layout>
    <div class="bg-gray-50 py-8 md:py-12 min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav class="flex mb-6 text-sm text-gray-500">
                <a href="/" class="hover:text-primary transition">Home</a>
                <i class="fas fa-chevron-right mx-2 text-xs mt-1"></i>
                <span class="text-gray-800 font-medium">My Orders</span>
            </nav>

            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl md:text-4xl font-bold" style="color: var(--text-color);">My Orders</h1>
                <a href="{{ route('carts') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-gray-300 hover:border-primary hover:text-primary transition">
                    <i class="fas fa-shopping-cart"></i> View Cart
                </a>
            </div>

            @if ($orders->count() > 0)
                <div class="space-y-6">
                    @foreach ($orders as $order)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                            <!-- Order Header -->
                            <div
                                class="px-6 py-5 border-b bg-gray-50 flex flex-wrap justify-between items-center gap-4">
                                <div>
                                    <p class="text-xs text-gray-500">ORDER ID</p>
                                    <p class="font-bold text-lg">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">DATE</p>
                                    <p class="font-medium">{{ $order->created_at->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">PAYMENT</p>
                                    <p class="font-medium capitalize">{{ $order->payment_method }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">TOTAL</p>
                                    <p class="font-bold text-xl" style="color: var(--primary-color);">
                                        NPR {{ number_format($order->total_amount, 2) }}
                                    </p>
                                </div>
                                <div>
                                    <span
                                        class="inline-block px-5 py-2 rounded-full text-sm font-semibold
                                    @if ($order->status == 'delivered') bg-green-100 text-green-700
                                    @elseif($order->status == 'shipped') bg-blue-100 text-blue-700
                                    @elseif($order->status == 'processing') bg-yellow-100 text-yellow-700
                                    @elseif($order->status == 'cancelled') bg-red-100 text-red-700
                                    @else bg-orange-100 text-orange-700 @endif">
                                        {{ ucfirst($order->status ?? 'pending') }}
                                    </span>
                                </div>
                            </div>


                            <!-- Order Items -->
                            <div class="p-6">
                                @if ($order->orderItems && $order->orderItems->count() > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        @foreach ($order->orderItems as $item)
                                            <div class="flex gap-4 border border-gray-100 rounded-xl p-4">
                                                <div
                                                    class="w-20 h-20 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                                                    @php
                                                        // Handle JSON image from product_varients
                                                        $imageUrl = null;

                                                        // Check if product variant exists and has image
                                                        if ($item->productVarient && $item->productVarient->image) {
                                                            $imageData = $item->productVarient->image;

                                                            // If image is stored as JSON string, decode it
                                                            if (is_string($imageData)) {
                                                                $imageData = json_decode($imageData, true);
                                                            }

                                                            // Get the first image from the array or use as is
                                                            if (is_array($imageData) && count($imageData) > 0) {
                                                                $imageUrl = $imageData[0] ?? null;
                                                            } elseif (is_string($imageData)) {
                                                                $imageUrl = $imageData;
                                                            }
                                                        }

                                                        // Fallback to product image if no variant image (if your products table has image field)
                                                        if (
                                                            !$imageUrl &&
                                                            $item->product &&
                                                            method_exists($item->product, 'getFirstImage')
                                                        ) {
                                                            // You can add product image logic here if needed
                                                        }
                                                    @endphp

                                                    <img src="{{ $imageUrl && file_exists(public_path('storage/' . $imageUrl))
                                                        ? asset('storage/' . $imageUrl)
                                                        : 'https://placehold.co/80x80/e2e8f0/64748b?text=No+Image' }}"
                                                        alt="{{ $item->product->name ?? 'Product' }}"
                                                        class="w-full h-full object-cover">
                                                </div>
                                                <div class="flex-1">
                                                    <p class="font-semibold line-clamp-2">
                                                        {{ $item->product->name ?? 'Product' }}
                                                    </p>
                                                    @if ($item->productVarient && $item->productVarient->title)
                                                        <p class="text-sm text-gray-500">
                                                            {{ $item->productVarient->title }}</p>
                                                    @endif
                                                    <p class="text-sm mt-2">
                                                        Qty: <strong>{{ $item->qty }}</strong> ×
                                                        NPR {{ number_format($item->amount, 2) }}
                                                    </p>
                                                </div>
                                                <div class="font-semibold text-right">
                                                    NPR {{ number_format($item->amount * $item->qty, 2) }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 italic">No items found</p>
                                @endif
                            </div>

                            <!-- Footer -->
                            <div class="px-6 py-4 bg-gray-50 border-t flex justify-between items-center">
                                <a href="#" class="text-primary hover:underline font-medium">
                                    <i class="fas fa-eye"></i> View Details
                                </a>

                                @if (in_array($order->status ?? 'pending', ['pending', 'processing']))
                                    <form action="{{ route('order.cancel', $order->id) }}" method="POST"
                                        onsubmit="return confirm('Cancel this order?')">
                                        @csrf
                                        @method('patch')
                                        <button type="submit" class="text-red-500 hover:text-red-600 font-medium">
                                            Cancel Order
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl p-20 text-center">
                    <i class="fas fa-box-open text-7xl text-gray-300 mb-6"></i>
                    <h2 class="text-2xl font-bold mb-3">No Orders Yet</h2>
                    <p class="text-gray-500 mb-8">You haven't made any purchases yet.</p>
                    <a href="{{ route('products') }}"
                        class="inline-block px-8 py-4 rounded-full text-white font-semibold"
                        style="background-color: var(--primary-color);">
                        Browse Products
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-frontend-layout>
