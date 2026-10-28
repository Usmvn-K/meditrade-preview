<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.app_orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items', 'user');
        return view('admin.app_orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:unpaid,paid,refunded',
        ]);

        $oldStatus = $order->status;
        $order->update($validated);

        if ($request->status === 'confirmed' && $oldStatus !== 'confirmed') {
            $recipientEmail = $order->customer_email ?? $order->email ?? $order->user->email ?? null;
            if ($recipientEmail) {
                try {
                    // Send notification if applicable
                    \Illuminate\Support\Facades\Log::info('Order confirmed for: ' . $recipientEmail);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Order Confirmation Mail failed: ' . $e->getMessage());
                }
            }
        }

        return back()->with('success', 'Order status updated successfully.');
    }
}
