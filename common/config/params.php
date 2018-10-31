<?php
return [
    'admin.email' => getenv('ADMIN_EMAIL'),
    'support.email' => getenv('ADMIN_EMAIL'),

    'user.passwordResetTokenExpire' => 3600,
    'user.emailConfirmationTokenExpire' => 43200, // 5 days
];
