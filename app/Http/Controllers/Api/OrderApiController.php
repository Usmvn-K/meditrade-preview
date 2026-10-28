<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderApiController extends Controller
{
    /**
     * Place a new order
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items'            => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'shipping_name'    => 'required|string|max:255',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city'    => 'required|string|max:255',
            'payment_method'   => 'in:cod,stripe',
            'notes'            => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        return DB::transaction(function () use ($request) {
            $user = $request->user();
            $subtotal = 0;
            $orderItems = [];

            // Validate stock and calculate totals
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                
                if (!$product || $product->status !== 'active') {
                    return response()->json([
                        'message' => "Product '{$product->name}' is no longer available."
                    ], 400);
                }

                if ($product->stock_quantity < $item['quantity']) {
                    return response()->json([
                        'message' => "Not enough stock for '{$product->name}'. Only {$product->stock_quantity} left."
                    ], 400);
                }

                $price = $product->getCurrentPrice();
                $lineTotal = $price * $item['quantity'];
                $subtotal += $lineTotal;

                $orderItems[] = [
                    'product_id'    => $product->id,
                    'product_name'  => $product->name,
                    'product_price' => $price,
                    'quantity'      => $item['quantity'],
                    'line_total'    => $lineTotal,
                ];

                // Decrease stock
                $product->decrement('stock_quantity', $item['quantity']);
            }

            $shippingFee = 0; // Free shipping for now
            $total = $subtotal + $shippingFee;

            // Create the order
            $order = Order::create([
                'user_id'          => $user->id,
                'order_number'     => Order::generateOrderNumber(),
                'subtotal'         => $subtotal,
                'shipping_fee'     => $shippingFee,
                'total'            => $total,
                'status'           => 'pending',
                'payment_method'   => $request->payment_method ?? 'cod',
                'payment_status'   => 'unpaid',
                'shipping_name'    => $request->shipping_name,
                'shipping_phone'   => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city'    => $request->shipping_city,
                'notes'            => $request->notes,
            ]);

            // Attach items
            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }

            // Reload with items
            $order->load('items');

            return response()->json([
                'message' => 'Order placed successfully!',
                'order'   => $this->formatOrder($order),
            ], 201);
        });
    }

    /**
     * List orders for the authenticated user
     */
    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->get();

        $formatted = $orders->map(function ($order) {
            return $this->formatOrder($order);
        });

        return response()->json($formatted);
    }

    /**
     * Show a single order
     */
    public function show(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->with('items')
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($this->formatOrder($order));
    }

    /**
     * Format order for API response
     */
    private function formatOrder(Order $order): array
    {
        return [
            'id'              => $order->id,
            'order_number'    => $order->order_number,
            'subtotal'        => (float) $order->subtotal,
            'shipping_fee'    => (float) $order->shipping_fee,
            'total'           => (float) $order->total,
            'status'          => $order->status,
            'payment_method'  => $order->payment_method,
            'payment_status'  => $order->payment_status,
            'shipping_name'   => $order->shipping_name,
            'shipping_phone'  => $order->shipping_phone,
            'shipping_address'=> $order->shipping_address,
            'shipping_city'   => $order->shipping_city,
            'notes'           => $order->notes,
            'items'           => $order->items->map(function ($item) {
                return [
                    'id'            => $item->id,
                    'product_id'    => $item->product_id,
                    'product_name'  => $item->product_name,
                    'product_price' => (float) $item->product_price,
                    'quantity'      => $item->quantity,
                    'line_total'    => (float) $item->line_total,
                ];
            }),
            'created_at' => $order->created_at->toDateTimeString(),
        ];
    }
}
