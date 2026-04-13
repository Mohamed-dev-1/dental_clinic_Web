<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard – AL-NADJAH DENTAL</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="dashboard-layout">

    <!-- SIDEBAR -->
    <aside class="dashboard-sidebar">

        <div class="sidebar-brand">AL-NADJAH</div>

        <nav class="sidebar-nav">
            <a href="#patients" class="sidebar-link active" onclick="showSection('patients')">
                 Patients
            </a>
            <a href="#appointments" class="sidebar-link" onclick="showSection('appointments')">
                 Appointments
            </a>
            <a href="#pending" class="sidebar-link" onclick="showSection('pending')">
                 Pending
                @if($pendingAppointments->count() > 0)
                    <span class="sidebar-badge">{{ $pendingAppointments->count() }}</span>
                @endif
            </a>
            <a href="#medical" class="sidebar-link" onclick="showSection('medical')">
                 Medical Files
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
                <h2 class="dashboard-welcome">Welcome, Dr. {{ Auth::user()->lastname }}</h2>
                <p class="dashboard-role">{{ $doctor->speciality }}</p>
            </div>
        </div>

        <!-- SUCCESS MESSAGE -->
        @if(session('success'))
            <div class="dashboard-alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- STATS ROW -->
        <div class="dashboard-stats">
            <div class="stat-card">
                <h3>{{ $patients->count() }}</h3>
                <p>Total Patients</p>
            </div>
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
        </div>

        <!-- PATIENTS SECTION -->
        <div id="patients" class="dashboard-section">

            <div class="section-header">
                <h3>Patient List</h3>

                <!-- SEARCH -->
                <form method="GET" action="{{ route('doctor.search') }}" class="search-form">
                    <input type="text" name="query" placeholder="Search by name or email...">
                    <button type="submit">Search</button>
                </form>
            </div>

            <table class="dashboard-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($patients as $patient)
                    <tr>
                        <td>{{ $patient->id }}</td>
                        <td>{{ $patient->user->firstname }}</td>
                        <td>{{ $patient->user->lastname }}</td>
                        <td>{{ $patient->user->email }}</td>
                        <td>{{ $patient->user->phone_number ?? '—' }}</td>
                        <td class="table-actions">
                            <a href="{{ route('doctor.createMedical', $patient->id) }}" class="btn-action btn-blue">+ Medical file</a>
                            <form method="POST" action="{{ route('doctor.deletePatient', $patient->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-red" onclick="return confirm('Delete this patient?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; color: var(--dark-gray);">No patients found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- APPOINTMENTS SECTION -->
        <div id="appointments" class="dashboard-section" style="display:none;">

            <div class="section-header">
                <h3>All Appointments</h3>
            </div>

            <table class="dashboard-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Speciality</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @forelse($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>{{ $appointment->patient->user->firstname }} {{ $appointment->patient->user->lastname }}</td>
                        <td>{{ $appointment->appointment_date }}</td>
                        <td>{{ $appointment->appointment_time }}</td>
                        <td>{{ $appointment->speciality ?? '—' }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower($appointment->status) }}">
                                {{ $appointment->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; color: var(--dark-gray);">No appointments found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- PENDING APPOINTMENTS SECTION -->
        <div id="pending" class="dashboard-section" style="display:none;">

            <div class="section-header">
                <h3>Pending Appointments</h3>
            </div>

            <table class="dashboard-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Complaint</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($pendingAppointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>{{ $appointment->patient->user->firstname }} {{ $appointment->patient->user->lastname }}</td>
                        <td>{{ $appointment->appointment_date }}</td>
                        <td>{{ $appointment->appointment_time }}</td>
                        <td>{{ $appointment->complaint ?? '—' }}</td>
                        <td class="table-actions">
                            <form method="POST" action="{{ route('doctor.acceptAppointment', $appointment->id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-action btn-blue">Accept</button>
                            </form>
                            <form method="POST" action="{{ route('doctor.rejectAppointment', $appointment->id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-action btn-red">Reject</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; color: var(--dark-gray);">No pending appointments.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- MEDICAL FILES SECTION -->
        <div id="medical" class="dashboard-section" style="display:none;">

            <div class="section-header">
                <h3>Medical Files</h3>
                <p style="color: var(--dark-gray); font-size: 0.9rem;">Select a patient from the Patients section to create a medical file.</p>
            </div>

        </div>

    </main>
</div>

<script>
    function showSection(name) {
        document.querySelectorAll('.dashboard-section').forEach(s => s.style.display = 'none');
        document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));
        document.getElementById(name).style.display = 'block';
        event.target.classList.add('active');
    }
</script>

</body>
</html>
