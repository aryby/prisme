@extends('layouts.app')

@section('title', 'Author Dashboard')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h1 class="h3 mb-2">Welcome, {{ Auth::user()->name }}</h1>
                        <p class="text-muted mb-0">Your author panel is ready.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="text-muted small text-uppercase">Total Papers</div>
                        <div class="display-6 fw-bold mt-2">{{ Auth::user()->papers()->count() }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="text-muted small text-uppercase">Under Review</div>
                        <div class="display-6 fw-bold mt-2">{{ Auth::user()->papers()->where('status', 'under_review')->count() }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="text-muted small text-uppercase">Accepted</div>
                        <div class="display-6 fw-bold mt-2">{{ Auth::user()->papers()->where('status', 'accepted')->count() }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('author.papers.create') }}" class="btn btn-primary">Submit a paper</a>
        </div>
    </div>
@endsection
