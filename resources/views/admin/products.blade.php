    @extends('layouts.admin')
    @section('content')


        <div class="main-content-inner">
            <div class="main-content-wrap">
                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                    <h3 class="text-2xl font-semibold text-gray-700">All Products</h3>
                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                        <li>
                            <a href="{{{route('admin.index')}}}">
                                <div class="text-2xl font-semibold text-gray-700">Dashboard</div>
                            </a>
                        </li>
                        <li>
                            <i class="icon-chevron-right"></i>
                        </li>
                        <li>
                            <div class="text-2xl font-semibold text-gray-700">All Products</div>
                        </li>
                    </ul>
                </div>

                <div class="wg-box">
                    <div class="flex items-center justify-between gap10 flex-wrap">
                        <div class="wg-filter flex-grow">
                            <form class="form-search" method="GET" action="{{ route('admin.products.search') }}">
                                <fieldset class="name">
                                    <input type="text"
                                        placeholder="Search by Product ID, Name, or Type..."
                                        name="search"
                                        value="{{ request('search') }}">
                                </fieldset>

                                <div class="button-submit">
                                    <button type="submit"><i class="icon-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <a class="tf-button style-1 w208" href="javascript:void(0);" onclick="openModal()">
                            <i class="icon-plus"></i> Add Product
                        </a>
                    </div>
                    <div class="table-responsive">
                        @if(Session::has('status'))
                            <p class="alert alert-success">{{ Session::get('status') }}</p>
                        @endif
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Type</th>
                                    <th>Stock Status</th>
                                    <th>Sizes (S - XXL)</th>
                                    <th>Quantity</th>
                                    <th>Email Stocks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <!-- Inside your foreach loop, add this to the end of each row -->
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->product_name }}</td>
                                <td class="text-center">
                                    <a href="{{ asset('storage/' . $product->main_image) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $product->main_image) }}"
                                            alt="{{ $product->product_name }}"
                                            class="w-25 h-25 object-cover rounded-md mx-auto">
                                    </a>
                                </td>
                                <td>₱{{ number_format($product->price, 2) }}</td>
                                <td>{{ $product->course_uniform ?? 'N/A' }}</td>
                                <td>
                                    @php
                                        $totalStock = $product->size_s + $product->size_m + $product->size_l +
                                                        $product->size_xl + $product->size_xxl;
                                    @endphp

                                    @if($totalStock == 0)
                                        <span class="text-red-500">Out of Stock</span>
                                    @elseif($totalStock < 5)
                                        <span class="text-orange-500">Critical Level</span>
                                    @else
                                        <span class="text-green-500">In Stock</span>
                                    @endif

                                    @if($product->quantity < 300)
                                        <br>
                                        <span class="text-yellow-500 font-bold">Low Quantity Warning: {{ $product->quantity }}</span>
                                    @endif
                                </td>

                                <td>
                                    S: {{ $product->size_s ?? 0 }} |
                                    M: {{ $product->size_m ?? 0 }} |
                                    L: {{ $product->size_l ?? 0 }} |
                                    XL: {{ $product->size_xl ?? 0 }} |
                                    XXL: {{ $product->size_xxl ?? 0 }}
                                </td>
                                <td>{{ $product->quantity}}</td>
                                <td>

                                    <button class="bg-green-300 btn-lg" onclick="request()">Request Stock</button>

                                </td>
                                <td class="relative">
                                    <div class="flex space-x-2">
                                        <!-- Edit Button -->
                                        <button type="button"
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded text-xs flex items-center"
                                                onclick="openEditModal({{ $product->id }})">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-5 py-3 rounded text-xs flex items-center"
                                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                                <i class="fas fa-trash-alt mr-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    </div>
                </div>
            </div>
        </div>

        <div id="productModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white w-full max-w-6xl p-10 rounded-lg shadow-3xl">
                <h2 class="text-3xl font-bold mb-6">Add New Product</h2>

                <form id="addProductForm" enctype="multipart/form-data" method="POST" action="{{ route('products.store') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Product ID</label>
                            <input type="text" name="product_id" class="w-full px-4 py-2 border rounded-lg" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Product Name</label>
                            <input type="text" name="product_name" class="w-full px-4 py-2 border rounded-lg" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Category</label>
                            <select name="course_uniform" id="course_uniform" class="w-full px-4 py-2 border rounded-lg" required onchange="toggleFields()">
                                <option value="">Select Type</option>
                                <option value="School Uniform">School Uniform</option>
                                <option value="Booklets">Booklets</option>
                                <option value="School Supplies">School Supplies</option>
                                <option value="Books">Books</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Price</label>
                            <input type="number" name="price" class="w-full px-4 py-2 border rounded-lg" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">Description</label>
                            <textarea name="description" class="w-full px-4 py-2 border rounded-lg h-24"></textarea>
                        </div>

                        <!-- Sizes (Visible only if 'School Uniform' is selected) -->
                        <div class="md:col-span-2" id="sizeFields" style="display: none;">
                            <label class="block text-gray-700 font-semibold mb-2">Sizes (S - XXL)</label>
                            <div class="grid grid-cols-5 gap-2">
                                <input type="number" name="size_s" placeholder="S" class="w-full px-2 py-1 border rounded-lg">
                                <input type="number" name="size_m" placeholder="M" class="w-full px-2 py-1 border rounded-lg">
                                <input type="number" name="size_l" placeholder="L" class="w-full px-2 py-1 border rounded-lg">
                                <input type="number" name="size_xl" placeholder="XL" class="w-full px-2 py-1 border rounded-lg">
                                <input type="number" name="size_xxl" placeholder="XXL" class="w-full px-2 py-1 border rounded-lg">
                            </div>
                        </div>

                        <!-- Quantity (Visible only if NOT 'School Uniform') -->
                        <div class="md:col-span-2" id="quantityField" style="display: none;">
                            <label class="block text-gray-700 font-semibold mb-2">Quantity</label>
                            <input type="number" name="quantity" class="w-full px-4 py-2 border rounded-lg">
                        </div>

                        <div class="w-full">
                            <label class="block text-gray-700 font-semibold mb-2">Main Image <span class="text-red-500">*</span></label>
                            <div id="mainImageDrop" class="border-2 border-dashed border-gray-300 rounded-lg p-4 flex flex-col items-center justify-center cursor-pointer bg-gray-100 hover:bg-gray-200 transition">
                                <span class="text-gray-500">Drag & drop or click to upload</span>
                                <input type="file" name="main_image" accept="image/*" class="hidden" id="mainImageInput" required>
                            </div>
                            <img id="mainImagePreview" class="mt-3 hidden w-32 h-32 object-cover rounded-lg shadow" />
                        </div>

                        <div class="w-full">
                            <label class="block text-gray-700 font-semibold mb-2">Gallery Images (Min. 2)</label>
                            <div id="galleryDrop" class="border-2 border-dashed border-gray-300 rounded-lg p-4 flex flex-col items-center justify-center cursor-pointer bg-gray-100 hover:bg-gray-200 transition">
                                <span class="text-gray-500">Drag & drop or click to upload</span>
                                <input type="file" name="gallery_images[]" accept="image/*" multiple class="hidden" id="galleryInput" required>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Upload at least 2 images. The first image will be the featured one.</p>
                            <div id="galleryPreview" class="mt-3 flex gap-2 flex-wrap"></div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="button" class="bg-gray-400 text-white px-6 py-2 rounded-lg mr-3" onclick="closeModal()">Cancel</button>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Add Product</button>
                    </div>
                </form>
            </div>
        </div>


        <div id="requestModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white p-8 rounded-2xl w-full max-w-2xl shadow-lg">
                <h2 class="text-3xl font-bold mb-4 text-center">Request Stock</h2>

                <form method="POST" action="{{ route('send.request') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Supplier Dropdown -->
                    <div class="mb-4">
                        <label for="supplier" class="block text-2xl font-medium">Supplier</label>
                        <select name="supplier" id="supplier" class="w-full border p-2 rounded text-2xl" required>
                            <option value="precisionthreads5@gmail.com">Precision Threads</option>
                            <option value="scholarschoicesupplies@gmail.com">Scholar's Choice Supplies</option>
                            <option value="BookletHubPrintingCo@gmail.com">BookletHub Printing Co.</option>
                            <option value="nationalbookstore96@gmail.com">National Bookstore</option>
                        </select>
                    </div>

                    <!-- Custom Email Field -->
                    <div class="mb-4">
                        <label for="custom_email" class="block text-2xl font-medium">Email</label>
                        <input type="email" name="custom_email" id="custom_email" class="w-full border p-2 rounded text-2xl" placeholder="Enter Email address">
                        <p class="text-sm text-gray-500 mt-1">If provided, request will be sent to this email instead of the selected supplier.</p>
                    </div>

                    <!-- Product Name -->
                    <div class="mb-4">
                        <label for="product_name" class="block text-2xl font-medium">Product Name</label>
                        <select name="product_name" id="product_name" class="w-full border p-2 rounded text-2xl" required onchange="toggleQuantityInput()">
                            <option value="" disabled selected>Select a product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->product_name }}">{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Quantity (Default) -->
                    <div class="mb-4" id="quantityDiv">
                        <label for="quantity" class="block text-2xl font-medium">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="w-full border p-2 rounded text-2xl">
                    </div>

                    <!-- Sizes (Hidden by Default) -->
                    <div class="mb-4 hidden" id="sizeDiv">
                        <label class="block text-2xl font-medium">Size</label>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="size_s" class="block text-sm font-medium">Small (S)</label>
                                <input type="number" name="size_s" id="size_s" class="w-full border p-2 rounded text-3xl" min="0" placeholder="0">
                            </div>

                            <div>
                                <label for="size_m" class="block text-sm font-medium">Medium (M)</label>
                                <input type="number" name="size_m" id="size_m" class="w-full border p-2 rounded text-3xl" min="0" placeholder="0">
                            </div>

                            <div>
                                <label for="size_l" class="block text-sm font-medium">Large (L)</label>
                                <input type="number" name="size_l" id="size_l" class="w-full border p-2 rounded text-3xl" min="0" placeholder="0">
                            </div>

                            <div>
                                <label for="size_xl" class="block text-sm font-medium">Extra Large (XL)</label>
                                <input type="number" name="size_xl" id="size_xl" class="w-full border p-2 rounded text-3xl" min="0" placeholder="0">
                            </div>

                            <div>
                                <label for="size_xxl" class="block text-sm font-medium">Double Extra Large (XXL)</label>
                                <input type="number" name="size_xxl" id="size_xxl" class="w-full border p-2 rounded text-2xl" min="0" placeholder="0">
                            </div>
                        </div>
                    </div>

                    <!-- Note / Special Instructions -->
                    <div class="mb-4">
                        <label for="note" class="block text-2xl font-medium">Note </label>
                        <textarea name="note" id="note" class="w-full border p-2 rounded text-2xl" rows="3" placeholder="e.g., Deliver by Friday or urgent order."></textarea>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" class="bg-red-400 px-4 py-2 rounded" onclick="exit()">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Send Request</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Add this modal after your existing productModal div -->
    <div id="editProductModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white w-full max-w-6xl p-10 rounded-lg shadow-3xl">
            <h2 class="text-3xl font-bold mb-6">Edit Product</h2>

            <form id="editProductForm" enctype="multipart/form-data" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_product_id" name="id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Product ID</label>
                        <input type="text" id="edit_product_id_field" name="product_id" class="w-full px-4 py-2 border rounded-lg" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Product Name</label>
                        <input type="text" id="edit_product_name" name="product_name" class="w-full px-4 py-2 border rounded-lg" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Category</label>
                        <select name="course_uniform" id="edit_course_uniform" class="w-full px-4 py-2 border rounded-lg" required onchange="toggleEditFields()">
                            <option value="">Select Type</option>
                            <option value="School Uniform">School Uniform</option>
                            <option value="Booklets">Booklets</option>
                            <option value="School Supplies">School Supplies</option>
                            <option value="Books">Books</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Price</label>
                        <input type="number" id="edit_price" name="price" class="w-full px-4 py-2 border rounded-lg" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-semibold mb-2">Description</label>
                        <textarea id="edit_description" name="description" class="w-full px-4 py-2 border rounded-lg h-24"></textarea>
                    </div>

                    <!-- Sizes (Visible only if 'School Uniform' is selected) -->
                    <div class="md:col-span-2" id="edit_sizeFields">
                        <label class="block text-gray-700 font-semibold mb-2">Sizes (S - XXL)</label>
                        <div class="grid grid-cols-5 gap-2">
                            <input type="number" id="edit_size_s" name="size_s" placeholder="S" class="w-full px-2 py-1 border rounded-lg">
                            <input type="number" id="edit_size_m" name="size_m" placeholder="M" class="w-full px-2 py-1 border rounded-lg">
                            <input type="number" id="edit_size_l" name="size_l" placeholder="L" class="w-full px-2 py-1 border rounded-lg">
                            <input type="number" id="edit_size_xl" name="size_xl" placeholder="XL" class="w-full px-2 py-1 border rounded-lg">
                            <input type="number" id="edit_size_xxl" name="size_xxl" placeholder="XXL" class="w-full px-2 py-1 border rounded-lg">
                        </div>
                    </div>

                    <!-- Quantity (Visible only if NOT 'School Uniform') -->
                    <div class="md:col-span-2" id="edit_quantityField">
                        <label class="block text-gray-700 font-semibold mb-2">Quantity</label>
                        <input type="number" id="edit_quantity" name="quantity" class="w-full px-4 py-2 border rounded-lg">
                    </div>

                    <div class="w-full">
                        <label class="block text-gray-700 font-semibold mb-2">Main Image</label>
                        <div class="flex items-center space-x-4">
                            <img id="current_main_image" class="w-24 h-24 object-cover rounded-lg shadow" />
                            <div id="edit_mainImageDrop" class="border-2 border-dashed border-gray-300 rounded-lg p-4 flex flex-col items-center justify-center cursor-pointer bg-gray-100 hover:bg-gray-200 transition flex-grow">
                                <span class="text-gray-500">Upload new image (optional)</span>
                                <input type="file" name="main_image" accept="image/*" class="hidden" id="edit_mainImageInput">
                            </div>
                        </div>
                        <img id="edit_mainImagePreview" class="mt-3 hidden w-32 h-32 object-cover rounded-lg shadow" />
                    </div>

                    <div class="w-full">
                        <label class="block text-gray-700 font-semibold mb-2">Gallery Images</label>
                        <div id="current_gallery_images" class="flex flex-wrap gap-2 mb-3"></div>
                        <div id="edit_galleryDrop" class="border-2 border-dashed border-gray-300 rounded-lg p-4 flex flex-col items-center justify-center cursor-pointer bg-gray-100 hover:bg-gray-200 transition flex-grow">
                            <span class="text-gray-500">Click here to upload new image (optional)</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <input type="file" name="gallery_images[]" accept="image/*" multiple class="hidden" id="edit_galleryInput">
                        </div>
                        <div id="edit_galleryPreview" class="mt-3 flex gap-2 flex-wrap"></div>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="button" class="bg-gray-400 text-white px-6 py-2 rounded-lg mr-3" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Update Product</button>
                </div>
            </form>
        </div>
    </div>


        <script>
    // Function to toggle fields based on product type in add modal
    function toggleFields() {
        const productType = document.getElementById('course_uniform').value;
        const sizeFields = document.getElementById('sizeFields');
        const quantityField = document.getElementById('quantityField');

        if (productType === 'School Uniform') {
            sizeFields.style.display = 'block';
            quantityField.style.display = 'none';
        } else {
            sizeFields.style.display = 'none';
            quantityField.style.display = 'block';
        }
    }

    // Function to toggle fields in edit modal
    function toggleEditFields() {
        const productType = document.getElementById('edit_course_uniform').value;
        const sizeFields = document.getElementById('edit_sizeFields');
        const quantityField = document.getElementById('edit_quantityField');

        if (productType === 'School Uniform') {
            sizeFields.style.display = 'block';
            quantityField.style.display = 'none';
        } else {
            sizeFields.style.display = 'none';
            quantityField.style.display = 'block';
        }
    }

    // Function to open the add product modal
    function openModal() {
        document.getElementById('productModal').classList.remove('hidden');
    }

    // Function to close the add product modal
    function closeModal() {
        document.getElementById('productModal').classList.add('hidden');
    }

    // Function to open the edit product modal
    function openEditModal(productId) {
        // Set the form action URL with the product ID
        document.getElementById('editProductForm').action = `/products/${productId}`;

        // Fetch product data using AJAX
        fetch(`/products/${productId}/edit`)
            .then(response => response.json())
            .then(data => {
                // Populate the form fields with product data
                document.getElementById('edit_product_id').value = data.id;
                document.getElementById('edit_product_id_field').value = data.product_id;
                document.getElementById('edit_product_name').value = data.product_name;
                document.getElementById('edit_course_uniform').value = data.course_uniform;
                document.getElementById('edit_price').value = data.price;
                document.getElementById('edit_description').value = data.description;

                // Set size fields if available
                document.getElementById('edit_size_s').value = data.size_s || '';
                document.getElementById('edit_size_m').value = data.size_m || '';
                document.getElementById('edit_size_l').value = data.size_l || '';
                document.getElementById('edit_size_xl').value = data.size_xl || '';
                document.getElementById('edit_size_xxl').value = data.size_xxl || '';

                // Set quantity if available
                document.getElementById('edit_quantity').value = data.quantity || '';

                // Toggle fields based on product type
                toggleEditFields();

                // Show current main image
                const currentMainImage = document.getElementById('current_main_image');
                currentMainImage.src = `/storage/${data.main_image}`;

                // Show current gallery images
                const galleryContainer = document.getElementById('current_gallery_images');
                galleryContainer.innerHTML = '';

                if (data.gallery_images && data.gallery_images.length > 0) {
                    data.gallery_images.forEach(imagePath => {
                        const imgContainer = document.createElement('div');
                        imgContainer.className = 'relative';

                        const img = document.createElement('img');
                        img.src = `/storage/${imagePath}`;
                        img.className = 'w-20 h-20 object-cover rounded-lg shadow';

                        imgContainer.appendChild(img);
                        galleryContainer.appendChild(imgContainer);
                    });
                }

                // Show the modal
                document.getElementById('editProductModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching product:', error);
                alert('Failed to load product information');
            });
    }

    // Function to close the edit product modal
    function closeEditModal() {
        document.getElementById('editProductModal').classList.add('hidden');

        // Reset form and previews
        document.getElementById('editProductForm').reset();
        document.getElementById('edit_mainImagePreview').classList.add('hidden');
        document.getElementById('edit_galleryPreview').innerHTML = '';
    }

    // File upload preview functionality
    function setupFileUploadPreviews() {
        // Main image upload for edit product
        const editMainImageDrop = document.getElementById('edit_mainImageDrop');
        const editMainImageInput = document.getElementById('edit_mainImageInput');
        const editMainImagePreview = document.getElementById('edit_mainImagePreview');

        if (editMainImageDrop && editMainImageInput && editMainImagePreview) {
            // Make sure the whole drop area is clickable
            editMainImageDrop.addEventListener('click', function(e) {
                e.preventDefault();
                editMainImageInput.click();
            });

            editMainImageInput.addEventListener('change', function() {
                if (this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        editMainImagePreview.src = e.target.result;
                        editMainImagePreview.classList.remove('hidden');
                    }

                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

        // Gallery images upload for edit product
        const editGalleryDrop = document.getElementById('edit_galleryDrop');
        const editGalleryInput = document.getElementById('edit_galleryInput');
        const editGalleryPreview = document.getElementById('edit_galleryPreview');

        if (editGalleryDrop && editGalleryInput && editGalleryPreview) {
            // Make sure the whole drop area is clickable
            editGalleryDrop.addEventListener('click', function(e) {
                e.preventDefault();
                editGalleryInput.click();
            });

            editGalleryInput.addEventListener('change', function() {
                editGalleryPreview.innerHTML = '';

                if (this.files.length > 0) {
                    Array.from(this.files).forEach(file => {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            const imgContainer = document.createElement('div');
                            imgContainer.className = 'relative';

                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'w-20 h-20 object-cover rounded-lg shadow';

                            imgContainer.appendChild(img);
                            editGalleryPreview.appendChild(imgContainer);
                        }

                        reader.readAsDataURL(file);
                    });
                }
            });
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        setupFileUploadPreviews();

        // Add event listener for form submission
        document.getElementById('editProductForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            let formData = new FormData(this);
            let productId = document.getElementById('edit_product_id').value;

            fetch(`/products/${productId}`, {
                method: 'POST', // Change this if using PUT
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Product updated successfully!',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = "/admin/products"; // Force redirect
                    });
                }
            })
            .catch(error => {
                console.error('Error updating product:', error);
                alert('Failed to update product.');
            });
        });
    });

        </script>


        <script>
            document.getElementById("supplier").addEventListener("change", function() {
                document.getElementById("custom_email").value = this.value;
            });
        </script>

        <script>
            function openModal() {
                document.getElementById('productModal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('productModal').classList.add('hidden');
            }

            function toggleFields() {
                const selectedOption = document.getElementById('course_uniform').value;
                const sizeFields = document.getElementById('sizeFields');
                const quantityField = document.getElementById('quantityField');

                sizeFields.style.display = selectedOption === 'School Uniform' ? 'block' : 'none';
                quantityField.style.display = selectedOption && selectedOption !== 'School Uniform' ? 'block' : 'none';
            }

            document.addEventListener('DOMContentLoaded', function () {
                const courseUniformDropdown = document.getElementById('course_uniform');
                if (courseUniformDropdown) {
                    courseUniformDropdown.addEventListener('change', toggleFields);
                    toggleFields(); // Initialize the correct fields on load
                }
            });
        </script>




            <script>
                document.getElementById("mainImageDrop").addEventListener("click", function () {
                    document.getElementById("mainImageInput").click();
                });

                document.getElementById("mainImageInput").addEventListener("change", function (event) {
                    let file = event.target.files[0];
                    if (file) {
                        let reader = new FileReader();
                        reader.onload = function (e) {
                            let imgPreview = document.getElementById("mainImagePreview");
                            imgPreview.src = e.target.result;
                            imgPreview.classList.remove("hidden");
                        };
                        reader.readAsDataURL(file);
                    }
                });

                document.getElementById("galleryDrop").addEventListener("click", function () {
                    document.getElementById("galleryInput").click();
                });

                document.getElementById("galleryInput").addEventListener("change", function (event) {
                    let files = event.target.files;
                    let galleryPreview = document.getElementById("galleryPreview");
                    galleryPreview.innerHTML = ""; // Clear previous previews

                    Array.from(files).forEach(file => {
                        let reader = new FileReader();
                        reader.onload = function (e) {
                            let img = document.createElement("img");
                            img.src = e.target.result;
                            img.classList.add("w-20", "h-20", "object-cover", "rounded-lg", "shadow");
                            galleryPreview.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    });
                });
            </script>
            <script>
                @if(session('swal_success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('swal_success') }}',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                @endif
            </script>

    <script>
        function request() {
            document.getElementById('requestModal').classList.remove('hidden');
        }

        function exit() {
            document.getElementById('requestModal').classList.add('hidden');
        }
    </script>
    <script>
        function toggleQuantityInput() {
            const productName = document.getElementById('product_name').value.toLowerCase();
            const quantityDiv = document.getElementById('quantityDiv');
            const sizeDiv = document.getElementById('sizeDiv');

            // If product name contains "uniform" or "clothing" or other apparel-related terms
            if (productName.includes('uniform') ||
                productName.includes('shirt') ||
                productName.includes('jersey') ||
                productName.includes('jacket') ||
                productName.includes('pants') ||
                productName.includes('clothing')) {

                quantityDiv.classList.add('hidden');
                sizeDiv.classList.remove('hidden');

                // Clear the regular quantity input
                document.getElementById('quantity').value = '';
            } else {
                quantityDiv.classList.remove('hidden');
                sizeDiv.classList.add('hidden');

                // Clear the size inputs
                document.getElementById('size_s').value = '';
                document.getElementById('size_m').value = '';
                document.getElementById('size_l').value = '';
                document.getElementById('size_xl').value = '';
                document.getElementById('size_xxl').value = '';
            }
        }

        function exit() {
            document.getElementById('requestModal').classList.add('hidden');
        }
        </script>
    @endsection
