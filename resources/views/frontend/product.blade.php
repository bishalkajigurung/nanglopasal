<x-frontend-layout>
<div class="bg-gray-50 py-8 md:py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-sm text-gray-500">
            <a href="/" class="hover:text-primary transition">Home</a>
            <i class="fas fa-chevron-right mx-2 text-xs mt-1"></i>
            <a href="#" class="hover:text-primary transition">Products</a>
            <i class="fas fa-chevron-right mx-2 text-xs mt-1"></i>
            <span class="text-gray-800 font-medium">{{ Str::limit($product->name, 40) }}</span>
        </nav>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6 md:p-8">

                <!-- Left - Images -->
                <div class="space-y-4">
                    @php
                        $allImages = [];
                        foreach($product->productVarients as $variant) {
                            if (is_array($variant->image) || is_object($variant->image)) {
                                $allImages = array_merge($allImages, (array)$variant->image);
                            }
                        }
                        $allImages = array_unique($allImages);
                        $mainImage = !empty($allImages) ? $allImages[0] : 'https://placehold.co/600x600/e2e8f0/64748b?text=No+Image';
                    @endphp

                    <div class="bg-gray-50 rounded-xl overflow-hidden aspect-square flex items-center justify-center p-8 border border-gray-200">
                        <img id="mainProductImage" 
                             src="{{ asset('storage/' . $mainImage) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-contain transition-all duration-300"
                             onerror="this.src='https://placehold.co/600x600/e2e8f0/64748b?text=Product+Image'">
                    </div>

                    <!-- Thumbnails -->
                    @if(count($allImages) > 1)
                    <div class="flex gap-3 overflow-x-auto pb-2 no-scrollbar">
                        @foreach(array_slice($allImages, 0, 6) as $img)
                            <button onclick="changeMainImage('{{ asset('storage/' . $img) }}')"
                                    class="w-20 h-20 rounded-lg border-2 border-gray-200 hover:border-primary transition overflow-hidden bg-gray-50 flex-shrink-0">
                                <img src="{{ asset('storage/' . $img) }}" 
                                     alt="Thumbnail" 
                                     class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Right - Details -->
                <div class="flex flex-col space-y-5">

                    <!-- Stock & Discount -->
                    <div class="flex items-center gap-3">
                        @if($product->stock)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                <i class="fas fa-check-circle"></i> In Stock
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                <i class="fas fa-times-circle"></i> Out of Stock
                            </span>
                        @endif
                        @if($product->discount > 0)
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold"
                                  style="background-color: var(--secondary-color); color: #5d3a00;">
                                <i class="fas fa-tag"></i> {{ $product->discount }}% OFF
                            </span>
                        @endif
                    </div>

                    <h1 class="text-3xl md:text-4xl font-bold" style="color: var(--text-color);">
                        {{ $product->name }}
                    </h1>

                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i class="fas fa-store"></i>
                        <span>Sold by:</span>
                        <a href="#" style="color: var(--primary-color);">{{ $product->seller->shop_name ?? 'Nanglo Pasal Official' }}</a>
                    </div>

                    <div class="border-t border-b border-gray-100 py-4 my-2">
                        <p class="text-gray-600 leading-relaxed">{!! $product->description !!}</p>
                    </div>

                    <!-- Add to Cart Form -->
                    <div class="space-y-4">
                        <h3 class="font-semibold text-lg" style="color: var(--text-color);">
                            <i class="fas fa-tags mr-2" style="color: var(--primary-color);"></i> Select Variant
                        </h3>

                        <form id="cart_form" action="{{ route('cart.store') }}" method="POST">
                            @csrf

                            @if($product->productVarients->count() > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach($product->productVarients as $variant)
                                        @php
                                            $originalPrice = $variant->price;
                                            $discountPercent = $product->discount ?? 0;
                                            $discountedPrice = $originalPrice * (1 - $discountPercent/100);
                                        @endphp
                                        <label class="variant-option relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all hover:shadow-md"
                                               style="border-color: #e5e7eb;"
                                               data-variant-id="{{ $variant->id }}"
                                               data-variant-price="{{ $variant->price }}"
                                               data-variant-discounted-price="{{ $discountedPrice }}"
                                               data-variant-title="{{ $variant->title }}"
                                               data-variant-discount="{{ $discountPercent }}"
                                               data-first-image="{{ isset($variant->image) && !empty($variant->image) ? asset('storage/' . ((array)$variant->image)[0]) : '' }}">
                                            <input type="radio" 
                                                   name="varient_id" 
                                                   value="{{ $variant->id }}"
                                                   class="w-5 h-5" 
                                                   style="accent-color: var(--primary-color);"
                                                   {{ $loop->first ? 'checked' : '' }}>
                                            <div class="ml-3 flex-1">
                                                <p class="font-semibold">{{ $variant->title }}</p>
                                                <div class="flex items-center gap-2 mt-1">
                                                    @if($discountPercent > 0)
                                                        <span class="text-lg font-bold" style="color: var(--primary-color);">NPR {{ number_format($discountedPrice, 2) }}</span>
                                                        <span class="text-sm text-gray-400 line-through">NPR {{ number_format($originalPrice, 2) }}</span>
                                                    @else
                                                        <span class="text-lg font-bold" style="color: var(--primary-color);">NPR {{ number_format($originalPrice, 2) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <input type="hidden" name="varient_id" value="{{ $product->productVarients->first()->id ?? '' }}">
                            @endif

                            <input type="hidden" name="qty" id="qty_input" value="1">

                            <!-- Quantity + Add Button -->
                            <div class="flex flex-wrap items-center gap-4 pt-4">
                                <div class="flex items-center border border-gray-300 rounded-full overflow-hidden">
                                    <button type="button" id="decreaseQty" class="px-4 py-2.5 hover:bg-gray-100">−</button>
                                    <input type="number" id="productQty" value="1" min="1" max="99"
                                           class="w-16 text-center py-2 border-x border-gray-300 outline-none font-medium">
                                    <button type="button" id="increaseQty" class="px-4 py-2.5 hover:bg-gray-100">+</button>
                                </div>

                                <button type="button" id="addToCartBtn"
                                        class="flex-1 px-8 py-3 rounded-full font-bold text-white shadow-md hover:shadow-lg transition"
                                        style="background-color: var(--primary-color);">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Delivery -->
                    <div class="grid grid-cols-2 gap-3 pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-2 text-sm text-gray-500"><i class="fas fa-truck"></i> Free delivery over NPR 5000</div>
                        <div class="flex items-center gap-2 text-sm text-gray-500"><i class="fas fa-undo-alt"></i> 7-day returns</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===================== JAVASCRIPT ===================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    const mainImage = document.getElementById('mainProductImage');
    const qtyInput = document.getElementById('productQty');
    const hiddenQty = document.getElementById('qty_input');
    const cartForm = document.getElementById('cart_form');
    const addToCartBtn = document.getElementById('addToCartBtn');

    // Change Main Image Function
    window.changeMainImage = function(src) {
        if (src) mainImage.src = src;
    };

    // Variant Selection + Image Change
    document.querySelectorAll('input[name="varient_id"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const label = this.closest('.variant-option');
            const variantImage = label.dataset.firstImage;
            
            if (variantImage) {
                changeMainImage(variantImage);
            }
        });
    });

    // Quantity Controls
    document.getElementById('decreaseQty').addEventListener('click', () => {
        let val = parseInt(qtyInput.value);
        if (val > 1) {
            qtyInput.value = val - 1;
            hiddenQty.value = qtyInput.value;
        }
    });

    document.getElementById('increaseQty').addEventListener('click', () => {
        let val = parseInt(qtyInput.value);
        if (val < 99) {
            qtyInput.value = val + 1;
            hiddenQty.value = qtyInput.value;
        }
    });

    qtyInput.addEventListener('change', () => {
        let val = parseInt(qtyInput.value);
        if (isNaN(val) || val < 1) val = 1;
        if (val > 99) val = 99;
        qtyInput.value = val;
        hiddenQty.value = val;
    });

    // Add to Cart
    addToCartBtn.addEventListener('click', function () {
        if (!document.querySelector('input[name="varient_id"]:checked')) {
            alert('Please select a product variant!');
            return;
        }

        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fas fa-check"></i> Added!';
        this.style.opacity = '0.8';
        this.disabled = true;

        hiddenQty.value = qtyInput.value;

        setTimeout(() => {
            cartForm.submit();
        }, 700);
    });
});
</script>
</x-frontend-layout>