<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Delivery;
use App\Models\Expedition;
use Illuminate\Http\Request;

class CourierManagementController extends Controller
{
    /**
     * Admin master view — tabs for Couriers, Expeditions, Deliveries.
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'couriers');

        // Couriers data
        $couriers = User::where('role', 'courier')->latest()->get();

        // Expeditions data
        $expeditions = Expedition::withCount('deliveries')->latest()->get();

        // Deliveries data
        $deliveries = Delivery::with(['order', 'courier', 'expedition'])
            ->latest()
            ->paginate(10);

        // Stats
        $totalCouriers   = User::where('role', 'courier')->count();
        $activeCouriers  = User::where('role', 'courier')->where('is_active', 1)->count();
        $pendingCouriers = User::where('role', 'courier')->where('is_active', 0)->count();
        $totalDeliveries = Delivery::count();

        return view('courier-management.index', [
            'title'           => 'Courier Management',
            'tab'             => $tab,
            'couriers'        => $couriers,
            'expeditions'     => $expeditions,
            'deliveries'      => $deliveries,
            'totalCouriers'   => $totalCouriers,
            'activeCouriers'  => $activeCouriers,
            'pendingCouriers' => $pendingCouriers,
            'totalDeliveries' => $totalDeliveries,
        ]);
    }

    /**
     * Approve / Activate a courier.
     */
    public function update(Request $request, $id)
    {
        $courier = User::where('role', 'courier')->findOrFail($id);

        if ($request->has('is_active')) {
            $courier->update(['is_active' => $request->is_active]);
            $action = $request->is_active ? 'activated' : 'deactivated';
            return back()->with('success', "Courier {$courier->name} has been {$action}.");
        }

        return back();
    }

    /**
     * Remove a courier user.
     */
    public function destroy($id)
    {
        $courier = User::where('role', 'courier')->findOrFail($id);
        $courier->delete();

        return back()->with('success', 'Courier deleted successfully.');
    }
}
