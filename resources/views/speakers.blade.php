@extends('layouts.app')

@section('title', 'Speakers -SIPRISME 2026')

@section('content')
<div class="row-fluid">
    <div class="span12">
        <div class="titleborder">
            <div>Keynote Speakers</div>
        </div>
        <div class="text-center">
            <p class="lead">
                {{ \App\Models\PageContent::text('speakers.intro') }}
            </p>
            <p class="text-info">
                <strong>{{ \App\Models\PageContent::text('speakers.announcement') }}</strong>
            </p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well text-center">
            <h3>Call for Speakers</h3>
            <p>
                {{ \App\Models\PageContent::text('speakers.call') }}
            </p>
        </div>
    </div>
</div>
@endsection