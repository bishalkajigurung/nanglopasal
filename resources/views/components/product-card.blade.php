<!-- Product Card -->
@props(['product'])
@php
$image = null;
if ($product->productVarients && $product->productVarients->isNotEmpty()) {
    $firstVariant = $product->productVarients->first();

    if ($firstVariant && !empty($firstVariant->image) && is_array($firstVariant->image)) {
        $image = $firstVariant->image[0] ?? null;
    }
}
@endphp

<div
    class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100">
    <div class="relative overflow-hidden bg-gray-50 h-64 flex items-center justify-center">
        <a href="{{route('product', $product->id)}}">
            <img class="object-cover h-full w-full group-hover:scale-105 transition-transform duration-300" src="{{ asset(Storage::url($image))}}" alt="{{ $product->name }}" >
        @if ($product->discount > 0)
        <span class="absolute top-4 left-4 bg-white text-xs font-bold px-3 py-1 rounded-full shadow-sm"
            style="color: var(--accent-color);">-{{$product->discount}}% off</span>

        @endif
        </a>
    </div>
    <div class="p-5">
        <h3 class="font-bold text-xl mb-1">{{$product->name}}</h3>
        <p class="text-gray-500 text-sm mb-3 line-clamp-1">{!! $product->description !!}</p>
        <div class="flex justify-between items-center mt-2">
            <a href="{{route('product', $product->id)}}"
                class="bg-gray-900 text-white px-4 py-2 rounded-full text-sm font-semibold transition hover:bg-primary focus:ring-2"
                style="background-color: var(--primary-color);">
                <i class="fas fa-arrow-right mr-1"></i> View Product
            </a>
        </div>
    </div>
</div>
