<p>Dear {{ $name }},</p>

<p>Thank you for your submission to our Symposium. Your paper has been received and is currently under review.</p>

<h3>Submission details</h3>
<ul>
    <li><strong>Paper title:</strong> {{ $paper->title }}</li>
    <li><strong>Submission type:</strong> {{ $paper->submission_option === 'full_submission' ? 'Full Submission' : 'Abstract Submission' }}</li>
    <li><strong>Track:</strong> {{ $paper->track }}</li>
    <li><strong>Abstract:</strong> {{ $paper->abstract }}</li>
    <li><strong>Keywords:</strong> {{ $paper->keywords }}</li>
    <li><strong>Affiliation:</strong> {{ $paper->affiliation }}</li>
    <li><strong>Country:</strong> {{ $paper->country }}</li>
    @if ($paper->phone)
        <li><strong>Phone:</strong> {{ $paper->phone }}</li>
    @endif
    <li><strong>Submitted:</strong> {{ $paper->submitted_at?->format('F j, Y H:i') }}</li>
</ul>

@if ($password)
    <p>An account has been created for you to track your submission. Your account is currently inactive and will be activated by an administrator.</p>
    <p>Here are your login details:</p>
    <ul>
        <li><strong>Email:</strong> {{ $email }}</li>
        <li><strong>Temporary password:</strong> {{ $password }}</li>
    </ul>
@else
    <p>This submission has been added to your existing account. Your login password has not been changed.</p>
@endif

<p>You can log in to your dashboard <a href="{{ route('login') }}">here</a>.</p>

<p>Best regards,</p>
<p>The Symposium Team</p>