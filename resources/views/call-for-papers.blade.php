@extends('layouts.app')

@section('title', 'Call for Papers -SIPRISME 2026')
@section('description', 'Submit your original research toSIPRISME 2026. We invite contributions in digital economy, smart business, data innovation, and emerging technologies.')

@section('content')
    

    <div class="row-fluid top0">
        <div class="panel1">
            <div class="span11">
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
        <div class="span11">
            <p><strong>Abstract submission:</strong> Authors who wish to present their research without pursuing publication may submit an abstract by 15 November 2026.</p>
            <p><strong>Full paper submission:</strong> Authors seeking publication opportunities must submit a full paper by 9 December 2026. All submissions will undergo a rigorous peer-review process.</p>
            <p><strong>Accepted papers:</strong> Selected papers may be published in one of the following venues: the International Journal of Intelligent Management and Data Systems or The International Journal of Economic and Management Decisions.</p>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection
