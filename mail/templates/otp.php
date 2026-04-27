<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Verification Code - <?= $appName ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #4a89dc;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            color: white;
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .footer {
            background-color: #f5f5f5;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .otp-code {
            background-color: #f9f9f9;
            border-left: 4px solid #4a89dc;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
            font-size: 32px;
            letter-spacing: 5px;
            font-weight: bold;
            font-family: monospace;
        }
        .expiry-alert {
            background-color: #fff8e1;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        .warning {
            color: #e74c3c;
            font-weight: bold;
        }
        .divider {
            height: 1px;
            background-color: #eee;
            margin: 20px 0;
        }
        .help-text {
            font-size: 14px;
            color: #777;
        }
        .security-tips {
            background-color: #e8f5e9;
            border-left: 4px solid #4caf50;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Your Verification Code</h1>
    </div>
    <div class="content">
        <p>Dear <?= htmlspecialchars($user->first_name.' '.$user->last_name) ?>,</p>

        <p>You have requested a verification code for <?= htmlspecialchars($purpose) ?>. Please use the following One-Time Password (OTP) to complete your request:</p>

        <div class="otp-code">
            <?= htmlspecialchars($otpToken) ?>
        </div>

        <div class="expiry-alert">
            <p><strong>Important:</strong> This code will expire in <?= $expiryMinutes ?> minutes.</p>
        </div>

        <div class="security-tips">
            <p><strong>Security Tips:</strong></p>
            <ul>
                <li>Never share this code with anyone</li>
                <li>Our team will never ask for this code</li>
                <li>Enter the code directly in the <?= $appName ?> application</li>
            </ul>
        </div>

        <div class="divider"></div>

        <p class="warning">If you did not request this code, please ignore this email and consider changing your password.</p>

        <p>If you have any questions or need assistance, please contact our support team at <?= $supportEmail ?>.</p>

        <p>Best regards,<br>The <?= $appName ?> Team</p>
    </div>
    <div class="footer">
        <p>© <?= date('Y') ?> <?= $appName ?>. All rights reserved.</p>
        <p>This email was sent to <?= htmlspecialchars($user->email) ?> because a verification code was requested.</p>
        <p>If you didn't request this code, please contact support.</p>
    </div>
</div>
</body>
</html>
