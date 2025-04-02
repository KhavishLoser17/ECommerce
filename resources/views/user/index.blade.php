@extends('layouts.app')
@section('content')
<div class="main-content-inner w-full px-10 py-6 bg-gray-50">

    <div class="main-content-wrap max-w-25xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header with Breadcrumb -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-5 border-b border-gray-200 mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Track Your Order</h1>
            <nav class="flex mt-2 sm:mt-0" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <div class="text-2xl font-semibold text-gray-700"></div>
                    </li>
                    <li class="flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </li>
                    <li>
                        <div class="text-xl font-semibold text-gray-700">Order Tracking</div>
                    </li>
                </ol>
            </nav>
        </div>
        <!-- Order Search Section -->
        <div class="w-full mx-auto bg-white shadow-lg rounded-lg overflow-hidden p-6">
            <div class="flex flex-col md:flex-row">
                <!-- Order Information (Main Section) -->
                @if(session('error'))
                <div class="bg-red-500 text-white p-3 rounded-md mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if(isset($order))
            <div class="flex-grow">
                <div class="border-b border-gray-300 pb-4 flex justify-between items-center">
                    <h2 class="text-3xl font-bold text-black">Order Information</h2>
                </div>

                <div class="pt-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div>
                            <h3 class="font-bold text-black uppercase text-xl">Order Details</h3>
                            <div class="border-t border-gray-300">
                                <dl>
                                    <div class="py-1 flex items-center space-x-2">
                                        <dt class="text-xl text-gray-600">Order Number:</dt>
                                        <dd class="text-xl text-black font-medium">{{ $order->order_number }}</dd>
                                    </div>

                                    <div class="py-1 flex items-center space-x-2">
                                        <dt class="text-xl text-gray-600">Ordered Date:</dt>
                                        <dd class="text-xl text-black">{{ \Carbon\Carbon::parse($order->order_date)->format('F j, Y') }}</dd>
                                    </div>

                                    <div class="py-1 flex items-center space-x-2">
                                        <dt class="text-xl text-gray-600">Claim your Order at:</dt>
                                        <dd class="text-xl text-black">{{ $claimDate }}</dd>
                                    </div>
                                    <div class="py-1 flex items-center space-x-2">
                                        <dt class="text-xl text-gray-600">Proceed at Cashier:</dt>
                                        <span class="text-xl font-semibold capitalize
                                            {{ $order->status === 'Completed' ? 'text-green-500' : '' }}
                                            {{ $order->status === 'Rejected' ? 'text-red-500' : '' }}
                                            {{ $order->status === 'Cancelled' ? 'text-rose-500' : '' }}
                                            {{ $order->status === 'To receive' ? 'text-blue-500' : '' }}
                                            {{ !in_array($order->status, ['Completed', 'Rejected', 'Cancelled', 'To receive']) ? 'text-yellow-500' : '' }}">
                                            {{ $order->status }}
                                        </span>
                                    </div>

                                    @if($order->status === 'To receive')
                                        <div class="py-1 text-xl text-red-500 italic">
                                            <strong>NOTE:</strong> Pick up your item at the counter. Please present your Receipt and Order Number.
                                        </div>

                                        <!-- Received Item Button -->
                                        <div class="mt-4">
                                            <form id="received-form" action="{{ route('order.received', $order->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" id="received-btn" class="bg-green-600 text-white px-4 py-2 rounded-md">
                                                    Received Item
                                                </button>
                                            </form>
                                        </div>

                                    @endif

                                    <!-- Cancel Button -->
                                    @if($order->status === 'pending')
                                        <div class="mt-4">
                                            <form action="{{ route('order.cancel', $order->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md">
                                                    Cancel Order
                                                </button>
                                            </form>
                                        </div>
                                    @endif

                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @endif

                <!-- Track Your Order (Search Button Style) -->
                <div class="md:ml-4 mt-4 md:mt-0 md:w-auto">
                    <form action="{{ route('user.track.search') }}" method="GET" class="flex">
                        <div class="relative flex-grow">
                            <input
                                type="text"
                                name="order_number"
                                id="order-number"
                                class="w-full pl-4 pr-4 py-2 border border-gray-300 rounded-l-md focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none text-lg"
                                placeholder="Enter order number"
                                required
                            >
                        </div>

                        <button type="submit" class="bg-indigo-600 text-white px-4 rounded-r-md">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Progress Tracker -->
        {{-- <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <div class="px-6 py-6">
                <div class="relative">
                    <!-- Progress Bar with animation -->
                    <div class="overflow-hidden h-2 mb-8 flex rounded bg-gray-200">
                        <div id="progress-bar"
                             class="bg-indigo-600 transition-all duration-500"
                             style="width: {{ $progressPercentage ?? 0 }}%">
                        </div>
                    </div>

                    <!-- Progress Steps -->
                    <div class="flex justify-between w-full mb-6">
                        <!-- Create connecting lines -->
                        <div class="absolute top-0 left-0 right-0 flex justify-between z-0">
                            <div class="w-1/3 h-2 -mt-10">
                                <div class="h-0.5 w-full bg-gray-300 mt-5 {{ $progressPercentage >= 25 ? 'bg-indigo-600' : '' }}"></div>
                            </div>
                            <div class="w-1/3 h-2 -mt-10">
                                <div class="h-0.5 w-full bg-gray-300 mt-5 {{ $progressPercentage >= 50 ? 'bg-indigo-600' : '' }}"></div>
                            </div>
                            <div class="w-1/3 h-2 -mt-10">
                                <div class="h-0.5 w-full bg-gray-300 mt-5 {{ $progressPercentage == 100 ? 'bg-indigo-600' : '' }}"></div>
                            </div>
                        </div>

                        <!-- Order Placed -->
                        <div class="text-center z-10">
                            <div class="w-10 h-10 mx-auto rounded-full {{ $progressPercentage >= 25 ? 'bg-indigo-600' : 'bg-gray-300' }} flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="text-lg font-medium text-gray-900 mt-2">Order Placed</div>
                        </div>

                        <!-- Confirming Receipt -->
                        <div class="text-center z-10">
                            <div class="w-10 h-10 mx-auto rounded-full {{ $progressPercentage >= 50 ? 'bg-indigo-600' : 'bg-gray-300' }} flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="text-lg font-medium text-gray-900 mt-2">Confirming Receipt</div>
                        </div>

                        <!-- Completed -->
                        <div class="text-center z-10">
                            <div class="w-10 h-10 mx-auto rounded-full {{ $progressPercentage == 100 ? 'bg-indigo-600' : 'bg-gray-300' }} flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="text-lg font-medium text-gray-900 mt-2">Completed</div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>
<script>
    document.getElementById('received-btn').addEventListener('click', function () {
        Swal.fire({
            title: 'Have you received your item?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4CAF50',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, I have!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('received-form').submit();
            }
        });
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}"
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}"
        });
    @endif
</script>
@endsection
