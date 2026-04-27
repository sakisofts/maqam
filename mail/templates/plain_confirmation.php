
Welcome to <?= $appName ?> - Account Details

Dear <?= $user->email ?>,

Your account has been created successfully. Please find your login details below:

Email: <?= $user->email ?>
<?php if (isset($password)): ?>
    Password: <?= $password ?>

    IMPORTANT: Please change your password after your first login for security reasons.
<?php endif; ?>

To complete your registration and activate your account, please visit the following link:
<?= $confirmationUrl ?>

After confirming your account, you'll be able to log in and access all features of <?= $appName ?>.

If you didn't create this account or have any questions, please contact our support team at <?= $supportEmail ?>.

Best regards,
The <?= $appName ?> Team

© <?= date('Y') ?> <?= $appName ?>. All rights reserved.
This email was sent to <?= $user->email ?> because a new account was created.
If you didn't request this account, please ignore this email or contact support.
