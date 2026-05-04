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
    $doctor = Auth::user()->doctor;

    $patients = Patient::with('user')
        ->whereHas('user', function($q) use ($query) {
            $q->where('firstname', 'like', "%$query%")
              ->orWhere('lastname', 'like', "%$query%")
              ->orWhere('email', 'like', "%$query%");
        })->get();

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

    // Delete a patient
    public function deletePatient($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->user->delete();
        return redirect()->back()->with('success', 'Patient deleted successfully.');
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

        // Notify the patient
\App\Models\Notification::create([
    'patient_id' => $request->patient_id,
    'title'      => 'New Medical File',
    'message'    => 'Your doctor has added a new medical file with diagnosis and treatment details.',
    'type'       => 'new_medical_document',
    'is_read'    => false,
]);

return redirect()->back()->with('success', 'Medical document created successfully.');
    }

    // Accept appointment
    public function acceptAppointment($id)
{
    $appointment = Appointment::findOrFail($id);
    $appointment->update(['status' => 'Approved']);

    // Notify the patient
    \App\Models\Notification::create([
        'patient_id' => $appointment->patient_id,
        'title'      => 'Appointment Approved',
        'message'    => 'Your appointment on ' . $appointment->appointment_date . ' at ' . $appointment->appointment_time . ' has been approved.',
        'type'       => 'appointment_status',
        'is_read'    => false,
    ]);

    return redirect()->back()->with('success', 'Appointment approved.');
}

    // Reject appointment
    public function rejectAppointment($id)
{
    $appointment = Appointment::findOrFail($id);
    $appointment->update(['status' => 'Rejected']);

    // Notify the patient
    \App\Models\Notification::create([
        'patient_id' => $appointment->patient_id,
        'title'      => 'Appointment Rejected',
        'message'    => 'Your appointment on ' . $appointment->appointment_date . ' at ' . $appointment->appointment_time . ' has been rejected.',
        'type'       => 'appointment_status',
        'is_read'    => false,
    ]);

    return redirect()->back()->with('success', 'Appointment rejected.');
}
}
