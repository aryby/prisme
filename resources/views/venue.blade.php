@extends('layouts.app')

@section('title', 'Venue -SIPRISME 2026')
@section('description', 'Venue and location information for SIPRISME 2026 in Casablanca, Morocco.')

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <div class="titleborder">
                <div>Venue</div>
            </div>
            <div class="well">
                <h2>SIPRISME 2026</h2>
                <p><strong>Venue:</strong> Higher School of Technology of Casablanca (ESTC), Hassan II University of Casablanca</p>
                <p><strong>Location:</strong> Casablanca, Morocco</p>
                <p><strong>Dates:</strong> 17–18 December 2026</p>
                <p>For questions about getting to the venue, please <a href="{{ route('contact') }}">contact the organizing committee</a>.</p>
            </div>
        </div>
    </div>
@endsection
