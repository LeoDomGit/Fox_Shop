<!DOCTYPE html>
<html>
<head>
    <title>Reset Your Password</title>
</head>
<body>
    <h1>Reset Your Password</h1>
    <p>Hi {{ $data['name'] }},</p>
    <p>We received a request to reset your password. Click the link below to reset it:</p>
    <p>
        <a href="{{ $data['reset_link'] }}">Reset Password</a>
    </p>
    <p>If you did not request a password reset, please ignore this email.</p>
    <p>Thank you!</p>
</body>
</html>
