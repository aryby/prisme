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
            {!! str(\App\Models\PageContent::text('program.page'))->sanitizeHtml() !!}
        </div>
    </div>
</div>
@endsection