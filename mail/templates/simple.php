<?php
/* @var $user \app\models\User */
/* @var $content string */
/* @var $actionUrl string */
/* @var $actionText string */
?>
<?= $subject ?>

<?php if (isset($user)): ?>
    Hello <?= $user->name ?>,
<?php endif; ?>

<?= $content ?>

<?php if (isset($actionUrl) && isset($actionText)): ?>
    <?= $actionText ?>: <?= $actionUrl ?>
<?php endif; ?>

© <?= date('Y') ?> Your Company Name. All rights reserved.
If you didn't request this email, please ignore it.
