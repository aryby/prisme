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
                Various calls and opportunities for SIPRISME 2026
            </p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Call for Papers</h3>
            <p>
                We invite original research papers in digital economy, smart business, and data innovation. 
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
                We welcome proposals for workshops that complement the main Symposium program. 
                For workshop proposals, please contact us at <strong>siprisme26@siprisme.org</strong>
            </p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Call for Sponsorship</h3>
            <p>
                We offer various sponsorship opportunities for organizations interested in supporting SIPRISME 2026. 
                For sponsorship information, please contact us at <strong>siprisme26@siprisme.org</strong>
            </p>
        </div>
    </div>
</div>
@endsection