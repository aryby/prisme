@extends('layouts.app')

@section('title', 'Author Instructions -SIPRISME 2026')
@section('description',
    'Detailed instructions for authors submitting papers toSIPRISME 2026, including preparation, formatting, peer review, and submission requirements.')

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
                All materials submitted to theSIPRISME'26 Symposium must be original, unpublished research that is not
                currently under review for any other Symposium or journal. Papers that do not comply with these guidelines
                may be rejected without review. Submissions received after the deadline, exceeding the length limit, or not
                appropriately structured may also be declined.
            </p>
            <p>
                <span class="alert-dark bold">Full papers</span> must be written in English and submitted in Word format.
                Each manuscript should be between 10 and 20 pages in length.
            </p>
            <p>
                <span class="alert-dark">Abstracts</span> must be submitted in English or French in Word format.
            </p>
            <p>
                <strong>
                    TheSIPRISME templates for preparing full papers and abstracts can be downloaded here:
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
            <li>The Symposium will check plagiarism for all articles before publication.</li>
            <li>If plagiarism is detected by the Scientific Committee, peer reviewers, or staff members at any stage of the publication process, the author will be informed and required to revise the manuscript.</li>
            <li>If the submitted manuscript is more than 20% plagiarized, the article will be rejected and the author will be notified.</li>
            <li>Paper content must be original, unpublished, and relevant to one of the Symposium topics.</li>
            <li>Acceptance decisions will take into account novelty, technical depth, elegance, and practical and theoretical impact.</li>
            <li>Each paper will be reviewed by two Scientific Committee members.</li>
            <li>Changes cannot be made during the review process. If accepted, minor revisions may be made prior to final submission.</li>
        </ul>
    </div>

    <div class="row-fluid top0">
        <div class="alert-info">
            <h4 class="alert-info mb-0 pb-0"><strong>| Submission</strong></h4>
        </div>
    </div>

    <div class="panel1">
        <div class="span11">
            <p><strong>Abstract submission:</strong> Authors who wish to present their research at the Symposium without pursuing publication are encouraged to submit an abstract by 15 November 2026.</p>
            <p><strong>Full paper submission:</strong> Authors seeking publication opportunities must submit a full paper by 9 December 2026. All submissions will undergo a rigorous peer-review process.</p>
            <p><strong>Publication:</strong> Accepted papers will have the opportunity to be published in one of the following outlets:</p>
            <ul>
                <li>International Journal of Intelligent Management and Data Systems</li>
                <li>The International Journal of Economic and Management Decisions</li>
            </ul>
            <p>
                The Scientific Committee will recommend the most suitable publication outlet for each accepted paper based on its topic and quality. Authors will be kept informed throughout the review and selection process.
            </p>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection
