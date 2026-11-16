@extends('layouts.app')

@section('title', 'Venue -SIPRISME 2026')
@section('description', 'Venue and location information for SIPRISME 2026 in Casablanca, Morocco.')

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <div class="titleborder">
                <div>Venue</div>
            </div>
            <div class="well">
                <h2>{{ \App\Models\PageContent::text('venue.name') }}</h2>
                <p><strong>Venue:</strong> {{ \App\Models\PageContent::text('venue.location') }}</p>
                <p><strong>Location:</strong> {{ \App\Models\PageContent::text('venue.city') }}</p>
                <p><strong>Dates:</strong> {{ \App\Models\PageContent::text('venue.dates') }}</p>
                <p>{{ \App\Models\PageContent::text('venue.instructions') }} <a href="{{ route('contact') }}">contact the organizing committee</a>.</p>
            </div>
        </div>
    </div>
@endsection
