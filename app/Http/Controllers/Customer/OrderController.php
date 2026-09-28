<?php

namespace App\Http\Controllers\Customer;

use App\Notifications\OrderPlacedNotification;
use App\Notifications\NewOrderNotification;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkoutForm()
    {
        $cartItems = CartItem::with('product')->where('user_id', auth()->id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart.index')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->quantity * $item->product->price;
        }

        return view('customer.orders.checkout', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pickup_date' => 'required|date|after_or_equal:today',
            'pickup_time' => 'required|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $cartItems = CartItem::with('product')->where('user_id', auth()->id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart.index')->with('error', 'Your cart is empty.');
        }

        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock_quantity) {
                return redirect()->route('customer.cart.index')
                    ->with('error', "Not enough stock for {$item->product->name}. Only {$item->product->stock_quantity} left.");
            }
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->quantity * $item->product->price;
        }

        $order = Order::create([
            'customer_id' => auth()->id(),
            'total_amount' => $total,
            'status' => 'pending',
            'pickup_date' => $request->pickup_date,
            'pickup_time' => $request->pickup_time,
            'notes' => $request->notes,
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'farmer_id' => $item->product->farmer_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->product->price,
                'subtotal' => $item->quantity * $item->product->price,
            ]);

            $item->product->decrement('stock_quantity', $item->quantity);
        }

        CartItem::where('user_id', auth()->id())->delete();

        auth()->user()->notify(new OrderPlacedNotification($order));

        $farmerIds = $cartItems->pluck('product.farmer_id')->unique()->filter();
        User::whereIn('id', $farmerIds)->get()->each(function ($farmer) use ($order) {
            $farmer->notify(new NewOrderNotification($order));
        });

        return redirect()->route('customer.orders.show', $order->id)
            ->with('success', 'Order placed successfully!');
    }

    public function index()
    {
        $orders = Order::with('items.product')
            ->where('customer_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product.farmer');

        return view('customer.orders.show', compact('order'));
    }

    protected function cutoffDeadline(Order $order)
    {
        $order->loadMissing('items.farmer');

        $smallestCutoffHours = 24;
        $first = true;

        foreach ($order->items as $item) {
            $hours = $item->farmer->order_cutoff_hours ?? 24;

            if ($first || $hours < $smallestCutoffHours) {
                $smallestCutoffHours = $hours;
                $first = false;
            }
        }

        return $order->pickup_date->copy()->subHours($smallestCutoffHours);
    }

    public function cancel(Order $order)
    {
        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'This order can no longer be cancelled.');
        }

        $order->load('items.product', 'items.farmer');

        if (now()->greaterThanOrEqualTo($this->cutoffDeadline($order))) {
            return back()->with('error', 'The cutoff time for cancelling this order has passed.');
        }

        foreach ($order->items as $item) {
            $item->product->increment('stock_quantity', $item->quantity);
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->route('customer.orders.index')->with('success', 'Order cancelled.');
    }

    public function editForm(Order $order)
    {
        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->route('customer.orders.show', $order)->with('error', 'This order can no longer be modified.');
        }

        $order->load('items.product.farmer');

        if (now()->greaterThanOrEqualTo($this->cutoffDeadline($order))) {
            return redirect()->route('customer.orders.show', $order)->with('error', 'The cutoff time for modifying this order has passed.');
        }

        return view('customer.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'This order can no longer be modified.');
        }

        $order->load('items.product.farmer');

        if (now()->greaterThanOrEqualTo($this->cutoffDeadline($order))) {
            return back()->with('error', 'The cutoff time for modifying this order has passed.');
        }

        $request->validate([
            'pickup_date' => 'required|date|after_or_equal:today',
            'pickup_time' => 'required|string|max:50',
            'notes' => 'nullable|string',
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1',
        ]);

        $newTotal = 0;

        foreach ($order->items as $item) {
            $newQty = (int) ($request->quantities[$item->id] ?? $item->quantity);
            $difference = $newQty - $item->quantity;

            if ($difference > 0 && $difference > $item->product->stock_quantity) {
                abort(422, "Not enough stock for {$item->product->name}.");
            }

            if ($difference > 0) {
                $item->product->decrement('stock_quantity', $difference);
            } elseif ($difference < 0) {
                $item->product->increment('stock_quantity', abs($difference));
            }

            $item->update([
                'quantity' => $newQty,
                'subtotal' => $newQty * $item->unit_price,
            ]);

            $newTotal += $newQty * $item->unit_price;
        }

        $order->update([
            'pickup_date' => $request->pickup_date,
            'pickup_time' => $request->pickup_time,
            'notes' => $request->notes,
            'total_amount' => $newTotal,
        ]);

        return redirect()->route('customer.orders.show', $order)->with('success', 'Order updated.');
    }
}
