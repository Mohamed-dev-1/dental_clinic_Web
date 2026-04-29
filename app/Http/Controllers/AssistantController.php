<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Assistant;
use App\Models\Patient;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\WorkProduct;

class AssistantController extends Controller
{
    // Show assistant dashboard
    public function index()
    {
        $assistant = Auth::user()->assistant;

        $patients = Patient::with('user')->get();

        $appointments = Appointment::with('patient.user', 'doctor.user')
            ->orderBy('appointment_date', 'asc')
            ->get();

        $pendingAppointments = $appointments->where('status', 'Pending');

        $payments = Payment::with('patient.user', 'doctor.user', 'appointment')
            ->orderBy('created_at', 'desc')
            ->get();

        $workProducts = WorkProduct::where('assistant_id', $assistant->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $lowStockProducts = $workProducts->where('material_low_stock_alert', true);

        return view('dashboards.assistant', compact(
            'assistant',
            'patients',
            'appointments',
            'pendingAppointments',
            'payments',
            'workProducts',
            'lowStockProducts'
        ));
    }

    // Create patient account
    public function createPatient(Request $request)
    {
        $request->validate([
            'firstname'    => ['required', 'string', 'max:255'],
            'lastname'     => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'unique:users'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'password'     => ['required', 'min:8'],
        ]);

        $user = User::create([
            'firstname'    => $request->firstname,
            'lastname'     => $request->lastname,
            'email'        => $request->email,
            'phone_number' => $request->phone_number,
            'password'     => Hash::make($request->password),
            'role'         => 'patient',
        ]);

        Patient::create([
            'user_id' => $user->id,
        ]);

        return redirect()->back()->with('success', 'Patient account created successfully.');
    }

    // Record a payment
    public function recordPayment(Request $request)
    {
        $assistant = Auth::user()->assistant;

        $request->validate([
            'appointment_id' => ['required', 'exists:appointments,id'],
            'patient_id'     => ['required', 'exists:patients,id'],
            'doctor_id'      => ['required', 'exists:doctors,id'],
            'amount'         => ['required', 'integer', 'min:1'],
        ]);

        Payment::create([
            'appointment_id' => $request->appointment_id,
            'patient_id'     => $request->patient_id,
            'doctor_id'      => $request->doctor_id,
            'assistant_id'   => $assistant->id,
            'amount'         => $request->amount,
        ]);

        return redirect()->back()->with('success', 'Payment recorded successfully.');
    }

    // Update appointment status
    public function updateAppointment(Request $request, $id)
    {
        $request->validate([
            'status'           => ['required', 'in:Pending,Approved,Rejected,Done'],
            'consultation_room'=> ['nullable', 'string', 'max:255'],
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update([
            'status'            => $request->status,
            'consultation_room' => $request->consultation_room,
        ]);

        return redirect()->back()->with('success', 'Appointment updated successfully.');
    }

    // Add work product
    public function addWorkProduct(Request $request)
    {
        $assistant = Auth::user()->assistant;

        $request->validate([
            'material_name'            => ['required', 'string', 'max:255'],
            'material_qty'             => ['required', 'integer', 'min:1'],
            'material_unit_price'      => ['required', 'integer', 'min:0'],
            'material_expiration_date' => ['nullable', 'date'],
            'material_low_stock_alert' => ['nullable', 'boolean'],
        ]);

        WorkProduct::create([
            'assistant_id'             => $assistant->id,
            'material_name'            => $request->material_name,
            'material_qty'             => $request->material_qty,
            'material_unit_price'      => $request->material_unit_price,
            'material_expiration_date' => $request->material_expiration_date,
            'material_low_stock_alert' => $request->has('material_low_stock_alert'),
        ]);

        return redirect()->back()->with('success', 'Work product added successfully.');
    }

    // Update work product
    public function updateWorkProduct(Request $request, $id)
    {
        $request->validate([
            'material_name'            => ['required', 'string', 'max:255'],
            'material_qty'             => ['required', 'integer', 'min:1'],
            'material_unit_price'      => ['required', 'integer', 'min:0'],
            'material_expiration_date' => ['nullable', 'date'],
            'material_low_stock_alert' => ['nullable', 'boolean'],
        ]);

        $product = WorkProduct::findOrFail($id);
        $product->update([
            'material_name'            => $request->material_name,
            'material_qty'             => $request->material_qty,
            'material_unit_price'      => $request->material_unit_price,
            'material_expiration_date' => $request->material_expiration_date,
            'material_low_stock_alert' => $request->has('material_low_stock_alert'),
        ]);

        return redirect()->back()->with('success', 'Work product updated successfully.');
    }

    // Delete work product
    public function deleteWorkProduct($id)
    {
        $product = WorkProduct::findOrFail($id);
        $product->delete();
        return redirect()->back()->with('success', 'Work product deleted successfully.');
    }
}
