@extends('layouts.app')

@section('title', 'Committees -SIPRISME 2026')

@section('content')
<div class="row-fluid">
    <div class="span12">
        <div class="titleborder">
            <div>Symposium Committees</div>
        </div>
        <div class="text-center">
            <p class="lead">
                Meet the distinguished committee members of SIPRISME 2026
            </p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well text-center">
            <h3>Committee Information</h3>
            <p>
                Detailed information about all Symposium committees is available on our 
                <a href="{{ route('committee') }}">Committee page</a>.
            </p>
            <p>
                For committee-related inquiries, please contact us at <strong>siprisme26@siprisme.org</strong>
            </p>
        </div>
    </div>
</div>
@endsection