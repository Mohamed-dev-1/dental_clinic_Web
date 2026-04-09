<!DOCTYPE html>
<html>
<head>
    <title>Login - AL-NADJAH DENTAL</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<section class="auth-page">

    <a href="/" class="auth-back">Back to home</a>

    <div class="auth-card">

        <h1 class="auth-title">AL-NADJAH DENTAL</h1>
        <p class="auth-subtitle">Welcome back — log in to your account</p>

        <form method="POST" action="/login">
            @csrf

            <div class="auth-field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="auth-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <input type="submit" value="Log in" id="submit">

        </form>

        <p class="auth-switch">Don't have an account? <a href="/register">Sign up</a></p>

    </div>

</section>

</body>
</html>
