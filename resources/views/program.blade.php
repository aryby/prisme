@extends('layouts.app')

@section('title', 'Program -SIPRISME 2026')

@section('content')
<div class="row-fluid">
    <div class="span12">
        <div class="titleborder">
            <div>Symposium Program</div>
        </div>
        <div class="text-center">
            <p class="lead">
                {{ \App\Models\PageContent::text('program.intro') }}
            </p>
            <p class="text-info">
                <strong>Program information will be available closer to the Symposium date.</strong>
            </p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well text-center">
            <h3>Symposium Schedule Overview</h3>
            <p>
                {{ \App\Models\PageContent::text('program.schedule') }}
            </p>
            <p>
                For program updates, please contact us at <strong>{{ \App\Models\PageContent::text('program.contact') }}</strong>
            </p>
        </div>
    </div>
</div>
@endsection