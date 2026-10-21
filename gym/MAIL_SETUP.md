# Contact form email setup

The contact form uses PHPMailer over authenticated SMTP. Configure these environment variables for the PHP/Apache process, then restart Apache:

PHP must have the `mbstring` extension enabled for server-side form validation.

| Variable | Purpose |
| --- | --- |
| `BRABUS_SMTP_HOST` | SMTP server hostname |
| `BRABUS_SMTP_PORT` | SMTP port (defaults to `587`) |
| `BRABUS_SMTP_USERNAME` | SMTP account username |
| `BRABUS_SMTP_PASSWORD` | SMTP account password or app password |
| `BRABUS_SMTP_ENCRYPTION` | `tls` (default) or `ssl` |
| `BRABUS_SMTP_FROM_EMAIL` | Sender address authorized by the SMTP account |
| `BRABUS_SMTP_FROM_NAME` | Sender display name (defaults to `Brabus Gym`) |
| `BRABUS_CONTACT_TO` | Inbox that should receive contact messages |

For XAMPP, these can be added as `SetEnv` entries in the Apache virtual-host configuration, for example:

```apache
SetEnv BRABUS_SMTP_HOST "smtp.example.com"
SetEnv BRABUS_SMTP_PORT "587"
SetEnv BRABUS_SMTP_USERNAME "your-smtp-username"
SetEnv BRABUS_SMTP_PASSWORD "your-smtp-password"
SetEnv BRABUS_SMTP_ENCRYPTION "tls"
SetEnv BRABUS_SMTP_FROM_EMAIL "no-reply@example.com"
SetEnv BRABUS_SMTP_FROM_NAME "Brabus Gym"
SetEnv BRABUS_CONTACT_TO "your-inbox@example.com"
```

Do not commit SMTP credentials. The form returns a configuration error until the required settings are provided.

Install the dependency from this directory with `composer install`.
