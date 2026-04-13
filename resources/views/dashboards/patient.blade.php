<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/patient-dashboard-style.css') }}">
    <script defer src="{{ asset('js/patient-dashboard-script.js') }}"></script>
    <title>Patient Dashboard</title>
</head>
<body>
    <div>
        <div class="sidebar">
            <div class="sidebar-profile" onclick="toggle_profile_card()">
                <img src="https://placehold.co/40" alt="profile pic">
                <p> UserName</p>
            </div>
            <div class="sidebar-links-container">
                <div class="sidebar-link">General Overview</div>
                <div class="sidebar-link">Medical Notes</div>
                <div class="sidebar-link">History</div>
                <div class="sidebar-link">Appointements</div>
                <div class="sidebar-link">Medical Reports</div>
            </div>
            <div class="sidebar-logout">
                Logout
            </div>
        </div>
        <div class="content-container">
            <div class="content">
                <h1>Wolcame Back [UserName] !</h1>
            </div>
            <div class="content" style="display: none;">
                C2
            </div>
            <div class="content" style="display: none;">
                C3
            </div>
            <div class="content" style="display: none;">
                C4
            </div>
            <div class="content" style="display: none;">
                C5
            </div>
            <div class="content" style="display: none;">
                C6
            </div>
        </div>
    </div>
    <div class="profile-card-container" style="display: none;"> <!-- Temporary state: change back to none -->
        <div class="profile-card">
            <p class="profile-card-title">Modify Profile</p>
            <div class="profile-card-current-info-container">
                <img src="https://placehold.co/70">
                <p>[UserName]</p>
            </div>
            <div class="profile-card-form-container">
                <form action="/" method="post">
                    <div class="profile-card-form-row">
                        <div class="profile-card-form-input-half">
                            <p>First Name:</p>
                            <input type="text" placeholder="Your First Name">
                        </div>
                        <div class="profile-card-form-input-half">
                            <p>Last Name:</p>
                            <input type="text" placeholder="Your Last Name">
                        </div>
                    </div>
                    <div class="profile-card-form-row">
                        <div class="profile-card-form-input-half">
                            <p>Phone Number:</p>
                            <input type="tel" maxlength="10" minlength="9" placeholder="0xxxxxxxxx">
                        </div>
                        <div class="profile-card-form-input-half">
                            <p>Email Address:</p>
                            <input type="email" placeholder="example@mail.com">
                        </div>
                    </div>
                    <div class="profile-card-form-row">
                        <div class="profile-card-form-input-half">
                            <p>Old Password:</p>
                            <input type="text" placeholder="Enter Old Password">
                        </div>
                        <div class="profile-card-form-input-half">
                            <p>New Password:</p>
                            <input type="text" placeholder="Enter New Password">
                        </div>
                    </div>
                    <div class="profile-card-cta-contianer">
                        <button type="button" onclick="toggle_profile_card()" class="profile-card-secondary-cta"> Cancel</button>
                        <button type="submit" class="profile-card-main-cta">Apply Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
