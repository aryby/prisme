@extends('layouts.app')

@section('title', 'Paper Submission -SIPRISME 2026')
@section('description', 'Submission guidelines forSIPRISME 2026. Learn about abstract and full paper requirements, review process, and submission details.')

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <div class="titleborder">
                <div>Paper Submission</div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span12">
            <div class="well">
                <h3>Submission Modalities</h3>
                <p>
                    Submission takes place in two stages: an abstract first, followed by the full paper after acceptance.
                </p>

                <h4>Extended abstract</h4>
                <ul>
                    <li>500 to 800 words, in French, English, or Arabic</li>
                    <li>Title, author name(s), affiliations, and email address</li>
                    <li>Selected thematic axis</li>
                    <li>Research problem, theoretical framework, methodology, and expected main results</li>
                    <li>3 to 5 keywords</li>
                </ul>

                <h4>Full paper</h4>
                <ul>
                    <li>15 to 20 pages, including references and appendices</li>
                    <li>Times New Roman 12 font, 1.5 line spacing</li>
                    <li>Bibliographic references in APA style (7th edition)</li>
                </ul>

                <p>
                    Proposals are evaluated through a double-blind peer review process by the Scientific Committee. Upload your paper as a PDF using the form below.
                </p>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span12">
            <div class="titleborder">
                <div>Submit Your Paper</div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span12">
            <form class="form-horizontal" action="{{ route('submission.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="well">
                    <h3>Paper Information</h3>
                    <div class="control-group">
                        <label class="control-label" for="submission_option">Submission Option *</label>
                        <div class="controls">
                            <select id="submission_option" name="submission_option" class="input-xlarge" required>
                                <option value="">Select an Option</option>
                                <option value="full_submission">Full Submission</option>
                                <option value="abstract_submission">Abstract Submission</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="title">Paper Title *</label>
                        <div class="controls">
                            <input type="text" id="title" name="title" class="input-xlarge" required
                                placeholder="Enter your paper title">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="track">Symposium Track *</label>
                        <div class="controls">
                            <select id="track" name="track" class="input-xlarge" required>
                                <option value="">Select a track</option>
                                <option value="digital-economy">Digital Economy, Governance & Policy</option>
                                <option value="smart-business">Smart Business Models and Innovation</option>
                                <option value="data-analytics">Data Innovation and Analytics</option>
                                <option value="emerging-tech">Emerging Technologies and Applications</option>
                                <option value="regional-case">Regional and Sectoral Case Studies</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="abstract">Abstract *</label>
                        <div class="controls">
                            <textarea id="abstract" name="abstract" rows="4" class="input-xlarge" required
                                placeholder="Enter your abstract (150-250 words)"></textarea>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="keywords">Keywords *</label>
                        <div class="controls">
                            <input type="text" id="keywords" name="keywords" class="input-xlarge" required
                                placeholder="Enter 3-5 keywords separated by commas">
                        </div>
                    </div>
                </div>

                <div class="well">
                    <h3>Author Information</h3>

                    <div class="control-group">
                        <label class="control-label" for="name">Full Name *</label>
                        <div class="controls">
                            <input type="text" id="name" name="name" class="input-xlarge" required
                                placeholder="Enter your full name">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="email">Email Address *</label>
                        <div class="controls">
                            <input type="email" id="email" name="email" class="input-xlarge" required
                                placeholder="Enter email address">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="affiliation">Affiliation *</label>
                        <div class="controls">
                            <input type="text" id="affiliation" name="affiliation" class="input-xlarge" required
                                placeholder="Enter your institution/organization">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="country">Country *</label>
                        <div class="controls">
                            <select id="country" name="country" class="input-xlarge" required>
                                <option value="">Select your country</option>
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                                <option value="UK">United Kingdom</option>
                                <option value="DE">Germany</option>
                                <option value="FR">France</option>
                                <option value="JP">Japan</option>
                                <option value="CN">China</option>
                                <option value="IN">India</option>
                                <option value="AU">Australia</option>
                                <option value="MA">Morocco</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="phone">Phone Number</label>
                        <div class="controls">
                            <input type="tel" id="phone" name="phone" class="input-xlarge"
                                placeholder="Enter phone number">
                        </div>
                    </div>
                </div>

                <div class="well">
                    <h3>Paper Upload</h3>
                    <div class="control-group">
                        <label class="control-label" for="file">Upload Paper *</label>
                        <div class="controls">
                            <input type="file" id="file" name="file" accept=".pdf" required>
                            <p class="help-block">PDF format only, maximum file size: 10 MB.</p>
                        </div>
                    </div>
                </div>

                <div class="well">
                    <h3>Terms and Conditions</h3>

                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" name="originality" required>
                                I confirm that this paper is original and has not been published elsewhere, nor is it currently under review by another Symposium or journal. *
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" name="copyright" required>
                                I agree to transfer copyright toSIPRISME 2026 if the paper is accepted for publication. *
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" name="attendance" required>
                                I understand that at least one author must register and attend the Symposium to present the paper if accepted. *
                            </label>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary btn-large">Submit Paper</button>
                        <button type="reset" class="btn btn-default btn-large">Reset Form</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
