@extends('layouts.app')
@section('content')

<div class="mb-md-1 pb-md-3 pt-20">
    <main class="container py-8">
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Product Images -->
            <div class="swiper-container max-w-3xl mx-auto">
                <div class="swiper-wrapper">
                    <!-- Main Image -->
                    @if(!empty($fetch->main_image))
                        <div class="swiper-slide flex justify-center items-center py-4">
                            <img loading="lazy" class="w-full max-w-md h-auto object-contain rounded-lg shadow-md"
                                 src="{{ Str::startsWith($fetch->main_image, 'storage/') ? asset($fetch->main_image) : Storage::url($fetch->main_image) }}"
                                 alt="{{ $fetch->product_name }}" />
                        </div>
                    @endif

                    @php
                        $galleryImages = is_string($fetch->gallery_images)
                                         ? json_decode($fetch->gallery_images, true)
                                         : ($fetch->gallery_images ?? []);
                    @endphp

                    <!-- Gallery Images -->
                    @if(!empty($galleryImages))
                        @foreach($galleryImages as $image)
                            @if(!empty($image))
                                <div class="swiper-slide flex justify-center items-center py-4">
                                    <img loading="lazy" class="w-full max-w-md h-auto object-contain rounded-lg shadow-md"
                                         src="{{ Str::startsWith($image, 'storage/') ? asset($image) : Storage::url($image) }}"
                                         alt="Gallery Image" />
                                </div>
                            @endif
                        @endforeach
                    @endif

                    <!-- Fallback if No Images Exist -->
                    @if(empty($fetch->main_image) && empty($galleryImages))
                        <div class="swiper-slide flex justify-center items-center py-4">
                            <p class="text-gray-500 italic">No images available.</p>
                        </div>
                    @endif
                </div>

                <!-- Swiper Controls -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-pagination"></div>
            </div>

            <!-- Product Details -->
            <div class="md:w-full p-6">
                <nav class="flex text-sm font-medium text-gray-500 mb-4">
                  <a href="#" class="hover:text-indigo-600 transition-colors">Home</a>
                  <span class="mx-2">/</span>
                  <a href="#" class="hover:text-indigo-600 transition-colors">Bestlink Shop</a>
                </nav>

                <h1 class="text-2xl sm:text-3xl font-semibold text-gray-900 mb-2">{{ $fetch->product_name }}</h1>

                <div class="flex items-center space-x-1 text-yellow-400 mb-4">
                    <i class="fas fa-star text-lg"></i>
                    <i class="fas fa-star text-lg"></i>
                    <i class="fas fa-star text-lg"></i>
                    <i class="fas fa-star text-lg"></i>
                    <i class="fas fa-star text-lg"></i>
                    <span class="ml-2 text-gray-600 text-lg font-medium">8k+ reviews</span>
                </div>

                <div class="text-2xl font-bold text-indigo-600 mb-4">₱{{ number_format($fetch->price, 2) }}</div>

                <div class="mb-6">
                    <form id="add-to-cart-form" action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Quantity</h3>
                        <div class="flex items-center">
                            <div class="flex border border-gray-300 rounded-md">
                                <button type="button" id="decreaseBtn"
                                        class="w-8 h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                                        onclick="changeQuantity(-1)" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                </button>
                                <input id="quantityInput" type="text" name="quantity"
                                       class="w-16 text-center text-lg border-l border-r border-gray-300 focus:outline-none"
                                       value="1" readonly>
                                <button type="button" id="increaseBtn"
                                        class="w-8 h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                                        onclick="changeQuantity(1)" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                            <div id="availableStock" class="ml-4 text-lg text-gray-600">Select a size to see availability</div>
                        </div>
                        <div class="bg-indigo-50 p-4 rounded-md mb-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Course Uniform</h3>
                            <p class="text-gray-600 text-xl">{{ $fetch->course_uniform }}</p>
                        </div>

                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-3">Available Sizes</h3>

                            @php
                                $sizes = [
                                    'S' => $fetch->size_s ?? 0,
                                    'M' => $fetch->size_m ?? 0,
                                    'L' => $fetch->size_l ?? 0,
                                    'XL' => $fetch->size_xl ?? 0,
                                    'XXL' => $fetch->size_xxl ?? 0,
                                ];
                            @endphp

                            @if(!empty(array_filter($sizes)))

                                <div class="flex flex-wrap gap-2">
                                    @foreach($sizes as $size => $qty)
                                        @if($qty > 0)
                                            <button type="button" onclick="selectSize('{{ $size }}', {{ $qty }})"
                                                    class="size-box px-4 py-2 border border-gray-300 rounded-md font-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:bg-gray-50 transition-colors">
                                                {{ $size }}
                                            </button>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 italic">No sizes available.</p>
                            @endif
                        </div>

                        </div>
                        <!-- Hidden Inputs -->
                        <input type="hidden" name="product_id" value="{{ $fetch->id }}">
                        <input type="hidden" name="size" id="selected-size">
                        <div class="flex flex-wrap gap-4 mt-6">
                            <button type="button" class="add-to-cart-btn px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xl rounded-md transition-colors duration-200 flex items-center"
                                    data-product-id="{{ $fetch->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Add to Cart
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
</div>
<script>
    let selectedStock = 0;

    // Handle size selection and update stock
    function selectSize(size, stock) {
        document.getElementById("availableStock").innerText = stock + " pieces available";
        selectedStock = stock;

        let quantityInput = document.getElementById("quantityInput");
        quantityInput.value = 1;

        document.getElementById("increaseBtn").disabled = stock <= 1;
        document.getElementById("decreaseBtn").disabled = true;

        // Store selected size in hidden input
        document.getElementById('selected-size').value = size;

        // Visual feedback for selected size
        document.querySelectorAll('.size-box').forEach(btn => {
            btn.classList.remove('bg-indigo-100', 'border-indigo-500');
        });
        event.target.classList.add('bg-indigo-100', 'border-indigo-500');
    }

    // Handle quantity change (increase/decrease)
    function changeQuantity(change) {
        let quantityInput = document.getElementById("quantityInput");
        let currentQty = parseInt(quantityInput.value) + change;

        if (currentQty > 0 && currentQty <= selectedStock) {
            quantityInput.value = currentQty;
            document.getElementById("decreaseBtn").disabled = currentQty <= 1;
            document.getElementById("increaseBtn").disabled = currentQty >= selectedStock;
        }
    }

    // Wait for document to be ready
    document.addEventListener('DOMContentLoaded', function() {
        // AJAX Setup for CSRF Token (using vanilla JS instead of jQuery)
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Handle Add to Cart Button Click
        document.querySelector('.add-to-cart-btn').addEventListener('click', function(e) {
            e.preventDefault(); // Prevent default form submission

            const productId = this.getAttribute('data-product-id'); // Get product ID from data attribute
            const size = document.getElementById('selected-size').value; // Get selected size from hidden input
            const quantity = document.getElementById('quantityInput').value; // Get quantity from input

            // Check if size is selected
            if (!size) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops!',
                    text: 'Please select a size before adding to cart.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Create form data
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('size', size);
            formData.append('quantity', quantity);
            formData.append('_token', csrfToken);

            // AJAX Request
            fetch(document.getElementById('add-to-cart-form').action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Reload the current page
                        window.location.href = '{{ route("cart") }}';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.error || 'Something went wrong.',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Something went wrong. Please try again.',
                    confirmButtonText: 'OK'
                });
                console.error('Error:', error);
            });
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        var swiper = new Swiper(".swiper-container", {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    });
</script>


@endsection
