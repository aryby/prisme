@extends('layouts.app')

@section('content')
    <div class="row" style="margin-top: 40px; margin-bottom: 40px;">
        <div class="span6 offset3">
            <div class="well">
                <h3 class="text-center">Forgot your password?</h3>
                <p>Enter your email address and, if an account exists, we will send you a password reset link.</p>

                @if ($errors->any())
                    <div class="alert alert-error">
                        <ul style="margin-bottom: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

                    <button type="submit" class="btn btn-primary btn-block">Send password reset link</button>
                </form>

                <p class="text-center" style="margin-top: 15px; margin-bottom: 0;">
                    <a href="{{ route('login') }}">Back to login</a>
                </p>
            </div>
        </div>
    </div>
@endsection
