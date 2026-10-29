<p>Dear {{ $name }},</p>

<p>Thank you for registering for the PRISME conference.</p>

<p>Your account has been created successfully. Please use the details below to access your author dashboard:</p>

<ul>
    <li><strong>Email:</strong> {{ $email }}</li>
    <li><strong>Password:</strong> {{ $password }}</li>
</ul>

<p>To sign in, visit <a href="{{ $login_url }}">{{ $login_url }}</a>.</p>

<p>We recommend that you verify your account as soon as possible to activate your access.</p>

<p>Best regards,<br>
PRISME 2026 Team</p>
