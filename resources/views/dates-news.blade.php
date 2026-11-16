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
                @foreach ($importantDates as $importantDate)
                    <li><strong>{{ $importantDate->title }}:</strong> {{ $importantDate->date }}</li>
                @endforeach
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