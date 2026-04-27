<x-frontend-layout>
     <section class="py-16 md:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <!-- Section header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-4">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold" style="color: var(--text-color);">All <span
                            style(--primary-color);">Products</span></h2>
                    <p class="text-gray-500 mt-2">Traditional quality, modern convenience</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                @foreach ($products as $product)
                <x-product-card :product="$product"/>
                 @endforeach
            </div>
        </div>
    </section>
</x-frontend-layout>
