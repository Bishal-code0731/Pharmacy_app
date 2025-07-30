<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Patient;
use App\Models\Inventory;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index()
    {
        return view('prescriptions.index', [
            'prescriptions' => Prescription::with(['patient', 'items'])->latest()->paginate(10)
        ]);
    }

    public function create()
    {
        return view('prescriptions.create', [
            'patients' => Patient::all(),
            'medications' => Inventory::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'prescription_date' => 'required|date',
            'items' => 'required|array',
            'items.*.medicine_id' => 'required|exists:inventory,id',
            'items.*.dosage' => 'required|string',
            'items.*.duration' => 'required|string'
        ]);

        $prescription = Prescription::create($validated);
        $prescription->items()->createMany($request->items);

        return redirect()->route('prescriptions.index')->with('success', 'Prescription created successfully');
    }

    public function show(Prescription $prescription)
    {
        return view('prescriptions.show', [
            'prescription' => $prescription->load(['patient', 'items.medicine'])
        ]);
    }

    public function edit(Prescription $prescription)
    {
        return view('prescriptions.edit', [
            'prescription' => $prescription,
            'patients' => Patient::all(),
            'medications' => Inventory::all()
        ]);
    }

    public function update(Request $request, Prescription $prescription)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'prescription_date' => 'required|date',
            'items' => 'required|array',
            'items.*.medicine_id' => 'required|exists:inventory,id',
            'items.*.dosage' => 'required|string',
            'items.*.duration' => 'required|string'
        ]);

        $prescription->update($validated);
        $prescription->items()->delete();
        $prescription->items()->createMany($request->items);

        return redirect()->route('prescriptions.index')->with('success', 'Prescription updated successfully');
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        return redirect()->route('prescriptions.index')->with('success', 'Prescription deleted successfully');
    }
}