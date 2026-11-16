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
                {{ \App\Models\PageContent::text('committees.intro') }}
            </p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well text-center">
            <h3>Committee Information</h3>
            <p>
                {{ \App\Models\PageContent::text('committees.details') }}
                <a href="{{ route('committee') }}">Committee page</a>.
            </p>
            <p>
                For committee-related inquiries, please contact us at <strong>siprisme26@siprisme.org</strong>
            </p>
        </div>
    </div>
</div>
@endsection