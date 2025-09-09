<!DOCTYPE html>
<html>
<head>
    <title>Welcome to {{ config('app.name') }}</title>
</head>
<body>
<h1>Welcome, {{ $user->name }}!</h1>

<p>Your account has been created successfully.</p>

<p><strong>Your login email:</strong> {{ $user->email }}</p>

<p>To access your account, please set up your password by clicking the link below:</p>

<p>
    <a href="{{ $resetPasswordUrl }}" style="background-color: #4f46e5; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
        Set Up Your Password
    </a>
</p>

<p>Or copy and paste this link into your browser:</p>
<p>{{ $resetPasswordUrl }}</p>

<p>This link will expire in 60 minutes for security reasons.</p>

<p>Welcome aboard!</p>
</body>
</html>
