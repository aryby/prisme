<p>Hello {{ $user->name }},</p>

<p>An account has been created for you on the Siprisme Symposium platform.</p>

<p>Your login details are:</p>
<ul>
    <li><strong>Email:</strong> {{ $user->email }}</li>
    <li><strong>Password:</strong> {{ $password }}</li>
    <li><strong>Role:</strong> {{ ucfirst($user->role) }}</li>
</ul>

<p>You can sign in here: <a href="{{ $loginUrl }}">{{ $loginUrl }}</a></p>

<p>Please change your password after signing in.</p>

<p>Best regards,<br>
Siprisme Symposium Team</p>
