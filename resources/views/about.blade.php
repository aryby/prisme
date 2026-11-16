@extends('layouts.app')

@section('title', 'About SIPRISME 2026 - The Multidisciplinary Research Laboratory in Social Engineering and Business
 Management (SIPRISME)')
@section('description', 'Learn about SIPRISME 2026, our mission, vision, and the exciting program we have planned for this premier international Symposium on digital economy and data innovation.')

@section('content')
<!-- Page Header -->
<div class="row-fluid">
    <div class="span12">
        <div class="titleborder">
            <div>About SIPRISME 2026</div>
        </div>
        <div class="text-center">
            <p class="lead">
                {{ \App\Models\PageContent::text('about.intro') }}
            </p>
        </div>
    </div>
</div>

<!-- Mission & Vision -->
<div class="row-fluid">
    <div class="span6">
        <div class="titleborder">
            <div>Our Mission</div>
        </div>
        <p class="lead">
           {{ \App\Models\PageContent::text('about.overview') }}
        </p>
        <p>
            {{ \App\Models\PageContent::text('about.mission') }}
        </p>
    </div>
    <div class="span6">
        <div class="well">
            <h3>Our Vision</h3>
            <p>
                {{ \App\Models\PageContent::text('about.vision') }}
            </p>
        </div>
    </div>
</div>

<!-- Symposium Highlights -->
<div class="row-fluid">
    <div class="span12">
        <div class="titleborder">
            <div>Symposium Highlights</div>
        </div>
        <p class="text-center lead">
            {{ \App\Models\PageContent::text('about.highlights-intro') }}
        </p>
    </div>
</div>

<div class="row-fluid">
    <div class="span4">
        <div class="well text-center">
            <h4>{{ \App\Models\PageContent::text('about.world-class-speakers-title') }}</h4>
            <p>{{ \App\Models\PageContent::text('about.world-class-speakers') }}</p>
        </div>
    </div>
    <div class="span4">
        <div class="well text-center">
            <h4>{{ \App\Models\PageContent::text('about.cutting-edge-title') }}</h4>
            <p>{{ \App\Models\PageContent::text('about.cutting-edge') }}</p>
        </div>
    </div>
    <div class="span4">
        <div class="well text-center">
            <h4>{{ \App\Models\PageContent::text('about.networking-title') }}</h4>
            <p>{{ \App\Models\PageContent::text('about.networking') }}</p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span4">
        <div class="well text-center">
            <h4>{{ \App\Models\PageContent::text('about.workshops-title') }}</h4>
            <p>{{ \App\Models\PageContent::text('about.workshops') }}</p>
        </div>
    </div>
    <div class="span4">
        <div class="well text-center">
            <h4>{{ \App\Models\PageContent::text('about.exhibition-title') }}</h4>
            <p>{{ \App\Models\PageContent::text('about.exhibition') }}</p>
        </div>
    </div>
    <div class="span4">
        <div class="well text-center">
            <h4>{{ \App\Models\PageContent::text('about.impact-title') }}</h4>
            <p>{{ \App\Models\PageContent::text('about.impact') }}</p>
        </div>
    </div>
</div>

<!-- Symposium Program -->
<div class="row-fluid">
    <div class="span12">
        <div class="titleborder">
            <div>Symposium Program</div>
        </div>
        <p class="text-center lead">
            {{ \App\Models\PageContent::text('about.program-intro') }}
        </p>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Day 1: Opening & Keynotes</h3>
            <p>{{ \App\Models\PageContent::text('about.day-one') }}</p>
            <ul>
                @foreach (preg_split('/\r\n|\r|\n/', \App\Models\PageContent::text('about.day-one-items')) as $item)
                    @if (trim($item) !== '')
                        <li>{{ $item }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Day 2: Research Presentations</h3>
            <p>{{ \App\Models\PageContent::text('about.day-two') }}</p>
            <ul>
                @foreach (preg_split('/\r\n|\r|\n/', \App\Models\PageContent::text('about.day-two-items')) as $item)
                    @if (trim($item) !== '')
                        <li>{{ $item }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Day 3: Innovation & Future</h3>
            <p>{{ \App\Models\PageContent::text('about.day-three') }}</p>
            <ul>
                @foreach (preg_split('/\r\n|\r|\n/', \App\Models\PageContent::text('about.day-three-items')) as $item)
                    @if (trim($item) !== '')
                        <li>{{ $item }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="row-fluid">
    <div class="span12">
        <div class="alert alert-info text-center">
            <h2>{{ \App\Models\PageContent::text('about.cta-title') }}</h2>
            <p class="lead">
                {{ \App\Models\PageContent::text('about.cta') }}
            </p>
            <p>
                <a href="{{ route('submission') }}" class="btn btn-primary btn-large">Submit Your Paper</a>
                <a href="{{ route('contact') }}" class="btn btn-default btn-large">Contact Us</a>
            </p>
        </div>
    </div>
</div>
@endsection