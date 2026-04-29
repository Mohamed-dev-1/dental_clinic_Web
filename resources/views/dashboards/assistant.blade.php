<!DOCTYPE html>
<html>
<head>
    <title>Assistant Dashboard – AL-NADJAH DENTAL</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="dashboard-layout">

    <!-- SIDEBAR -->
    <aside class="dashboard-sidebar">

        <div class="sidebar-brand">AL-NADJAH</div>

        <nav class="sidebar-nav">
            <a href="#" class="sidebar-link active" onclick="showSection('patients', this)">
                 Patients
            </a>
            <a href="#" class="sidebar-link" onclick="showSection('appointments', this)">
                 Appointments
                @if($pendingAppointments->count() > 0)
                    <span class="sidebar-badge">{{ $pendingAppointments->count() }}</span>
                @endif
            </a>
            <a href="#" class="sidebar-link" onclick="showSection('payments', this)">
                 Payments
            </a>
            <a href="#" class="sidebar-link" onclick="showSection('supplies', this)">
                 Supplies
                @if($lowStockProducts->count() > 0)
                    <span class="sidebar-badge">{{ $lowStockProducts->count() }}</span>
                @endif
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
                <p class="dashboard-role">Assistant Portal</p>
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
                <h3>{{ $patients->count() }}</h3>
                <p>Total Patients</p>
            </div>
            <div class="stat-card">
                <h3>{{ $pendingAppointments->count() }}</h3>
                <p>Pending Appointments</p>
            </div>
            <div class="stat-card">
                <h3>{{ $payments->count() }}</h3>
                <p>Total Payments</p>
            </div>
            <div class="stat-card">
                <h3>{{ $lowStockProducts->count() }}</h3>
                <p>Low Stock Alerts</p>
            </div>
        </div>

        <!-- PATIENTS SECTION -->
        <div id="patients" class="dashboard-section">

            <div class="section-header">
                <h3>Patient List</h3>
                <button class="btn-action btn-blue" onclick="toggleForm('create-patient-form')">
                    + Create Patient
                </button>
            </div>

            <!-- CREATE PATIENT FORM -->
            <div id="create-patient-form" style="display:none; margin-bottom: 24px;">
                <div class="assistant-form-card">
                    <h4 style="color: var(--dark-blue); margin-bottom: 16px; font-family: 'Michroma';">New Patient Account</h4>
                    <form method="POST" action="{{ route('assistant.createPatient') }}" class="patient-form">
                        @csrf
                        <div class="form-row">
                            <div class="patient-field">
                                <label>First name</label>
                                <input type="text" name="firstname" placeholder="Enter first name" required>
                            </div>
                            <div class="patient-field">
                                <label>Last name</label>
                                <input type="text" name="lastname" placeholder="Enter last name" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="patient-field">
                                <label>Email</label>
                                <input type="email" name="email" placeholder="Enter email" required>
                            </div>
                            <div class="patient-field">
                                <label>Phone number</label>
                                <input type="text" name="phone_number" placeholder="Enter phone number">
                            </div>
                        </div>
                        <div class="patient-field">
                            <label>Password</label>
                            <input type="password" name="password" placeholder="Set a password" required>
                        </div>
                        <button type="submit" class="patient-submit">Create Account</button>
                    </form>
                </div>
            </div>

            <!-- PATIENTS TABLE -->
            <table class="dashboard-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Phone</th>
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; color: var(--dark-gray);">No patients yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- APPOINTMENTS SECTION -->
        <div id="appointments" class="dashboard-section" style="display:none;">

            <div class="section-header">
                <h3>Manage Appointments</h3>
            </div>

            <table class="dashboard-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Room</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>{{ $appointment->patient->user->firstname }} {{ $appointment->patient->user->lastname }}</td>
                        <td>Dr. {{ $appointment->doctor->user->lastname }}</td>
                        <td>{{ $appointment->appointment_date }}</td>
                        <td>{{ $appointment->appointment_time }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower($appointment->status) }}">
                                {{ $appointment->status }}
                            </span>
                        </td>
                        <td>{{ $appointment->consultation_room ?? '—' }}</td>
                        <td>
                            <button
                                class="btn-action btn-blue"
                                onclick="toggleUpdateForm('update-appointment-{{ $appointment->id }}')">
                                Update
                            </button>
                        </td>
                    </tr>
                    <!-- UPDATE APPOINTMENT FORM ROW -->
                    <tr id="update-appointment-{{ $appointment->id }}" style="display:none;">
                        <td colspan="8">
                            <form method="POST" action="{{ route('assistant.updateAppointment', $appointment->id) }}" class="inline-update-form">
                                @csrf
                                @method('PATCH')
                                <div class="form-row">
                                    <div class="patient-field">
                                        <label>Status</label>
                                        <select name="status" required>
                                            <option value="Pending" {{ $appointment->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Approved" {{ $appointment->status === 'Approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="Rejected" {{ $appointment->status === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                            <option value="Done" {{ $appointment->status === 'Done' ? 'selected' : '' }}>Done</option>
                                        </select>
                                    </div>
                                    <div class="patient-field">
                                        <label>Consultation Room</label>
                                        <input type="text" name="consultation_room" value="{{ $appointment->consultation_room }}" placeholder="e.g. Room 3">
                                    </div>
                                </div>
                                <button type="submit" class="patient-submit" style="margin-top: 8px;">Save Changes</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center; color: var(--dark-gray);">No appointments yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAYMENTS SECTION -->
        <div id="payments" class="dashboard-section" style="display:none;">

            <div class="section-header">
                <h3>Payments</h3>
                <button class="btn-action btn-blue" onclick="toggleForm('record-payment-form')">
                    + Record Payment
                </button>
            </div>

            <!-- RECORD PAYMENT FORM -->
            <div id="record-payment-form" style="display:none; margin-bottom: 24px;">
                <div class="assistant-form-card">
                    <h4 style="color: var(--dark-blue); margin-bottom: 16px; font-family: 'Michroma';">Record Cash Payment</h4>
                    <form method="POST" action="{{ route('assistant.recordPayment') }}" class="patient-form">
                        @csrf
                        <div class="form-row">
                            <div class="patient-field">
                                <label>Appointment</label>
                                <select name="appointment_id" required>
                                    <option value="">-- Select appointment --</option>
                                    @foreach($appointments as $appointment)
                                        <option value="{{ $appointment->id }}">
                                            #{{ $appointment->id }} —
                                            {{ $appointment->patient->user->firstname }}
                                            {{ $appointment->patient->user->lastname }}
                                            ({{ $appointment->appointment_date }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="patient-field">
                                <label>Patient</label>
                                <select name="patient_id" required>
                                    <option value="">-- Select patient --</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">
                                            {{ $patient->user->firstname }} {{ $patient->user->lastname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="patient-field">
                                <label>Doctor</label>
                                <select name="doctor_id" required>
                                    <option value="">-- Select doctor --</option>
                                    @foreach($appointments->unique('doctor_id') as $appointment)
                                        <option value="{{ $appointment->doctor->id }}">
                                            Dr. {{ $appointment->doctor->user->firstname }} {{ $appointment->doctor->user->lastname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="patient-field">
                                <label>Amount (DZD)</label>
                                <input type="number" name="amount" placeholder="Enter amount" min="1" required>
                            </div>
                        </div>
                        <button type="submit" class="patient-submit">Record Payment</button>
                    </form>
                </div>
            </div>

            <!-- PAYMENTS TABLE -->
            <table class="dashboard-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Appointment</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->patient->user->firstname }} {{ $payment->patient->user->lastname }}</td>
                        <td>Dr. {{ $payment->doctor->user->lastname }}</td>
                        <td>#{{ $payment->appointment_id }}</td>
                        <td>{{ number_format($payment->amount) }} DZD</td>
                        <td>{{ $payment->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; color: var(--dark-gray);">No payments recorded yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- SUPPLIES SECTION -->
        <div id="supplies" class="dashboard-section" style="display:none;">

            <div class="section-header">
                <h3>Work Products</h3>
                <button class="btn-action btn-blue" onclick="toggleForm('add-supply-form')">
                    + Add Work Product
                </button>
            </div>

            <!-- ADD SUPPLY FORM -->
            <div id="add-supply-form" style="display:none; margin-bottom: 24px;">
                <div class="assistant-form-card">
                    <h4 style="color: var(--dark-blue); margin-bottom: 16px; font-family: 'Michroma';">Add Work Supply</h4>
                    <form method="POST" action="{{ route('assistant.addWorkProduct') }}" class="patient-form">
                        @csrf
                        <div class="form-row">
                            <div class="patient-field">
                                <label>Material Name</label>
                                <input type="text" name="material_name" placeholder="e.g. Dental Gloves" required>
                            </div>
                            <div class="patient-field">
                                <label>Quantity</label>
                                <input type="number" name="material_qty" placeholder="e.g. 100" min="1" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="patient-field">
                                <label>Unit Price (DZD)</label>
                                <input type="number" name="material_unit_price" placeholder="e.g. 500" min="0" required>
                            </div>
                            <div class="patient-field">
                                <label>Expiration Date</label>
                                <input type="date" name="material_expiration_date">
                            </div>
                        </div>
                        <div class="patient-field" style="flex-direction: row; align-items: center; gap: 10px;">
                            <input type="checkbox" name="material_low_stock_alert" id="low_stock" style="width: auto;">
                            <label for="low_stock" style="margin: 0;">Enable low stock alert</label>
                        </div>
                        <button type="submit" class="patient-submit">Add Supply</button>
                    </form>
                </div>
            </div>

            <!-- SUPPLIES TABLE -->
            <table class="dashboard-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Material</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Expiration</th>
                    <th>Low Stock</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($workProducts as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->material_name }}</td>
                        <td>{{ $product->material_qty }}</td>
                        <td>{{ number_format($product->material_unit_price) }} DZD</td>
                        <td>{{ $product->material_expiration_date ?? '—' }}</td>
                        <td>
                            @if($product->material_low_stock_alert)
                                <span class="status-badge status-pending">⚠ Alert</span>
                            @else
                                <span class="status-badge status-approved">OK</span>
                            @endif
                        </td>
                        <td class="table-actions">
                            <button class="btn-action btn-blue" onclick="toggleUpdateForm('update-supply-{{ $product->id }}')">Edit</button>
                            <form method="POST" action="{{ route('assistant.deleteWorkProduct', $product->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-red" onclick="return confirm('Delete this supply?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <!-- UPDATE SUPPLY FORM ROW -->
                    <tr id="update-supply-{{ $product->id }}" style="display:none;">
                        <td colspan="7">
                            <form method="POST" action="{{ route('assistant.updateWorkProduct', $product->id) }}" class="inline-update-form">
                                @csrf
                                @method('PATCH')
                                <div class="form-row">
                                    <div class="patient-field">
                                        <label>Material Name</label>
                                        <input type="text" name="material_name" value="{{ $product->material_name }}" required>
                                    </div>
                                    <div class="patient-field">
                                        <label>Quantity</label>
                                        <input type="number" name="material_qty" value="{{ $product->material_qty }}" min="1" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="patient-field">
                                        <label>Unit Price (DZD)</label>
                                        <input type="number" name="material_unit_price" value="{{ $product->material_unit_price }}" min="0" required>
                                    </div>
                                    <div class="patient-field">
                                        <label>Expiration Date</label>
                                        <input type="date" name="material_expiration_date" value="{{ $product->material_expiration_date }}">
                                    </div>
                                </div>
                                <div class="patient-field" style="flex-direction: row; align-items: center; gap: 10px;">
                                    <input type="checkbox" name="material_low_stock_alert" id="low_stock_{{ $product->id }}" style="width: auto;" {{ $product->material_low_stock_alert ? 'checked' : '' }}>
                                    <label for="low_stock_{{ $product->id }}" style="margin: 0;">Enable low stock alert</label>
                                </div>
                                <button type="submit" class="patient-submit" style="margin-top: 8px;">Save Changes</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; color: var(--dark-gray);">No supplies added yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
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

    function toggleForm(id) {
        const form = document.getElementById(id);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function toggleUpdateForm(id) {
        const form = document.getElementById(id);
        form.style.display = form.style.display === 'none' ? 'table-row' : 'none';
    }
</script>

</body>
</html>
