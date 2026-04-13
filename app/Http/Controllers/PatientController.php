<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\MedicalDocument;
use App\Models\Note;
use App\Models\Notification;
use App\Models\Doctor;

class PatientController extends Controller
{
    // Show patient dashboard
    public function index()
    {
        $patient = Auth::user()->patient;

        $appointments = Appointment::with('doctor.user')
            ->where('patient_id', $patient->id)
            ->orderBy('appointment_date', 'desc')
            ->get();

        $pendingAppointments = $appointments->where('status', 'Pending');
        $approvedAppointments = $appointments->where('status', 'Approved');
        $doneAppointments = $appointments->where('status', 'Done');

        $medicalDocuments = MedicalDocument::with('doctor.user', 'appointment')
            ->where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $note = Note::where('patient_id', $patient->id)->first();

        $notifications = Notification::where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $unreadNotifications = $notifications->where('is_read', false)->count();

        $doctors = Doctor::with('user')->get();

        return view('dashboards.patient', compact(
            'patient',
            'appointments',
            'pendingAppointments',
            'approvedAppointments',
            'doneAppointments',
            'medicalDocuments',
            'note',
            'notifications',
            'unreadNotifications',
            'doctors'
        ));
    }

    // Update profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'firstname'    => ['required', 'string', 'max:255'],
            'lastname'     => ['required', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update([
            'firstname'    => $request->firstname,
            'lastname'     => $request->lastname,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return redirect()->back()->withErrors([
                'current_password' => 'Current password is incorrect.'
            ]);
        }

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    // Delete account
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Account deleted successfully.');
    }

    // Save or update notes
    public function saveNote(Request $request)
    {
        $patient = Auth::user()->patient;

        $request->validate([
            'allergies'        => ['nullable', 'string', 'max:500'],
            'chronic_diseases' => ['nullable', 'string', 'max:500'],
        ]);

        Note::updateOrCreate(
            ['patient_id' => $patient->id],
            [
                'allergies'        => $request->allergies,
                'chronic_diseases' => $request->chronic_diseases,
            ]
        );

        return redirect()->back()->with('success', 'Notes saved successfully.');
    }

    // Book appointment
    public function bookAppointment(Request $request)
    {
        $patient = Auth::user()->patient;

        $request->validate([
            'doctor_id'        => ['required', 'exists:doctors,id'],
            'appointment_date' => ['required', 'date', 'after:today'],
            'appointment_time' => ['required'],
            'speciality'       => ['nullable', 'string'],
            'complaint'        => ['nullable', 'string', 'max:500'],
        ]);

        Appointment::create([
            'patient_id'       => $patient->id,
            'doctor_id'        => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'speciality'       => $request->speciality,
            'complaint'        => $request->complaint,
            'status'           => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Appointment booked successfully.');
    }

    // Cancel appointment
    public function cancelAppointment($id)
    {
        $patient = Auth::user()->patient;

        $appointment = Appointment::where('id', $id)
            ->where('patient_id', $patient->id)
            ->firstOrFail();

        if ($appointment->status === 'Done') {
            return redirect()->back()->withErrors(['error' => 'Cannot cancel a completed appointment.']);
        }

        $appointment->update(['status' => 'Rejected']);

        return redirect()->back()->with('success', 'Appointment cancelled successfully.');
    }

    // Mark notification as read
    public function markNotificationRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);
        return redirect()->back();
    }

    // Mark all notifications as read
    public function markAllNotificationsRead()
    {
        $patient = Auth::user()->patient;
        Notification::where('patient_id', $patient->id)->update(['is_read' => true]);
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }
}
