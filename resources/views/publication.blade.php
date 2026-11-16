@extends('layouts.app')

@section('title', 'Publication -SIPRISME 2026')

@section('content')
<div class="row-fluid">
    <div class="span12">
        <div class="titleborder">
            <div>Publication Information</div>
        </div>
        <div class="text-center">
            <p class="lead">
                {{ \App\Models\PageContent::text('publication.intro') }}
            </p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Publication Venues</h3>
            <p>
                {{ \App\Models\PageContent::text('publication.venues') }}
            </p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Additional Publication Opportunities</h3>
            <p>
                {{ \App\Models\PageContent::text('publication.additional') }}
            </p>
            <ul>
                @foreach (preg_split('/\r\n|\r|\n/', \App\Models\PageContent::text('publication.additional-venues')) as $venue)
                    @if (trim($venue) !== '')
                        <li>{{ $venue }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Publication Process</h3>
            <p>
                {{ \App\Models\PageContent::text('publication.process') }}
            </p>
            <p>
                {{ \App\Models\PageContent::text('publication.process-detail') }}
            </p>
            <p>
                {{ \App\Models\PageContent::text('publication.acceptance') }}
            </p>
        </div>
    </div>
</div>
@endsection