@extends('layouts.app')

@section('title', 'Call for Papers -SIPRISME 2026')
@section('description', 'Submit your original research to SIPRISME 2026. We invite contributions in digital economy, smart business, data innovation, and emerging technologies.')

@section('content')
    

    <div class="row-fluid top0">
        <div class="panel1">
            <div class="span11">
                <h4 class="top0"><strong>Thematic Areas</strong></h4>
<p class="text-muted">

{{ \App\Models\PageContent::text('call-for-papers.intro') }}
<br><br>
{{ \App\Models\PageContent::text('call-for-papers.description') }}
<br><br>
{{ \App\Models\PageContent::text('call-for-papers.languages') }}
<br>
</p>
@include('partials.thematic-areas')
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="row-fluid top0">
        <div class="alert-info">
            <h4 class="alert-info mb-0 pb-0"><strong>| Submission Options</strong></h4>
        </div>
    </div>

    <div class="panel1">
        <div class="span11" style="margin-left: 5px;">
            <p><strong>Abstract submission:</strong> {{ \App\Models\PageContent::text('call-for-papers.abstract') }}</p>
            <p><strong>Full paper submission:</strong> {{ \App\Models\PageContent::text('call-for-papers.full-paper') }}</p>
            <p><strong>Accepted papers:</strong> {{ \App\Models\PageContent::text('call-for-papers.accepted') }}</p>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection
