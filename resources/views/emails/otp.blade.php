<!DOCTYPE html>
<html>
<head>
    <style>
        .container { font-family: sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .otp-box { background: #f8fafc; padding: 20px; text-align: center; font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #4f46e5; border-radius: 8px; border: 1px dashed #cbd5e1; }
        .footer { margin-top: 30px; font-size: 12px; color: #64748b; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="color: #1e293b;">Verification Code</h2>
            <p style="color: #64748b;">Hello, please use the following code for your <strong>{{ $type }}</strong> request.</p>
        </div>
        
        <div class="otp-box">
            {{ $otp }}
        </div>
        
        <p style="color: #64748b; font-size: 14px; margin-top: 20px;">
            This code will expire in 10 minutes. If you did not request this, please ignore this email.
        </p>
        
        <div class="footer">
            &copy; {{ date('Y') }} Laravel 13 Admin Panel. Secure JWT System.
        </div>
    </div>
</body>
</html>
