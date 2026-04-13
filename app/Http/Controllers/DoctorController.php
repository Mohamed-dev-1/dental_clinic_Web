<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\MedicalDocument;

class DoctorController extends Controller
{
    // Show doctor dashboard
    public function index()
    {
        $doctor = Auth::user()->doctor;

        $patients = Patient::with('user')->get();

        $appointments = Appointment::with('patient.user')
            ->where('doctor_id', $doctor->id)
            ->orderBy('appointment_date', 'asc')
            ->get();

        $pendingAppointments = $appointments->where('status', 'Pending');
        $approvedAppointments = $appointments->where('status', 'Approved');

        return view('dashboards.doctor', compact(
            'doctor',
            'patients',
            'appointments',
            'pendingAppointments',
            'approvedAppointments'
        ));
    }

    // Search a patient
    public function searchPatient(Request $request)
    {
        $query = $request->input('query');

        $patients = Patient::with('user')
            ->whereHas('user', function($q) use ($query) {
                $q->where('firstname', 'like', "%$query%")
                    ->orWhere('lastname', 'like', "%$query%")
                    ->orWhere('email', 'like', "%$query%");
            })->get();

        return view('dashboards.doctor', compact('patients'));
    }

    // Delete a patient
    public function deletePatient($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->user->delete();
        return redirect()->back()->with('success', 'Patient deleted successfully.');
    }

    // Show create medical document form
    public function createMedicalDocument($patientId)
    {
        $patient = Patient::with('user')->findOrFail($patientId);
        $appointments = Appointment::where('patient_id', $patientId)->get();
        return view('dashboards.doctor_medical_form', compact('patient', 'appointments'));
    }

    // Store medical document
    public function storeMedicalDocument(Request $request)
    {
        $request->validate([
            'appointment_id' => ['required', 'exists:appointments,id'],
            'patient_id'     => ['required', 'exists:patients,id'],
            'diagnosis'      => ['required', 'string'],
            'treatment_plan' => ['nullable', 'string'],
            'prescription'   => ['nullable', 'string'],
        ]);

        $doctor = Auth::user()->doctor;

        MedicalDocument::create([
            'appointment_id' => $request->appointment_id,
            'patient_id'     => $request->patient_id,
            'doctor_id'      => $doctor->id,
            'diagnosis'      => $request->diagnosis,
            'treatment_plan' => $request->treatment_plan,
            'prescription'   => $request->prescription,
        ]);

        return redirect()->back()->with('success', 'Medical document created successfully.');
    }

    // Accept appointment
    public function acceptAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'Approved']);
        return redirect()->back()->with('success', 'Appointment approved.');
    }

    // Reject appointment
    public function rejectAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'Rejected']);
        return redirect()->back()->with('success', 'Appointment rejected.');
    }
}
