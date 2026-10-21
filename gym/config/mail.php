<?php

return [
    'host' => getenv('BRABUS_SMTP_HOST') ?: '',
    'port' => getenv('BRABUS_SMTP_PORT') ?: '587',
    'username' => getenv('BRABUS_SMTP_USERNAME') ?: '',
    'password' => getenv('BRABUS_SMTP_PASSWORD') ?: '',
    'encryption' => getenv('BRABUS_SMTP_ENCRYPTION') ?: 'tls',
    'from_email' => getenv('BRABUS_SMTP_FROM_EMAIL') ?: '',
    'from_name' => getenv('BRABUS_SMTP_FROM_NAME') ?: 'Brabus Gym',
    'to_email' => getenv('BRABUS_CONTACT_TO') ?: '',
];
