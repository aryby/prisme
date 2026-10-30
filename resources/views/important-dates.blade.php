@extends('layouts.app')

@section('title', 'Important Dates -SIPRISME 2026')
@section('description', 'Important dates and deadlines for theSIPRISME 2026 symposium. Submission timeline, acceptance notification, and Symposium schedule.')

@section('content')
<div class="row-fluid">
    <div class="span12">
        <div class="titleborder">
            <div>Important Dates</div>
        </div>
        <div class="text-center">
            <p class="lead">
                The schedule below is a proposed timeline, subject to adjustment by the organizing committee.
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
                    <tr>
                        <td>Abstract submission deadline</td>
                        <td>15 November 2026</td>
                    </tr>
                    <tr>
                        <td>Notification of acceptance</td>
                        <td>19 November 2026</td>
                    </tr>
                    <tr>
                        <td>Submission of complete papers</td>
                        <td>9 December 2026</td>
                    </tr>
                    <tr>
                        <td>Symposium held at ESTC Casablanca</td>
                        <td>17-18 December 2026</td>
                    </tr>
                    <tr>
                        <td>Submission of final versions for publication</td>
                        <td>31 January 2027</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
