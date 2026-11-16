@extends('layouts.app')

@section('title', 'Author Instructions -SIPRISME 2026')
@section('description',
    'Detailed instructions for authors submitting papers to SIPRISME 2026, including preparation, formatting, peer review, and submission requirements.')

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <div class="titleborder">
                <div>Instructions for Authors</div>
            </div>
        </div>
    </div>

    <div class="row-fluid top0">
        <div class="alert-info">
            <h4 class="alert-info mb-0 pb-0"><strong>| Papers Preparation</strong></h4>
        </div>
    </div>

    <div class="panel1">
        <div class="span11">
            <p>
                {{ \App\Models\PageContent::text('author-instructions.preparation') }}
            </p>
            <p>
                <span class="alert-dark bold">Full papers</span> {{ \App\Models\PageContent::text('author-instructions.full-papers') }}
            </p>
            <p>
                <span class="alert-dark">Abstracts</span> {{ \App\Models\PageContent::text('author-instructions.abstracts') }}
            </p>
            <p>
                <strong>
                    The SIPRISME templates for preparing full papers and abstracts can be downloaded here:
                    <a href="{{ asset('downloads/full_prisme_template.docx') }}">Full paper template</a>
                    /
                    <a href="{{ asset('downloads/abstract_prisme_template.docx') }}">Abstract template</a>
                </strong>
            </p>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="row-fluid top0">
        <div class="alert-info">
            <h4 class="alert-info mb-0 pb-0"><strong>| Peer Review Process</strong></h4>
        </div>
        <ul class="uli">
            @foreach (preg_split('/\r\n|\r|\n/', \App\Models\PageContent::text('author-instructions.review')) as $reviewStep)
                @if (trim($reviewStep) !== '')
                    <li>{{ $reviewStep }}</li>
                @endif
            @endforeach
        </ul>
    </div>

    <div class="row-fluid top0">
        <div class="alert-info">
            <h4 class="alert-info mb-0 pb-0"><strong>| Submission</strong></h4>
        </div>
    </div>

    <div class="panel1">
        <div class="span11">
            <p><strong>Abstract submission:</strong> Authors who wish to present their research at the Symposium without pursuing publication are encouraged to submit an abstract by {{ \App\Models\PageContent::text('author-instructions.abstract-deadline') }}.</p>
            <p><strong>Full paper submission:</strong> Authors seeking publication opportunities must submit a full paper by {{ \App\Models\PageContent::text('author-instructions.paper-deadline') }}. All submissions will undergo a rigorous peer-review process.</p>
            <p><strong>Publication:</strong> Accepted papers will have the opportunity to be published in one of the following outlets:</p>
            <ul>
                @foreach (preg_split('/\r\n|\r|\n/', \App\Models\PageContent::text('author-instructions.publication-venues')) as $venue)
                    @if (trim($venue) !== '')
                        <li>{{ $venue }}</li>
                    @endif
                @endforeach
            </ul>
            <p>
                The Scientific Committee will recommend the most suitable publication outlet for each accepted paper based on its topic and quality. Authors will be kept informed throughout the review and selection process.
            </p>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection
