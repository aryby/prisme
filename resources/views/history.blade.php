@extends('layouts.app')

@section('title', 'About SIPRISME -SIPRISME 2026')

@section('content')
<div class="row-fluid">
    <div class="span12">
        <div class="titleborder">
            <div>About SIPRISME</div>
        </div>
        <div class="text-center">
            <p class="lead">
                {{ \App\Models\PageContent::text('history.intro') }}
            </p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Symposium Overview</h3>
            <p>
                {{ \App\Models\PageContent::text('history.overview') }}
            </p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Symposium Mission</h3>
            <p>
                {{ \App\Models\PageContent::text('history.mission') }}
            </p>
        </div>
    </div>
</div>
@endsection