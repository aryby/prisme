@extends('layouts.app')

@section('title', 'Dates & News -SIPRISME 2026')

@section('content')
<div class="row-fluid">
    <div class="span12">
        <div class="titleborder">
            <div>Important Dates & News</div>
        </div>
        <div class="text-center">
            <p class="lead">
                {{ \App\Models\PageContent::text('dates-news.intro') }}
            </p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Important Dates</h3>
            <ul>
                <li><strong>Abstract submission deadline:</strong> {{ \App\Models\PageContent::text('important-dates.abstract-deadline') }}</li>
                <li><strong>Notification of acceptance:</strong> {{ \App\Models\PageContent::text('important-dates.acceptance') }}</li>
                <li><strong>Full paper submission:</strong> {{ \App\Models\PageContent::text('important-dates.full-paper') }}</li>
                <li><strong>Symposium dates:</strong> {{ \App\Models\PageContent::text('important-dates.symposium') }}</li>
                <li><strong>Final versions for publication:</strong> {{ \App\Models\PageContent::text('important-dates.final-version') }}</li>
            </ul>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Latest News</h3>
            <p>{{ \App\Models\PageContent::text('dates-news.news') }}</p>
            <p>For the latest information, please visit our website regularly or contact us at <strong>siprisme26@siprisme.org</strong></p>
        </div>
    </div>
</div>
@endsection