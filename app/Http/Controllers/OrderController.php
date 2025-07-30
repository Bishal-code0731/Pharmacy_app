<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Prescription;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders.index', [
            'orders' => Order::with('prescription')->latest()->paginate(10)
        ]);
    }

    public function pending()
    {
        return view('orders.pending', [
            'orders' => Order::where('status', 'pending')->with('prescription')->get()
        ]);
    }

    public function create()
    {
        return view('orders.create', [
            'prescriptions' => Prescription::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prescription_id' => 'required|exists:prescriptions,id',
            'order_date' => 'required|date',
            'status' => 'required|in:pending,processing,completed'
        ]);

        Order::create($validated);

        return redirect()->route('orders.index')->with('success', 'Order created successfully');
    }

    public function show(Order $order)
    {
        return view('orders.show', [
            'order' => $order->load('prescription.items.medicine')
        ]);
    }

    public function edit(Order $order)
    {
        return view('orders.edit', [
            'order' => $order,
            'prescriptions' => Prescription::all()
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'prescription_id' => 'required|exists:prescriptions,id',
            'order_date' => 'required|date',
            'status' => 'required|in:pending,processing,completed'
        ]);

        $order->update($validated);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully');
    }
}