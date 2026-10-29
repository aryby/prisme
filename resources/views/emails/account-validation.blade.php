<p>Dear {{ $user->name }},</p>

<p>Welcome to PRISME 2026.</p>

<p>To complete your registration and activate your account, please verify your email address by clicking the button below:</p>

<p>
    <a href="{{ $verificationUrl }}" style="display:inline-block;padding:12px 20px;background:#2563eb;color:#fff;text-decoration:none;border-radius:6px;">
        Verify my account
    </a>
</p>

<p>If the button does not work, copy and paste this link in your browser:</p>
<p>{{ $verificationUrl }}</p>

<p>Best regards,<br>
PRISME 2026 Team</p>
