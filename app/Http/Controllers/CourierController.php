<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Delivery;
use App\Models\Expedition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourierController extends Controller
{
    /**
     * Courier dashboard — shows assigned orders and deliveries.
     */
    public function index()
    {
        $courierId = Auth::id();

        // Orders assigned to this courier
        $assignedOrders = Order::with('items.product')
            ->where('courier_id', $courierId)
            ->whereIn('status', ['processed', 'shipped', 'arrived'])
            ->latest()
            ->get();

        // Completed orders
        $completedOrders = Order::where('courier_id', $courierId)
            ->whereIn('status', ['completed'])
            ->count();

        // Delivery records by this courier
        $deliveries = Delivery::with(['order', 'expedition'])
            ->where('courier_id', $courierId)
            ->latest()
            ->limit(10)
            ->get();

        $stats = [
            'active'    => $assignedOrders->whereIn('status', ['processed', 'shipped'])->count(),
            'arrived'   => $assignedOrders->where('status', 'arrived')->count(),
            'completed' => $completedOrders,
            'total'     => Order::where('courier_id', $courierId)->count(),
        ];

        return view('courier.dashboard', [
            'title'          => 'Courier Dashboard',
            'assignedOrders' => $assignedOrders,
            'deliveries'     => $deliveries,
            'stats'          => $stats,
        ]);
    }

    /**
     * Show order detail for courier.
     */
    public function show($id)
    {
        $order = Order::with(['items.product', 'user'])
            ->where('courier_id', Auth::id())
            ->findOrFail($id);

        $expeditions = Expedition::all();

        $delivery = Delivery::where('order_id', $order->id)
            ->where('courier_id', Auth::id())
            ->first();

        return view('courier.show', [
            'title'       => 'Order Details',
            'order'       => $order,
            'expeditions' => $expeditions,
            'delivery'    => $delivery,
        ]);
    }

    /**
     * Update delivery status (courier action).
     */
    public function update(Request $request, $id)
    {
        $order = Order::where('courier_id', Auth::id())->findOrFail($id);

        $request->validate([
            'status'        => 'required|in:shipped,arrived',
            'expedition_id' => 'nullable|exists:expeditions,id',
            'picture_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
            'notes'         => 'nullable|string|max:500',
        ]);

        // Update order status
        $order->update(['status' => $request->status]);

        // Create or update delivery record
        $deliveryData = [
            'order_id'      => $order->id,
            'courier_id'    => Auth::id(),
            'delivery_date' => now()->toDateString(),
            'expedition_id' => $request->expedition_id,
            'status'        => $request->status == 'shipped' ? 'in_transit' : 'delivered',
            'notes'         => $request->notes,
            'invoice'       => $order->id,
        ];

        if ($request->hasFile('picture_proof')) {
            $deliveryData['picture_proof'] = $request->file('picture_proof')->store('delivery_proofs', 'public');
        }

        Delivery::updateOrCreate(
            ['order_id' => $order->id, 'courier_id' => Auth::id()],
            $deliveryData
        );

        $statusText = $request->status == 'shipped' ? 'picked up and in transit' : 'marked as arrived';

        return back()->with('success', "Order #{$order->invoice_number} has been {$statusText}.");
    }
}
