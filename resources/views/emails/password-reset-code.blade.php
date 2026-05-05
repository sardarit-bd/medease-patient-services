<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset Code</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px;">
    <div style="max-width: 480px; margin: auto; background: #ffffff; border-radius: 8px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <h2 style="color: #1a1a1a; margin-bottom: 8px;">Password Reset Request</h2>
        <p style="color: #555; font-size: 15px;">Use the code below to reset your password. It expires in <strong>10 minutes</strong>.</p>

        <div style="text-align: center; margin: 32px 0;">
            <span style="font-size: 36px; font-weight: bold; letter-spacing: 10px; color: #2563eb;">
                {{ $code }}
            </span>
        </div>

        <p style="color: #888; font-size: 13px;">If you did not request a password reset, you can safely ignore this email.</p>
    </div>
</body>
</html>