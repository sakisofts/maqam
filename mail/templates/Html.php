<?php
/* @var $user \app\models\User */
/* @var $content string */
/* @var $actionUrl string */
/* @var $actionText string */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $subject ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #e9ecef;
        }
        .content {
            padding: 20px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1><?= $subject ?></h1>
    </div>
    <div class="content">
        <?php if (isset($user)): ?>
            <p>Hello <?= $user->name ?>,</p>
        <?php endif; ?>

        <?= $content ?>

        <?php if (isset($actionUrl) && isset($actionText)): ?>
            <p>
                <a href="<?= $actionUrl ?>" class="button"><?= $actionText ?></a>
            </p>
        <?php endif; ?>
    </div>
    <div class="footer">
        <p>© <?= date('Y') ?> Your Company Name. All rights reserved.</p>
        <p>If you didn't request this email, please ignore it.</p>
    </div>
</div>
</body>
</html>
