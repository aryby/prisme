@extends('layouts.app')

@section('title', \App\Models\PageContent::text('committee.title'))
@section('description', \App\Models\PageContent::text('committee.description'))

@section('content')
    <div class="row-fluid committee-content">
        @php($committeePage = \App\Models\PageContent::query()->where('key', 'committee.page')->first())
        @if (filled($committeePage?->builder_content))
            {!! $committeePage->renderBuilder('builder_content', app()->getLocale()) !!}
        @else
            {!! str(\App\Models\PageContent::text('committee.page'))->sanitizeHtml() !!}
        @endif
    </div>
@endsection
