<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Password Reset OTP</title>
</head>
<body style="margin:0;padding:24px;background:#f8fafc;font-family:'Inter',Arial,sans-serif;color:#0f172a;">
    <div style="max-width:560px;margin:0 auto;background:#ffffff;border-radius:20px;padding:32px;border:1px solid #e2e8f0;">
        <p style="margin:0 0 8px;font-size:12px;letter-spacing:0.28em;text-transform:uppercase;color:#0284c7;">The Kahwa Company</p>
        <h1 style="margin:0 0 16px;font-size:28px;line-height:1.2;">Admin password reset OTP</h1>
        <p style="margin:0 0 16px;font-size:15px;line-height:1.7;">Hello {{ $admin->name }},</p>
        <p style="margin:0 0 20px;font-size:15px;line-height:1.7;">Use the following OTP to reset your admin password. This code will expire in {{ $expiresInMinutes }} minutes.</p>
        <div style="margin:0 0 24px;padding:18px 20px;background:#0f172a;border-radius:16px;color:#ffffff;font-size:30px;font-weight:700;letter-spacing:0.35em;text-align:center;">
            {{ $otp }}
        </div>
        <p style="margin:0;font-size:14px;line-height:1.7;color:#475569;">If you did not request this, you can ignore this email.</p>
    </div>
</body>
</html>


