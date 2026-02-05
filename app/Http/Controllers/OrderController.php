<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Menampilkan Daftar Order
    public function index()
    {
        $orders = Order::with(['user', 'courier'])->latest()->paginate(10);

        // PERBAIKAN: Tambahkan 'title'
        return view('orders.index', [
            'orders' => $orders,
            'title' => 'Order Management'
        ]);
    }

    // Menampilkan Detail Order (Invoice)
    public function show(Order $order)
    {
        $order->load('items.product');
        $couriers = User::where('role', 'courier')->where('is_active', 1)->get();

        // PERBAIKAN: Tambahkan 'title'
        return view('orders.show', [
            'order' => $order,
            'couriers' => $couriers,
            'title' => 'Order Details'
        ]);
    }

    // Update Status / Assign Kurir
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required',
            'courier_id' => 'nullable|exists:users,id',
        ]);

        $data = [
            'status' => $request->status,
        ];

        // Jika Admin memilih kurir, simpan ID-nya
        if ($request->has('courier_id') && $request->courier_id != null) {
            $data['courier_id'] = $request->courier_id;

            // Auto update status jika masih pending
            if ($order->status == 'pending') {
                $data['status'] = 'processed';
            }
        }

        $order->update($data);

        return back()->with('success', 'Order status updated successfully.');
    }

    // Hapus Order
    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted.');
    }
}
