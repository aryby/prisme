@extends('layouts.app')

@section('title', 'Important Dates -SIPRISME 2026')
@section('description', 'Important dates and deadlines for the SIPRISME 2026 symposium. Submission timeline, acceptance notification, and Symposium schedule.')

@section('content')
<div class="row-fluid">
    <div class="span12">
        <div class="titleborder">
            <div>Important Dates</div>
        </div>
        <div class="text-center">
            <p class="lead">
                {{ \App\Models\PageContent::text('important-dates.intro') }}
            </p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Stage</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($importantDates as $importantDate)
                        <tr>
                            <td>{{ $importantDate->title }}</td>
                            <td>{{ $importantDate->date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
