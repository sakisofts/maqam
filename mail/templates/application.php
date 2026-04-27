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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            <h1><?= $appName ?> ONLINE ADMISSIONS</h1>
        </div>
        <div class="content">
            <p>Dear <?= htmlspecialchars($user->first_name . ' ' . $user->last_name) ?>,</p>
            <p>Your Application has been received .Please make the necessary payments and endeavour to keep checking the Application Portal to see progress about your application</p>

            <div class="credentials">
                <p><strong>FORM NUMBER:</strong> <?php echo ($user->applicant_id) ? sprintf('%04d', $user->applicant_id) : '0000'; ?></p>
                <p><strong>APPLICATION FEE:</strong> 50,000UGX</p>
                <p class="warning">Please make full payment for the application to be considered.</p>
            </div>
            <div class="divider"></div>
            <p>Best regards,<br>The <?= $appName ?> Team</p>
        </div>
        <div class="footer">
            <p>© <?= date('Y') ?> <?= $appName ?>. All rights reserved.</p>
            <p>This email was sent to <?= htmlspecialchars($user->email) ?> because a new application was received.</p>
            <p>If you didn't request this account, please ignore this email or contact support.</p>
        </div>
    </div>
</body>

</html>