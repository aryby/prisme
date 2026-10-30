<p>Hello {{ $review->reviewer->name }},</p>

<p>A paper has been assigned to you for review:</p>

<ul>
    <li><strong>Title:</strong> {{ $paper->title }}</li>
    <li><strong>Track:</strong> {{ $paper->track }}</li>
    <li><strong>Abstract:</strong> {{ $paper->abstract }}</li>
    <li><strong>Keywords:</strong> {{ $paper->keywords }}</li>
</ul>

<p><a href="{{ $paperUrl }}">View or download the paper PDF</a></p>
<p><a href="{{ $reviewUrl }}">Add your comments and recommendation</a></p>

<p>Please sign in to your reviewer account if prompted.</p>

<p>Best regards,<br>
Siprisme Conference Team</p>
