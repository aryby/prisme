@extends('layouts.app')

@section('title', \App\Models\PageContent::text('committee.title'))
@section('description', \App\Models\PageContent::text('committee.description'))

@section('content')
    <div class="row-fluid committee-content">
        {!! str(\App\Models\PageContent::text('committee.page'))->sanitizeHtml() !!}
    </div>
@endsection
