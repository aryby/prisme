@extends('layouts.app')

@section('content')
    <div class="row" style="margin-top: 40px; margin-bottom: 40px;">
        <div class="span6 offset3">
            <div class="well">
                <h3 class="text-center">Reset your password</h3>

                @if ($errors->any())
                    <div class="alert alert-error">
                        <ul style="margin-bottom: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required autofocus>

                    <label for="password">New password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password">

                    <label for="password_confirmation">Confirm new password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">

                    <button type="submit" class="btn btn-primary btn-block">Reset password</button>
                </form>
            </div>
        </div>
    </div>
@endsection
