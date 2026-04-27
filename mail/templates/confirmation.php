<?php
/* @var $user \app\models\User */
/* @var $password string */
/* @var $confirmationUrl string */
/* @var $appName string */
/* @var $supportEmail string */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to <?= $appName ?> - Account Details</title>
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
        .credentials {
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
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Welcome to <?= $appName ?></h1>
    </div>
    <div class="content">
        <p>Dear <?= htmlspecialchars($user->first_name.' '.$user->last_name) ?>,</p>

        <p>Your account has been created successfully. Please find your login details below:</p>

        <div class="credentials">
<!--            <p><strong>Username:</strong> --><?php //= htmlspecialchars($user->username) ?><!--</p>-->
            <p><strong>Email:</strong> <?= htmlspecialchars($user->email) ?></p>
            <?php if (isset($password)): ?>
                <p><strong>Password:</strong> <?= htmlspecialchars($password) ?></p>
                <p class="warning">Please change your password after your first login for security reasons.</p>
            <?php endif; ?>
        </div>

        <p>To complete your registration and activate your account, please click the button below:</p>

        <p style="text-align: center;">
            <a href="<?= $confirmationUrl ?>" class="button">Confirm Your Account</a>
        </p>

        <p class="help-text">If the button doesn't work, copy and paste the following link into your browser:</p>
        <p class="help-text"><?= $confirmationUrl ?></p>

        <div class="divider"></div>

        <p>After confirming your account, you'll be able to log in and access all features of <?= $appName ?>.</p>

        <p>If you didn't create this account or have any questions, please contact our support team at <?= $supportEmail ?>.</p>

        <p>Best regards,<br>The <?= $appName ?> Team</p>
    </div>
    <div class="footer">
        <p>© <?= date('Y') ?> <?= $appName ?>. All rights reserved.</p>
        <p>This email was sent to <?= htmlspecialchars($user->email) ?> because a new account was created.</p>
        <p>If you didn't request this account, please ignore this email or contact support.</p>
    </div>
</div>
</body>
</html>
