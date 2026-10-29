@extends('layouts.app')

@section('content')
    <div class="row" style="margin-top: 40px; margin-bottom: 40px;">
        <div class="span6 offset3">
            <div class="well">
                <h3 class="text-center">Login</h3>

                @if ($errors->any())
                    <div class="alert alert-error">
                        <ul style="margin-bottom: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>

                    <label class="checkbox">
                        <input type="checkbox" name="remember" value="1"> Remember me
                    </label>

                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection
