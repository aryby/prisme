<p>Dear {{ $name }},</p>

<p>Thank you for your submission to our conference. Your paper has been received and is currently under review.</p>

<p>An account has been created for you to track the status of your submission. Your account is currently inactive and will be activated by an administrator.</p>

<p>Here are your login details:</p>
<ul>
    <li><strong>Email:</strong> {{ $email }}</li>
    <li><strong>Password:</strong> {{ $password }}</li>
</ul>

<p>You can log in to your dashboard <a href="{{ route('login') }}">here</a>.</p>

<p>Best regards,</p>
<p>The Conference Team</p>