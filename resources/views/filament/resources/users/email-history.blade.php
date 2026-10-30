@if ($messages->isEmpty())
    <p>No emails have been sent to this user yet.</p>
@else
    <div class="space-y-4">
        @foreach ($messages as $message)
            <article class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                <p><strong>Sent:</strong> {{ $message->sent_at->toDayDateTimeString() }}</p>
                <p><strong>To:</strong> {{ $message->recipient_email }}</p>
                <p><strong>Subject:</strong> {{ $message->subject }}</p>
                <p class="whitespace-pre-wrap">{{ $message->body }}</p>
            </article>
        @endforeach
    </div>
@endif
