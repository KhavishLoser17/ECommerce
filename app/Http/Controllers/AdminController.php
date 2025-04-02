<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Order;
use App\Models\DeliveryRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index(){
        return view ('admin.index');
    }
    public function product() {
        return view('admin.products');
    }
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|string',
            'product_name' => 'required|string',
            'course_uniform' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',

            // Conditional validation for size/quantity
            'size_s' => 'nullable|integer',
            'size_m' => 'nullable|integer',
            'size_l' => 'nullable|integer',
            'size_xl' => 'nullable|integer',
            'size_xxl' => 'nullable|integer',
            'quantity' => 'nullable|integer',

            // Image Validation
            'main_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'gallery_images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle main image upload
        $mainImagePath = $request->file('main_image')->store('products/main_images', 'public');

        // Handle gallery images upload
        $galleryImagePaths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $galleryImage) {
                $galleryImagePaths[] = $galleryImage->store('products/gallery', 'public');
            }
        }

        Product::create([
            'product_id' => $request->product_id,
            'product_name' => $request->product_name,
            'course_uniform' => $request->course_uniform,
            'price' => $request->price,
            'description' => $request->description,
            'size_s' => $request->size_s,
            'size_m' => $request->size_m,
            'size_l' => $request->size_l,
            'size_xl' => $request->size_xl,
            'size_xxl' => $request->size_xxl,
            'quantity' => $request->quantity,
            'main_image' => $mainImagePath,
            'gallery_images' => $galleryImagePaths
        ]);

        return redirect()->route('admin.products')->with('swal_success', 'Product added successfully!');
    }

    public function show() {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    public function order(){
        return view('admin.order');
    }
    public function track(){
        return view('admin.track');
    }

    public function supplier(){
        return view('admin.supplier');
    }
        public function supply()
    {
        $deliveryRequests = DeliveryRequest::with('product')->get();

        return view('admin.supplier', compact('deliveryRequests'));
    }
    public function approve($id)
{
    $deliveryRequest = DeliveryRequest::findOrFail($id);

    // Check if already in process
    if ($deliveryRequest->status === 'to_receive' || $deliveryRequest->status === 'received') {
        return redirect()->back()->with('info', 'This request is already in process.');
    }

    // Update delivery request status to "to_receive"
    $deliveryRequest->update(['status' => 'to_receive']);

    return redirect()->back()->with('success', 'Request approved. Ready to receive items.');
}

public function receive($id)
{
    $deliveryRequest = DeliveryRequest::findOrFail($id);

    // Check if already received
    if ($deliveryRequest->status === 'received') {
        return redirect()->back()->with('info', 'This request was already received.');
    }

    // Check if status is "to_receive"
    if ($deliveryRequest->status !== 'to_receive') {
        return redirect()->back()->with('error', 'Request must be in "To Receive" status first.');
    }

    // Find the product
    $product = Product::find($deliveryRequest->product_id);

    if (!$product) {
        return redirect()->back()->with('error', 'Product not found.');
    }

    DB::transaction(function () use ($deliveryRequest, $product) {
        // Update product inventory
        $product->size_s += $deliveryRequest->size_s;
        $product->size_m += $deliveryRequest->size_m;
        $product->size_l += $deliveryRequest->size_l;
        $product->size_xl += $deliveryRequest->size_xl;
        $product->size_xxl += $deliveryRequest->size_xxl;

        $totalQuantity = $deliveryRequest->size_s + $deliveryRequest->size_m +
                         $deliveryRequest->size_l + $deliveryRequest->size_xl +
                         $deliveryRequest->size_xxl;

        $product->quantity += $totalQuantity;
        $product->save();

        // Update delivery request status
        $deliveryRequest->update(['status' => 'received']);
    });

    return redirect()->back()->with('success', 'Items received and inventory updated successfully.');
}

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_cause' => 'required|string|max:255',
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $delivery = DeliveryRequest::findOrFail($id);
        $delivery->status = 'rejected';
        $delivery->rejection_cause = $request->rejection_cause;
        $delivery->rejection_reason = $request->rejection_reason;
        $delivery->save();

        return redirect()->back()->with('success', 'Delivery request rejected successfully.');
    }


    public function search(Request $request)
    {
        $query = Product::query();

        // Combined Search Logic
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('product_id', 'like', "%$searchTerm%")
                  ->orWhere('product_name', 'like', "%$searchTerm%")
                  ->orWhere('course_uniform', 'like', "%$searchTerm%");
            });
        }

        $products = $query->paginate(10);

        return view('admin.products', compact('products'));
    }

    public function forecast(){
        return view('admin.forecast');
    }

    public function demand()
    {
        // Forecasted metrics for KPI cards
        $forecastedRevenue = 4200000; // 4.2M in Pesos
        $revenueGrowthRate = 12.4;
        $forecastAccuracy = 92.5;
        $accuracyChange = 2.1;
        $stockReduction = 15;
        $inventorySavings = 320000; // 320K savings
        $riskFactorsCount = 3;
        $primaryRiskFactor = 'Supply chain disruptions';

        // Monthly forecast data
        $forecastMonths = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];

        // Sample actual and forecasted sales data
        $actualSales = [280000, 320000, 290000, 340000, 350000, 370000, null, null, null, null, null, null];
        $forecastedSales = [280000, 320000, 290000, 340000, 350000, 370000, 390000, 410000, 380000, 400000, 420000, 450000];

        // Product demand forecasts
        $productDemandForecasts = $this->getProductDemandForecasts();

        // Recommended orders
        $recommendedOrders = $this->getRecommendedOrders();

        // Seasonal trends
        $previousYearTrend = [220000, 240000, 260000, 280000, 270000, 290000, 310000, 340000, 300000, 320000, 350000, 370000];
        $currentYearTrend = [280000, 320000, 290000, 340000, 350000, 370000, 390000, 410000, 380000, 400000, 420000, 450000];

        return view('admin.forecast', compact(
            'forecastedRevenue',
            'revenueGrowthRate',
            'forecastAccuracy',
            'accuracyChange',
            'stockReduction',
            'inventorySavings',
            'riskFactorsCount',
            'primaryRiskFactor',
            'forecastMonths',
            'actualSales',
            'forecastedSales',
            'productDemandForecasts',
            'recommendedOrders',
            'previousYearTrend',
            'currentYearTrend'
        ));
    }

    /**
     * Get product demand forecasts with data from Product model
     */
    private function getProductDemandForecasts()
    {
        // Get products with their actual inventory levels
        $products = Product::all();

        $forecasts = [];
        foreach ($products as $product) {
            // Calculate total stock across all sizes if applicable
            $currentStock = $product->quantity;
            if ($product->size_s !== null || $product->size_m !== null ||
                $product->size_l !== null || $product->size_xl !== null ||
                $product->size_xxl !== null) {
                $currentStock = ($product->size_s ?? 0) + ($product->size_m ?? 0) +
                               ($product->size_l ?? 0) + ($product->size_xl ?? 0) +
                               ($product->size_xxl ?? 0);
            }


            $salesCount = Order::where('product_name', $product->product_name)->count();


            $forecastedDemand = $salesCount * 1.2;


            $reorderLevel = $forecastedDemand * 0.3;

            $forecasts[] = [
                'id' => $product->product_id,
                'name' => $product->product_name,
                'image' => $product->main_image,
                'currentStock' => $currentStock,
                'forecastedDemand' => ceil($forecastedDemand),
                'reorderLevel' => ceil($reorderLevel)
            ];
        }


        usort($forecasts, function($a, $b) {

            $ratioA = $a['currentStock'] / max(1, $a['reorderLevel']);
            $ratioB = $b['currentStock'] / max(1, $b['reorderLevel']);

            return $ratioA <=> $ratioB;
        });


        return array_slice($forecasts, 0, 5);
    }


    private function getRecommendedOrders()
    {

        $products = Product::all();
        $recommendedOrders = [];

        foreach ($products as $product) {

            $currentStock = $product->quantity;
            if ($product->size_s !== null || $product->size_m !== null ||
                $product->size_l !== null || $product->size_xl !== null ||
                $product->size_xxl !== null) {
                $currentStock = ($product->size_s ?? 0) + ($product->size_m ?? 0) +
                               ($product->size_l ?? 0) + ($product->size_xl ?? 0) +
                               ($product->size_xxl ?? 0);
            }


            $salesCount = Order::where('product_name', $product->product_name)->count();


            $forecastedDemand = $salesCount * 1.2;


            $reorderLevel = $forecastedDemand * 0.3;


            if ($currentStock < $reorderLevel) {

                $orderQuantity = ceil($forecastedDemand - $currentStock);


                $orderBy = now()->addDays(rand(7, 14))->format('M d, Y');

                if ($orderQuantity > 0) {
                    $recommendedOrders[] = [
                        'productName' => $product->product_name,
                        'image' => $product->main_image,
                        'category' => $product->course_uniform,
                        'quantity' => $orderQuantity,
                        'estimatedCost' => $orderQuantity * $product->price,
                        'orderBy' => $orderBy
                    ];
                }
            }
        }

        // Sort by urgency (order by date)
        usort($recommendedOrders, function($a, $b) {
            return strtotime($a['orderBy']) <=> strtotime($b['orderBy']);
        });

        // Only return the top 3 most urgent orders
        return array_slice($recommendedOrders, 0, 3);
    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'product_id' => 'required|string',
            'product_name' => 'required|string',
            'course_uniform' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'size_s' => 'nullable|integer',
            'size_m' => 'nullable|integer',
            'size_l' => 'nullable|integer',
            'size_xl' => 'nullable|integer',
            'size_xxl' => 'nullable|integer',
            'quantity' => 'nullable|integer',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = [
            'product_id' => $request->product_id,
            'product_name' => $request->product_name,
            'course_uniform' => $request->course_uniform,
            'price' => $request->price,
            'description' => $request->description,
        ];

        // Handle size fields or quantity based on product type
        if ($request->course_uniform === 'School Uniform') {
            $data['size_s'] = $request->size_s;
            $data['size_m'] = $request->size_m;
            $data['size_l'] = $request->size_l;
            $data['size_xl'] = $request->size_xl;
            $data['size_xxl'] = $request->size_xxl;
            $data['quantity'] = null;
        } else {
            $data['size_s'] = null;
            $data['size_m'] = null;
            $data['size_l'] = null;
            $data['size_xl'] = null;
            $data['size_xxl'] = null;
            $data['quantity'] = $request->quantity;
        }

        // Handle main image upload if a new one is provided
        if ($request->hasFile('main_image')) {
            // Delete the old image file if it exists
            if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
                Storage::disk('public')->delete($product->main_image);
            }

            $data['main_image'] = $request->file('main_image')->store('products/main_images', 'public');
        }

        // Handle gallery images upload if new ones are provided
        if ($request->hasFile('gallery_images')) {
            $galleryImagePaths = is_array($product->gallery_images) ? $product->gallery_images : [];

            // Add new images
            foreach ($request->file('gallery_images') as $galleryImage) {
                $galleryImagePaths[] = $galleryImage->store('products/gallery', 'public');
            }

            $data['gallery_images'] = $galleryImagePaths;
        }

        $product->update($data);

        return redirect()->route('admin.products')->with('swal_success', 'Product updated successfully!');

    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete the main image
        if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
            Storage::disk('public')->delete($product->main_image);
        }

        // Delete gallery images
        if ($product->gallery_images && is_array($product->gallery_images)) {
            foreach ($product->gallery_images as $galleryImage) {
                if (Storage::disk('public')->exists($galleryImage)) {
                    Storage::disk('public')->delete($galleryImage);
                }
            }
        }

        $product->delete();

        return redirect()->route('admin.products')->with('swal_success', 'Product deleted successfully!');

    }

}
