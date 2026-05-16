<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #{{ $order->id }} - Nanglo Pasal</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">

    <style>
        @media print {
            body * { visibility: hidden; }
            .print-area, .print-area * { visibility: visible; }
            .print-area { position: absolute; left: 0; top: 0; width: 100%; margin: 0; padding: 0; }
            .no-print { display: none !important; }
            button, a { display: none !important; }
        }
        @page {
            size: A4;
            margin: 2cm;
        }
        .receipt-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
        }
        .dashed-border {
            border-bottom: 2px dashed #e5e7eb;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Navigation -->
        <div class="no-print mb-6 flex justify-between items-center">
            <div></div>
            <div class="space-x-3">
                <button onclick="window.print()"
                        class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-print"></i> Print Receipt
                </button>
                <button onclick="window.close()"
                        class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>

        <!-- Receipt Content -->
        <div class="print-area flex justify-center">
            <div class="bg-white rounded-2xl receipt-shadow max-w-4xl w-full">

                <!-- Header -->
                <div class="border-b border-gray-200 p-8 text-center">
                    <div class="flex justify-between items-start">
                        <div class="text-left">
                            <img src="{{ asset('frontend/images/logo.png') }}" alt="Nanglo Pasal"
                                 class="h-12 mb-2" onerror="this.style.display='none'">
                            <h2 class="text-2xl font-bold text-gray-800">Nanglo Pasal</h2>
                            <p class="text-gray-500 text-sm">Your Trusted Partner</p>
                        </div>
                        <div class="text-right">
                            <div class="bg-gray-100 px-4 py-2 rounded-lg">
                                <p class="text-xs text-gray-600">ORDER ID</p>
                                <p class="text-xl font-bold text-gray-800">#{{ $order->id }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Badges -->
                <div class="px-8 pt-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-sm text-gray-600">Order Status</span>
                            <div class="mt-1">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'confirmed' => 'bg-blue-100 text-blue-800',
                                        'processing' => 'bg-purple-100 text-purple-800',
                                        'shipped' => 'bg-indigo-100 text-indigo-800',
                                        'delivered' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                    $statusColor = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusColor }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <span class="text-sm text-gray-600">Payment Status</span>
                            <div class="mt-1">
                                @php
                                    $paymentColors = [
                                        'pending' => 'bg-red-100 text-red-800',
                                        'paid' => 'bg-green-100 text-green-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                    ];
                                    $paymentColor = $paymentColors[$order->payment_status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $paymentColor }}">
                                    {{ ucfirst($order->payment_status ?? 'Pending') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Info -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 p-8 dashed-border">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Order Date</p>
                        <p class="text-gray-800 font-medium">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Payment Method</p>
                        <p class="text-gray-800 font-medium">{{ ucfirst($order->payment_method) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Transaction ID</p>
                        <p class="text-gray-800 font-medium">{{ $order->transaction_id ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Delivery Type</p>
                        <p class="text-gray-800 font-medium">{{ $order->delivery_type ?? 'Standard' }}</p>
                    </div>
                </div>

                <!-- Customer & Delivery Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 dashed-border">

                    <!-- Customer Information -->
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-user mr-2 text-gray-500"></i> Customer Information
                        </h3>
                        <div class="space-y-3 text-sm">
                            <p><span class="text-gray-500">Name:</span> <strong>{{ $order->user?->name ?? 'N/A' }}</strong></p>
                            <p><span class="text-gray-500">Email:</span> <strong>{{ $order->user?->email ?? 'N/A' }}</strong></p>
                            <p><span class="text-gray-500">Phone:</span>
                                <strong>{{ $order->user?->delivery_address?->contact ?? $order->user?->phone ?? 'N/A' }}</strong>
                            </p>
                        </div>
                    </div>

                    <!-- Delivery Address -->
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i> Delivery Address
                        </h3>
                        @php
                            $delivery = $order->user?->delivery_address;
                        @endphp
                        @if($delivery)
                            <div class="text-sm space-y-2">
                                <p><span class="text-gray-500">Address:</span> <strong>{{ $delivery->address_detail ?? 'N/A' }}</strong></p>
                                <p><span class="text-gray-500">Contact:</span> <strong>{{ $delivery->contact ?? 'N/A' }}</strong></p>
                            </div>
                        @else
                            <p class="text-red-600 text-sm">No delivery address provided</p>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div class="p-8">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-shopping-bag mr-2 text-gray-500"></i> Order Items
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Product</th>
                                    <th class="text-center py-3 px-4 text-sm font-semibold text-gray-600">Variant</th>
                                    <th class="text-center py-3 px-4 text-sm font-semibold text-gray-600">Quantity</th>
                                    <th class="text-center py-3 px-4 text-sm font-semibold text-gray-600">Unit Price</th>
                                    <th class="text-right py-3 px-4 text-sm font-semibold text-gray-600">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    @php
                                        $imageUrl = null;
                                        if ($item->productVarient && $item->productVarient->image) {
                                            $imageData = $item->productVarient->image;
                                            if (is_string($imageData)) {
                                                $imageData = json_decode($imageData, true);
                                            }
                                            if (is_array($imageData) && count($imageData) > 0) {
                                                $imageUrl = $imageData[0];
                                            } elseif (is_string($imageData)) {
                                                $imageUrl = $imageData;
                                            }
                                        }
                                    @endphp
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-3">
                                                <img src="{{ $imageUrl ? asset('storage/' . $imageUrl) : 'https://placehold.co/60x60/e2e8f0/64748b?text=No+Image' }}"
                                                     alt="{{ $item->product->name ?? 'Product' }}"
                                                     class="w-12 h-12 rounded-lg object-cover">
                                                <div>
                                                    <p class="font-medium text-gray-800">{{ $item->product->name ?? 'Product' }}</p>
                                                    @if($item->productVarient && $item->productVarient->title)
                                                        <p class="text-xs text-gray-500">{{ $item->productVarient->title }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center py-4 px-4 text-gray-600">
                                            {{ $item->productVarient->title ?? 'Standard' }}
                                        </td>
                                        <td class="text-center py-4 px-4">
                                            <span class="inline-flex items-center justify-center px-2 py-1 bg-gray-100 rounded">
                                                {{ $item->qty }}
                                            </span>
                                        </td>
                                        <td class="text-center py-4 px-4 text-gray-700">
                                            NPR {{ number_format($item->amount, 2) }}
                                        </td>
                                        <td class="text-right py-4 px-4 font-semibold text-gray-800">
                                            NPR {{ number_format($item->amount * $item->qty, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr class="border-t border-gray-200">
                                    <td colspan="4" class="text-right py-3 px-4 font-medium text-gray-700">Subtotal:</td>
                                    <td class="text-right py-3 px-4 font-semibold text-gray-800">
                                        NPR {{ number_format($order->orderItems->sum(fn($item) => $item->amount * $item->qty), 2) }}
                                    </td>
                                </tr>
                                @if($order->delivery_charge)
                                <tr>
                                    <td colspan="4" class="text-right py-2 px-4 text-gray-600">Delivery Charge:</td>
                                    <td class="text-right py-2 px-4 text-gray-700">
                                        NPR {{ number_format($order->delivery_charge, 2) }}
                                    </td>
                                </tr>
                                @endif
                                @if($order->discount_amount)
                                <tr>
                                    <td colspan="4" class="text-right py-2 px-4 text-gray-600">Discount:</td>
                                    <td class="text-right py-2 px-4 text-red-600">
                                        - NPR {{ number_format($order->discount_amount, 2) }}
                                    </td>
                                </tr>
                                @endif
                                <tr class="border-t-2 border-gray-300">
                                    <td colspan="4" class="text-right py-3 px-4 text-lg font-bold text-gray-800">Total:</td>
                                    <td class="text-right py-3 px-4 text-xl font-bold text-green-600">
                                        NPR {{ number_format($order->total_amount, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Order Notes -->
                @if($order->notes)
                <div class="px-8 pb-6">
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                        <p class="text-sm text-yellow-700">
                            <strong>Order Notes:</strong> {{ $order->notes }}
                        </p>
                    </div>
                </div>
                @endif

                <!-- Footer -->
                <div class="border-t border-gray-200 p-8 text-center text-gray-500 text-sm">
                    <p>Thank you for choosing Nanglo Pasal!</p>
                    <p class="mt-1">For any queries, please contact us at support@nanglopal.com or call 01-1234567</p>
                    <p class="mt-2 text-xs">This is a computer generated receipt. No signature required.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
