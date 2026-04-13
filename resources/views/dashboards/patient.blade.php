<!DOCTYPE html>
<html>
<head>
    <title>Patient Dashboard – AL-NADJAH DENTAL</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="dashboard-layout">

    <!-- SIDEBAR -->
    <aside class="dashboard-sidebar">

        <div class="sidebar-brand">AL-NADJAH</div>

        <nav class="sidebar-nav">
            <a href="#" class="sidebar-link active" onclick="showSection('appointments', this)">
                 Appointments
            </a>
            <a href="#" class="sidebar-link" onclick="showSection('book', this)">
                 Book Appointment
            </a>
            <a href="#" class="sidebar-link" onclick="showSection('medical', this)">
                 Medical Files
            </a>
            <a href="#" class="sidebar-link" onclick="showSection('notifications', this)">
                 Notifications
                @if($unreadNotifications > 0)
                    <span class="sidebar-badge">{{ $unreadNotifications }}</span>
                @endif
            </a>
            <a href="#" class="sidebar-link" onclick="showSection('profile', this)">
                 Profile
            </a>
            <a href="#" class="sidebar-link" onclick="showSection('notes', this)">
                 My Notes
            </a>
        </nav>

        <form method="POST" action="/logout" class="sidebar-logout">
            @csrf
            <button type="submit">Log out</button>
        </form>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="dashboard-main">

        <!-- TOP BAR -->
        <div class="dashboard-topbar">
            <div>
                <h2 class="dashboard-welcome">Welcome, {{ Auth::user()->firstname }}</h2>
                <p class="dashboard-role">Patient Portal</p>
            </div>
        </div>

        <!-- SUCCESS MESSAGE -->
        @if(session('success'))
            <div class="dashboard-alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- ERROR MESSAGE -->
        @if($errors->any())
            <div class="dashboard-alert-error">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- STATS ROW -->
        <div class="dashboard-stats">
            <div class="stat-card">
                <h3>{{ $appointments->count() }}</h3>
                <p>Total Appointments</p>
            </div>
            <div class="stat-card">
                <h3>{{ $pendingAppointments->count() }}</h3>
                <p>Pending</p>
            </div>
            <div class="stat-card">
                <h3>{{ $approvedAppointments->count() }}</h3>
                <p>Approved</p>
            </div>
            <div class="stat-card">
                <h3>{{ $medicalDocuments->count() }}</h3>
                <p>Medical Files</p>
            </div>
        </div>

        <!-- APPOINTMENTS SECTION -->
        <div id="appointments" class="dashboard-section">

            <div class="section-header">
                <h3>My Appointments</h3>
            </div>

            <table class="dashboard-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Speciality</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>Dr. {{ $appointment->doctor->user->lastname }}</td>
                        <td>{{ $appointment->appointment_date }}</td>
                        <td>{{ $appointment->appointment_time }}</td>
                        <td>{{ $appointment->speciality ?? '—' }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower($appointment->status) }}">
                                {{ $appointment->status }}
                            </span>
                        </td>
                        <td>
                            @if($appointment->status === 'Pending' || $appointment->status === 'Approved')
                                <form method="POST" action="{{ route('patient.cancelAppointment', $appointment->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-action btn-red" onclick="return confirm('Cancel this appointment?')">Cancel</button>
                                </form>
                            @else
                                <span style="color: var(--dark-gray); font-size: 0.85rem;">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; color: var(--dark-gray);">No appointments yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- BOOK APPOINTMENT SECTION -->
        <div id="book" class="dashboard-section" style="display:none;">

            <div class="section-header">
                <h3>Book an Appointment</h3>
            </div>

            <form method="POST" action="{{ route('patient.bookAppointment') }}" class="patient-form">
                @csrf

                <div class="form-row">
                    <div class="patient-field">
                        <label>Select Doctor</label>
                        <select name="doctor_id" required>
                            <option value="">-- Choose a doctor --</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">
                                    Dr. {{ $doctor->user->firstname }} {{ $doctor->user->lastname }} — {{ $doctor->speciality }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="patient-field">
                        <label>Speciality</label>
                        <select name="speciality">
                            <option value="">-- Choose speciality --</option>
                            <option value="Endodontics">Endodontics</option>
                            <option value="Pediatric Dentistry">Pediatric Dentistry</option>
                            <option value="Orthodontics">Orthodontics</option>
                            <option value="Periodontics">Periodontics</option>
                            <option value="Full Dental Exam">Full Dental Exam</option>
                            <option value="General Dental Care">General Dental Care</option>
                            <option value="Oral and Maxillofacial Surgery">Oral and Maxillofacial Surgery</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="patient-field">
                        <label>Date</label>
                        <input type="date" name="appointment_date" required>
                    </div>

                    <div class="patient-field">
                        <label>Time</label>
                        <input type="time" name="appointment_time" required>
                    </div>
                </div>

                <div class="patient-field">
                    <label>Complaint (optional)</label>
                    <textarea name="complaint" rows="3" placeholder="Describe your complaint..."></textarea>
                </div>

                <button type="submit" class="patient-submit">Book Appointment</button>
            </form>
        </div>

        <!-- MEDICAL FILES SECTION -->
        <div id="medical" class="dashboard-section" style="display:none;">

            <div class="section-header">
                <h3>My Medical Files</h3>
            </div>

            @forelse($medicalDocuments as $doc)
                <div class="medical-card">
                    <div class="medical-card-header">
                        <div>
                            <h4>Dr. {{ $doc->doctor->user->firstname }} {{ $doc->doctor->user->lastname }}</h4>
                            <p>{{ $doc->created_at->format('d M Y') }}</p>
                        </div>
                        <span class="status-badge status-done">Done</span>
                    </div>

                    <div class="medical-card-body">
                        <div class="medical-field">
                            <label>Diagnosis</label>
                            <p>{{ $doc->diagnosis }}</p>
                        </div>

                        @if($doc->treatment_plan)
                            <div class="medical-field">
                                <label>Treatment Plan</label>
                                <p>{{ $doc->treatment_plan }}</p>
                            </div>
                        @endif

                        @if($doc->prescription)
                            <div class="medical-field">
                                <label>Prescription</label>
                                <p>{{ $doc->prescription }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <p style="color: var(--dark-gray); text-align: center;">No medical files yet.</p>
            @endforelse
        </div>

        <!-- NOTIFICATIONS SECTION -->
        <div id="notifications" class="dashboard-section" style="display:none;">

            <div class="section-header">
                <h3>Notifications</h3>
                @if($unreadNotifications > 0)
                    <form method="POST" action="{{ route('patient.markAllNotificationsRead') }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-action btn-blue">Mark all as read</button>
                    </form>
                @endif
            </div>

            @forelse($notifications as $notification)
                <div class="notification-card {{ $notification->is_read ? '' : 'notification-unread' }}">
                    <div class="notification-content">
                        <h4>{{ $notification->title }}</h4>
                        <p>{{ $notification->message }}</p>
                        <span class="notification-date">{{ $notification->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if(!$notification->is_read)
                        <form method="POST" action="{{ route('patient.markNotificationRead', $notification->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-action btn-blue">Mark as read</button>
                        </form>
                    @endif
                </div>
            @empty
                <p style="color: var(--dark-gray); text-align: center;">No notifications yet.</p>
            @endforelse
        </div>

        <!-- PROFILE SECTION -->
        <div id="profile" class="dashboard-section" style="display:none;">

            <div class="section-header">
                <h3>My Profile</h3>
            </div>

            <form method="POST" action="{{ route('patient.updateProfile') }}" class="patient-form">
                @csrf

                <div class="form-row">
                    <div class="patient-field">
                        <label>First name</label>
                        <input type="text" name="firstname" value="{{ Auth::user()->firstname }}" required>
                    </div>

                    <div class="patient-field">
                        <label>Last name</label>
                        <input type="text" name="lastname" value="{{ Auth::user()->lastname }}" required>
                    </div>
                </div>

                <div class="patient-field">
                    <label>Phone number</label>
                    <input type="text" name="phone_number" value="{{ Auth::user()->phone_number }}">
                </div>

                <div class="patient-field">
                    <label>Email</label>
                    <input type="email" value="{{ Auth::user()->email }}" disabled style="opacity: 0.6; cursor: not-allowed;">
                </div>

                <button type="submit" class="patient-submit">Save Changes</button>
            </form>

            <hr class="section-divider">

            <h4 class="section-subtitle">Change Password</h4>

            <form method="POST" action="{{ route('patient.updatePassword') }}" class="patient-form">
                @csrf

                <div class="patient-field">
                    <label>Current password</label>
                    <input type="password" name="current_password" placeholder="Enter current password" required>
                </div>

                <div class="form-row">
                    <div class="patient-field">
                        <label>New password</label>
                        <input type="password" name="password" placeholder="Enter new password" required>
                    </div>

                    <div class="patient-field">
                        <label>Confirm new password</label>
                        <input type="password" name="password_confirmation" placeholder="Repeat new password" required>
                    </div>
                </div>

                <button type="submit" class="patient-submit">Update Password</button>
            </form>

            <hr class="section-divider">

            <h4 class="section-subtitle" style="color: #e74c3c;">Danger Zone</h4>

            <form method="POST" action="{{ route('patient.deleteAccount') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="patient-submit patient-submit-danger" onclick="return confirm('Are you sure you want to delete your account? This cannot be undone.')">
                    Delete My Account
                </button>
            </form>

        </div>

        <!-- NOTES SECTION -->
        <div id="notes" class="dashboard-section" style="display:none;">

            <div class="section-header">
                <h3>My Medical Notes</h3>
            </div>

            <form method="POST" action="{{ route('patient.saveNote') }}" class="patient-form">
                @csrf

                <div class="patient-field">
                    <label>Allergies</label>
                    <textarea name="allergies" rows="3" placeholder="List any allergies you have...">{{ $note->allergies ?? '' }}</textarea>
                </div>

                <div class="patient-field">
                    <label>Chronic Diseases</label>
                    <textarea name="chronic_diseases" rows="3" placeholder="List any chronic diseases...">{{ $note->chronic_diseases ?? '' }}</textarea>
                </div>

                <button type="submit" class="patient-submit">Save Notes</button>
            </form>
        </div>

    </main>
</div>

<script>
    function showSection(name, el) {
        document.querySelectorAll('.dashboard-section').forEach(s => s.style.display = 'none');
        document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));
        document.getElementById(name).style.display = 'block';
        el.classList.add('active');
    }
</script>

</body>
</html>
