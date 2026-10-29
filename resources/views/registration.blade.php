@extends('layouts.app')

@section('title', 'Registration - PRISME 2026')
@section('description', 'Register for PRISME 2026 - The Multidisciplinary Research Laboratory in Social Engineering and Business
 Management (PRISME). Early registration available until March 1st, 2026.')

@section('content')
<!-- Page Header -->

<!-- Registration Form -->
<div class="row-fluid">
    <div class="span12">
        <div class="titleborder">
            <div>Registration Form</div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <form class="form-horizontal" method="POST" action="{{ route('registration.store') }}" enctype="multipart/form-data">
            @csrf
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <h4>Please correct the following errors:</h4>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="control-group">
                <label class="control-label" for="fullName">Full Name *</label>
                <div class="controls">
                    <input type="text" id="fullName" name="fullName" class="input-xlarge" value="{{ old('fullName') }}" required>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="email">Email Address *</label>
                <div class="controls">
                    <input type="email" id="email" name="email" class="input-xlarge" value="{{ old('email') }}" required>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="affiliation">Institution/Affiliation *</label>
                <div class="controls">
                    <input type="text" id="affiliation" name="affiliation" class="input-xlarge" value="{{ old('affiliation') }}" required>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="country">Country *</label>
                <div class="controls">
                    <input type="text" id="country" name="country" class="input-xlarge" value="{{ old('country') }}" required>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="registrationType">Registration Type *</label>
                <div class="controls">
                    <select id="registrationType" name="registrationType" class="input-xlarge" required>
                        <option value="">Select Registration Type</option>
                        <option value="student" {{ old('registrationType') == 'student' ? 'selected' : '' }}>Student paper registration</option>
                        <option value="professional" {{ old('registrationType') == 'professional' ? 'selected' : '' }}>Professional / Researcher paper registration</option>
                        <option value="extra" {{ old('registrationType') == 'extra' ? 'selected' : '' }}>Extra Paper registration</option>
                        <option value="abstract" {{ old('registrationType') == 'abstract' ? 'selected' : '' }}>Abstract registration</option>
                        <option value="attending" {{ old('registrationType') == 'attending' ? 'selected' : '' }}>Authors Attending registration</option>
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="recept_payment"> Recept payment
                </label>
                <div class="controls">
                    <input type="text" id="recept_payment" name="recept_payment" class="input-xlarge" value="{{ old('recept_payment') }}">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="paperId">Paper ID (if applicable)</label>
                <div class="controls">
                    <input type="text" id="paperId" name="paperId" class="input-xlarge">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="dietary">Dietary Requirements</label>
                <div class="controls">
                    <textarea id="dietary" name="dietary" class="input-xlarge" rows="3">{{ old('dietary') }}</textarea>
                </div>
            </div>
            
            <div class="control-group">
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" name="terms" required> I agree to the terms and conditions *
                    </label>
                </div>
            </div>
            
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary btn-large">Submit Registration</button>
                    <button type="reset" class="btn btn-default btn-large">Reset Form</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Further Inquiry -->
<div class="row-fluid">
    <div class="span12">
        <div class="alert alert-info">
            <h4>Further Inquiry</h4>
            <p>For any other related information or inquiry regarding the payment, the transaction methods, or difficulties in the registration process, the authors should send an email as soon as possible to <strong>prisme26@prisme.org</strong> with PaperID, Paper Title, Author(s), and Affiliation included.</p>
        </div>
    </div>
</div>
@endsection