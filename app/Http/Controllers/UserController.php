<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index(){
        return view ('user.index');
    }
    public function shop(){
        return view ('shop');
    }
    public function details(){
        return view ('details');
    }

    public function cart()
    {
        $products = Product::paginate(6);
        return view('shop', compact('products'));
    }
    public function fetch($id)
    {
        $fetch = Product::findOrFail($id);
        return view('details', compact('fetch')); // Updated view path
    }
    public function trackOrder(Request $request)
    {
        $order = null;
        $claimDate = null;
        $status = 'Pending';
        $progressPercentage = 0; // Ensures default value

        $orderNumber = $request->get('order_number');

        if ($orderNumber) {
            $order = Order::where('order_number', $orderNumber)->first();

            if (!$order) {
                return redirect()->route('user.track')->with('error', 'Order not found.');
            }

            // Handle claim date logic
            $claimDate = Carbon::parse($order->order_date)->addDay();

            // Skip Sunday logic
            if ($claimDate->isSunday()) {
                $claimDate->addDay();
            }

            $claimDate = $claimDate->format('M d, Y');

            // Handle progress logic
            $status = $order->status ?? 'Pending';
            $progressPercentage = match (strtolower($status)) {
                'pending' => 25,
                'to receive' => 60,
                'completed' => 100,
                default => 0
            };
        }

        return view('user.index', compact('order', 'claimDate', 'status', 'progressPercentage'));
    }
    



}
