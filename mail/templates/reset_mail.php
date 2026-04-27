<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request - <?= $appName ?></title>
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
        .notification {
            background-color: #f9f9f9;
            border-left: 4px solid #4a89dc;
            padding: 15px;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4a89dc;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
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
        .time-sensitive {
            background-color: #fff8e1;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Password Reset Request</h1>
    </div>
    <div class="content">
        <p>Dear <?= htmlspecialchars($user->first_name.' '.$user->last_name) ?>,</p>

        <p>We received a request to reset your password for your <?= $appName ?> account. To proceed with resetting your password, please click the button below:</p>

        <p style="text-align: center;">
            <a href="<?= $resetUrl ?>" class="button">Reset Your Password</a>
        </p>

        <div class="time-sensitive">
            <p><strong>Important:</strong> This password reset link will expire in <?= $expiryHours ?> hours.</p>
        </div>

        <p class="help-text">If the button doesn't work, copy and paste the following link into your browser:</p>
        <p class="help-text"><?= $resetUrl ?></p>

        <div class="notification">
            <p>If you did not request a password reset, please disregard this email and ensure your account is secure by:</p>
            <ul>
                <li>Checking that your account credentials are safe</li>
                <li>Contacting our support team immediately at <?= $supportEmail ?></li>
            </ul>
        </div>

        <div class="divider"></div>

        <p>For security reasons, this password reset link can only be used once. If you need to reset your password again, please request a new link.</p>

        <p>If you have any questions or need assistance, please contact our support team at <?= $supportEmail ?>.</p>

        <p>Best regards,<br>The <?= $appName ?> Team</p>
    </div>
    <div class="footer">
        <p>© <?= date('Y') ?> <?= $appName ?>. All rights reserved.</p>
        <p>This email was sent to <?= htmlspecialchars($user->email) ?> because a password reset was requested.</p>
        <p>If you didn't request this password reset, please contact support.</p>
    </div>
</div>
</body>
</html>
