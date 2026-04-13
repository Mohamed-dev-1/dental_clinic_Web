<!DOCTYPE html>
<html>
<head>
    <title>Sign Up – AL-NADJAH DENTAL</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<section class="auth-page">

    <a href="/" class="auth-back">Back to home</a>

    <div class="auth-card">

        <h1 class="auth-title">AL-NADJAH DENTAL</h1>
        <p class="auth-subtitle">Create your account</p>

        <form method="POST" action="/register">
            @csrf

            <div class="auth-field">
                <label for="firstname">First name</label>
                <input type="text" id="firstname" name="firstname" placeholder="Enter your first name" required>
            </div>

            <div class="auth-field">
                <label for="lastname">Last name</label>
                <input type="text" id="lastname" name="lastname" placeholder="Enter your last name" required>
            </div>

            <div class="auth-field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="auth-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Create a password" required>
            </div>

            <div class="auth-field">
                <label for="password_confirmation">Confirm password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat your password" required>
            </div>

            <input type="submit" value="Create account" id="submit">

        </form>

        <p class="auth-switch">Already have an account? <a href="/login">Log in</a></p>

    </div>

</section>

</body>
</html>
