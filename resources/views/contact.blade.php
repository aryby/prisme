@extends('layouts.app')

@section('title', 'Contact -SIPRISME 2026')
@section('description', 'Contact the SIPRISME 2026 organizing committee.')

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <div class="titleborder">
                <div>Contact</div>
            </div>
            <div class="well">
                <h2>Get in touch</h2>
                <p>For questions about SIPRISME 2026, paper submissions, or participation, contact the organizing committee by email.</p>
                <p><strong>Email:</strong> <a href="mailto:siprisme26@siprisme.org">siprisme26@siprisme.org</a></p>
                <p><strong>Symposium dates:</strong> 17–18 December 2026</p>
                <p><strong>Venue:</strong> Casablanca, Morocco. See the <a href="{{ route('venue') }}">venue page</a> for details.</p>
            </div>

            @if (session('contact_status'))
                <div class="alert alert-success">{{ session('contact_status') }}</div>
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
                <h2>Send us a message</h2>
                <form action="{{ route('contact.store') }}" method="POST" class="form-horizontal">
                    @csrf
                    <div class="control-group">
                        <label class="control-label" for="name">Name</label>
                        <div class="controls">
                            <input type="text" id="name" name="name" class="input-xlarge"
                                value="{{ old('name') }}" maxlength="255" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="email">Email</label>
                        <div class="controls">
                            <input type="email" id="email" name="email" class="input-xlarge"
                                value="{{ old('email') }}" maxlength="255" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="subject">Subject</label>
                        <div class="controls">
                            <input type="text" id="subject" name="subject" class="input-xlarge"
                                value="{{ old('subject') }}" maxlength="255" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="message">Message</label>
                        <div class="controls">
                            <textarea id="message" name="message" rows="6" class="input-xlarge"
                                maxlength="10000" required>{{ old('message') }}</textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary">Send message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
