<p>Hello {{ $contactMessage->name }},</p>

<p>Thank you for contacting the SIPRISME 2026 organizing committee.</p>

<p><strong>Your message:</strong> {{ $contactMessage->subject }}</p>
<p>{{ $contactMessage->message }}</p>

<p><strong>Our response:</strong></p>
<p>{!! nl2br(e($contactMessage->response)) !!}</p>

<p>Best regards,<br>
SIPRISME 2026 Organizing Committee</p>
