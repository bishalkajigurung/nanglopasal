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

        <!-- Main Product Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6 md:p-8">

                <!-- Left Column - Product Images Gallery -->
                <div class="space-y-4">
                    @php
                        $allImages = [];
                        foreach($product->productVarients as $variant) {
                            if(is_array($variant->image) || is_object($variant->image)) {
                                $allImages = array_merge($allImages, (array)$variant->image);
                            }
                        }
                        $allImages = array_unique($allImages);
                        $mainImage = !empty($allImages) ? $allImages[0] : 'https://placehold.co/600x600/e2e8f0/64748b?text=No+Image';
                    @endphp

                    <!-- Main Image Display -->
                    <div class="bg-gray-50 rounded-xl overflow-hidden aspect-square flex items-center justify-center p-8 border border-gray-200">
                        <img id="mainProductImage" src="{{ asset('storage/' . $mainImage) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-contain transition-all duration-300 hover:scale-105"
                             onerror="this.src='https://placehold.co/600x600/e2e8f0/64748b?text=Product+Image'">
                    </div>

                    <!-- Thumbnail Gallery (if multiple images) -->
                    @if(count($allImages) > 1)
                    <div class="flex gap-3 overflow-x-auto pb-2 no-scrollbar">
                        @foreach(array_slice($allImages, 0, 6) as $index => $img)
                        <button onclick="document.getElementById('mainProductImage').src='{{ asset('storage/' . $img) }}'"
                                class="w-20 h-20 rounded-lg border-2 border-gray-200 hover:border-primary transition overflow-hidden bg-gray-50 flex-shrink-0">
                            <img src="{{ asset('storage/' . $img) }}" alt="Thumbnail {{ $index+1 }}"
                                 class="w-full h-full object-cover"
                                 onerror="this.src='https://placehold.co/80x80/e2e8f0/64748b?text=Img'">
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Right Column - Product Details -->
                <div class="flex flex-col space-y-5">
                    <!-- Stock Badge -->
                    <div class="flex items-center gap-3">
                        @if($product->stock)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                <i class="fas fa-check-circle text-xs"></i> In Stock
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                <i class="fas fa-times-circle text-xs"></i> Out of Stock
                            </span>
                        @endif

                        @if($product->discount && $product->discount > 0)
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold" style="background-color: var(--secondary-color); color: #5d3a00;">
                                <i class="fas fa-tag"></i> {{ $product->discount }}% OFF
                            </span>
                        @endif
                    </div>

                    <!-- Product Name -->
                    <h1 class="text-3xl md:text-4xl font-bold" style="color: var(--text-color);">
                        {{ $product->name }}
                    </h1>

                    <!-- Seller Info -->
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i class="fas fa-store"></i>
                        <span>Sold by: </span>
                        <a href="#" class="font-medium hover:text-primary transition" style="color: var(--primary-color);">
                            {{ $product->seller->shop_name ?? 'Nanglo Pasal Official' }}
                        </a>
                    </div>

                    <!-- Description -->
                    <div class="border-t border-b border-gray-100 py-4 my-2">
                        <p class="text-gray-600 leading-relaxed">
                            {!! $product->description !!}
                        </p>
                    </div>

                    <!-- Variants Selection Section -->
                    <div class="space-y-4">
                        <h3 class="font-semibold text-lg" style="color: var(--text-color);">
                            <i class="fas fa-tags mr-2" style="color: var(--primary-color);"></i> Select Variant
                        </h3>

                        @if($product->productVarients->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($product->productVarients as $index => $variant)
                                    @php
                                        $originalPrice = $variant->price;
                                        $discountPercent = $product->discount ?? 0;
                                        $discountedPrice = $originalPrice - ($originalPrice * $discountPercent / 100);
                                        $hasDiscount = $discountPercent > 0;
                                    @endphp
                                    <label class="variant-option relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all hover:shadow-md"
                                           style="border-color: #e5e7eb;"
                                           data-variant-id="{{ $variant->id }}"
                                           data-variant-price="{{ $variant->price }}"
                                           data-variant-discounted-price="{{ $discountedPrice }}"
                                           data-variant-title="{{ $variant->title }}"
                                           data-variant-discount="{{ $discountPercent }}"
                                           data-variant-images="{{ json_encode($variant->image) }}">
                                        <input type="radio" name="selected_variant" value="{{ $variant->id }}"
                                               class="w-5 h-5" style="accent-color: var(--primary-color);"
                                               {{ $loop->first ? 'checked' : '' }}>
                                        <div class="ml-3 flex-1">
                                            <p class="font-semibold text-gray-800">{{ $variant->title }}</p>
                                            <div class="flex items-center gap-2 flex-wrap mt-1">
                                                @if($hasDiscount)
                                                    <span class="text-lg font-bold" style="color: var(--primary-color);">
                                                        NPR {{ number_format($discountedPrice, 2) }}
                                                    </span>
                                                    <span class="text-sm text-gray-400 line-through">
                                                        NPR {{ number_format($originalPrice, 2) }}
                                                    </span>
                                                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-1.5 py-0.5 rounded">
                                                        Save {{ number_format($discountPercent) }}%
                                                    </span>
                                                @else
                                                    <span class="text-lg font-bold" style="color: var(--primary-color);">
                                                        NPR {{ number_format($originalPrice, 2) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        @if($loop->first && $hasDiscount)
                                            <span class="absolute -top-2 -right-2 bg-primary text-white text-xs px-2 py-0.5 rounded-full">Popular</span>
                                        @endif
                                    </label>
                                @endforeach
                            </div>

                            <!-- Selected variant details display -->
                            <div id="selectedVariantInfo" class="mt-3 p-3 bg-gray-50 rounded-lg text-sm text-gray-600">
                                <i class="fas fa-info-circle mr-1" style="color: var(--primary-color);"></i>
                                Selected: <span id="selectedVariantName">{{ $product->productVarients->first()->title }}</span>
                                <span id="selectedVariantPriceDisplay">
                                    @php
                                        $firstVariant = $product->productVarients->first();
                                        $firstOriginal = $firstVariant->price;
                                        $firstDiscount = $product->discount ?? 0;
                                        $firstDiscounted = $firstOriginal - ($firstOriginal * $firstDiscount / 100);
                                    @endphp
                                    @if($firstDiscount > 0)
                                        <span class="font-bold" style="color: var(--primary-color);">NPR {{ number_format($firstDiscounted, 2) }}</span>
                                        <span class="text-gray-400 line-through ml-1">NPR {{ number_format($firstOriginal, 2) }}</span>
                                    @else
                                        <span class="font-bold" style="color: var(--primary-color);">NPR {{ number_format($firstOriginal, 2) }}</span>
                                    @endif
                                </span>
                            </div>
                        @else
                            <div class="text-center py-8 bg-gray-50 rounded-lg">
                                <i class="fas fa-box-open text-4xl text-gray-300 mb-2"></i>
                                <p class="text-gray-500">No variants available for this product.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Quantity Selector & Add to Cart -->
                    <div class="flex flex-wrap items-center gap-4 pt-3">
                        <!-- Quantity Selector -->
                        <div class="flex items-center border border-gray-300 rounded-full overflow-hidden">
                            <button id="decreaseQty" class="px-4 py-2.5 hover:bg-gray-100 transition text-gray-600">
                                <i class="fas fa-minus text-sm"></i>
                            </button>
                            <input type="number" id="productQty" value="1" min="1" max="99"
                                   class="w-16 text-center py-2 border-x border-gray-300 outline-none font-medium">
                            <button id="increaseQty" class="px-4 py-2.5 hover:bg-gray-100 transition text-gray-600">
                                <i class="fas fa-plus text-sm"></i>
                            </button>
                        </div>

                        <!-- Add to Cart Button -->
                        <button id="addToCartBtn"
                                class="flex-1 sm:flex-none px-8 py-3 rounded-full font-bold text-white shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2"
                                style="background-color: var(--primary-color);"
                                {{ !$product->stock || $product->productVarients->count() == 0 ? 'disabled' : '' }}>
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>

                        <!-- Wishlist Button -->
                        <button class="p-3 rounded-full border border-gray-300 hover:border-primary hover:text-primary transition">
                            <i class="far fa-heart text-xl"></i>
                        </button>
                    </div>

                    <!-- Delivery Info & Support -->
                    <div class="grid grid-cols-2 gap-3 pt-4 border-t border-gray-100 mt-2">
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="fas fa-truck text-primary"></i>
                            <span>Free delivery on orders over NPR 5000</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="fas fa-undo-alt text-primary"></i>
                            <span>7-day easy returns</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="fas fa-shield-alt text-primary"></i>
                            <span>Secure transaction</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="fas fa-headset text-primary"></i>
                            <span>24/7 customer support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        @if($product->seller && $product->seller->products->count() > 1)
        <div class="mt-16">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold" style="color: var(--text-color);">
                    More from <span style="color: var(--primary-color);">{{ $product->seller->shop_name ?? 'This Seller' }}</span>
                </h2>
                <a href="#" class="text-primary hover:underline text-sm">View all →</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($product->seller->products->where('id', '!=', $product->id)->take(4) as $relatedProduct)
                    @php
                        $relatedImg = 'https://placehold.co/300x300/e2e8f0/64748b?text=Product';
                        if($relatedProduct->productVarients->first() && ($relatedProduct->productVarients->first()->image)) {
                            $imgs = (array)$relatedProduct->productVarients->first()->image;
                            $relatedImg = !empty($imgs) ? asset('storage/' . $imgs[0]) : $relatedImg;
                        }
                        $relatedOriginalPrice = $relatedProduct->productVarients->first()->price ?? 0;
                        $relatedDiscount = $relatedProduct->discount ?? 0;
                        $relatedDiscountedPrice = $relatedOriginalPrice - ($relatedOriginalPrice * $relatedDiscount / 100);
                        $hasRelatedDiscount = $relatedDiscount > 0;
                    @endphp
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 overflow-hidden group">
                        <a href="/product/{{ $relatedProduct->id }}">
                            <div class="h-48 overflow-hidden bg-gray-100">
                                <img src="{{ $relatedImg }}" alt="{{ $relatedProduct->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                     onerror="this.src='https://placehold.co/300x300/e2e8f0/64748b?text=Image'">
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 line-clamp-1">{{ $relatedProduct->name }}</h3>
                                @if($relatedProduct->productVarients->first())
                                    <div class="mt-1">
                                        @if($hasRelatedDiscount)
                                            <span class="text-primary font-bold">NPR {{ number_format($relatedDiscountedPrice, 2) }}</span>
                                            <span class="text-gray-400 line-through text-sm ml-2">NPR {{ number_format($relatedOriginalPrice, 2) }}</span>
                                            <span class="text-xs text-green-600 block">{{ $relatedDiscount }}% OFF</span>
                                        @else
                                            <span class="text-primary font-bold">NPR {{ number_format($relatedOriginalPrice, 2) }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<!-- JavaScript for Variant Selection & Quantity -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variant data storage with discount info
        const variantData = {};
        document.querySelectorAll('.variant-option').forEach(option => {
            const radio = option.querySelector('input');
            if(radio) {
                const id = radio.value;
                variantData[id] = {
                    title: option.dataset.variantTitle,
                    originalPrice: parseFloat(option.dataset.variantPrice),
                    discountedPrice: parseFloat(option.dataset.variantDiscountedPrice),
                    discountPercent: parseFloat(option.dataset.variantDiscount) || 0
                };
            }
        });

        // Update selected variant info display
        function updateSelectedVariantInfo() {
            const selectedRadio = document.querySelector('input[name="selected_variant"]:checked');
            if(selectedRadio && variantData[selectedRadio.value]) {
                const data = variantData[selectedRadio.value];
                const selectedVariantNameSpan = document.getElementById('selectedVariantName');
                const selectedVariantPriceDisplay = document.getElementById('selectedVariantPriceDisplay');

                if(selectedVariantNameSpan) {
                    selectedVariantNameSpan.textContent = data.title;
                }

                if(selectedVariantPriceDisplay) {
                    if(data.discountPercent > 0) {
                        selectedVariantPriceDisplay.innerHTML = `
                            <span class="font-bold" style="color: var(--primary-color);">NPR ${data.discountedPrice.toLocaleString('en-IN', {minimumFractionDigits: 2})}</span>
                            <span class="text-gray-400 line-through ml-1">NPR ${data.originalPrice.toLocaleString('en-IN', {minimumFractionDigits: 2})}</span>
                            <span class="text-xs font-semibold text-green-600 bg-green-50 px-1.5 py-0.5 rounded ml-2">Save ${Math.round(data.discountPercent)}%</span>
                        `;
                    } else {
                        selectedVariantPriceDisplay.innerHTML = `
                            <span class="font-bold" style="color: var(--primary-color);">NPR ${data.originalPrice.toLocaleString('en-IN', {minimumFractionDigits: 2})}</span>
                        `;
                    }
                }
            }
        }

        // Attach event listeners to variant radios
        const variantRadios = document.querySelectorAll('input[name="selected_variant"]');
        variantRadios.forEach(radio => {
            radio.addEventListener('change', updateSelectedVariantInfo);
        });
        updateSelectedVariantInfo();

        // Quantity controls
        const qtyInput = document.getElementById('productQty');
        const decreaseBtn = document.getElementById('decreaseQty');
        const increaseBtn = document.getElementById('increaseQty');

        if(decreaseBtn) {
            decreaseBtn.addEventListener('click', function() {
                let currentVal = parseInt(qtyInput.value);
                if(currentVal > 1) {
                    qtyInput.value = currentVal - 1;
                }
            });
        }

        if(increaseBtn) {
            increaseBtn.addEventListener('click', function() {
                let currentVal = parseInt(qtyInput.value);
                if(currentVal < 99) {
                    qtyInput.value = currentVal + 1;
                }
            });
        }

        qtyInput?.addEventListener('change', function() {
            let val = parseInt(this.value);
            if(isNaN(val) || val < 1) this.value = 1;
            if(val > 99) this.value = 99;
        });

        // Add to Cart functionality
        const addToCartBtn = document.getElementById('addToCartBtn');
        if(addToCartBtn) {
            addToCartBtn.addEventListener('click', function() {
                const selectedRadio = document.querySelector('input[name="selected_variant"]:checked');
                if(!selectedRadio) {
                    alert('Please select a product variant.');
                    return;
                }

                const quantity = parseInt(qtyInput.value);
                const variantId = selectedRadio.value;
                const variantInfo = variantData[variantId];

                console.log('Adding to cart:', {
                    product_id: {{ $product->id }},
                    product_name: '{{ addslashes($product->name) }}',
                    variant_id: variantId,
                    variant_title: variantInfo?.title,
                    quantity: quantity,
                    original_price: variantInfo?.originalPrice,
                    discounted_price: variantInfo?.discountedPrice,
                    discount_percent: variantInfo?.discountPercent
                });

                // Success feedback
                const originalText = addToCartBtn.innerHTML;
                addToCartBtn.innerHTML = '<i class="fas fa-check"></i> Added!';
                addToCartBtn.style.opacity = '0.8';
                setTimeout(() => {
                    addToCartBtn.innerHTML = originalText;
                    addToCartBtn.style.opacity = '1';
                }, 1500);

                // Uncomment for actual AJAX implementation
                /*
                fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        variant_id: variantId,
                        quantity: quantity
                    })
                }).then(response => response.json())
                  .then(data => {
                      if(data.success) {
                          // Update cart counter
                      }
                  });
                */
            });
        }
    });
</script>

</x-frontend-layout>
