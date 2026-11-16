@extends('layouts.app')

@section('title', 'Attendees -SIPRISME 2026')

@section('content')
<div class="row-fluid">
    <div class="span12">
        <div class="titleborder">
            <div>Information for Attendees</div>
        </div>
        <div class="text-center">
            <p class="lead">
                {{ \App\Models\PageContent::text('attendees.intro') }}
            </p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Symposium Information</h3>
            <ul>
                <li><strong>Venue:</strong> {{ \App\Models\PageContent::text('attendees.venue') }}</li>
                <li><strong>Dates:</strong> {{ \App\Models\PageContent::text('attendees.dates') }}</li>
                <li><strong>Format:</strong> {{ \App\Models\PageContent::text('attendees.format') }}</li>
            </ul>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Travel Information</h3>
            <p>{{ \App\Models\PageContent::text('attendees.travel') }}</p>
            <p>For specific inquiries, please contact us at <strong>{{ \App\Models\PageContent::text('attendees.contact') }}</strong></p>
        </div>
    </div>
</div>
@endsection