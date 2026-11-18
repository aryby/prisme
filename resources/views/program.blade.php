@extends('layouts.app')

@section('title', \App\Models\PageContent::text('program.title'))
@section('description', \App\Models\PageContent::text('program.description'))

@section('content')
<div class="row-fluid">
    <div class="span12">
        <div class="titleborder">
            <div>Program</div>
        </div>
        <div class="well">
            @php($programPage = \App\Models\PageContent::query()->where('key', 'program.page')->first())
            @if (filled($programPage?->builder_content))
                {!! $programPage->renderBuilder('builder_content', app()->getLocale()) !!}
            @else
                {!! str(\App\Models\PageContent::text('program.page'))->sanitizeHtml() !!}
            @endif
        </div>
    </div>
</div>
@endsection