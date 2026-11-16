@extends('layouts.app')

@section('title', 'Calls -SIPRISME 2026')

@section('content')
<div class="row-fluid">
    <div class="span12">
        <div class="titleborder">
            <div>Symposium Calls</div>
        </div>
        <div class="text-center">
            <p class="lead">
                {{ \App\Models\PageContent::text('calls.intro') }}
            </p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Call for Papers</h3>
            <p>
                {{ \App\Models\PageContent::text('calls.papers') }}
                <a href="{{ route('call-for-papers') }}">View detailed call for papers</a>
            </p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Call for Workshops</h3>
            <p>
                {{ \App\Models\PageContent::text('calls.workshops') }}
            </p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Call for Sponsorship</h3>
            <p>
                {{ \App\Models\PageContent::text('calls.sponsorship') }}
            </p>
        </div>
    </div>
</div>
@endsection