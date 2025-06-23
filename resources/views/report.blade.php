@extends('layouts.app')
@section('page_title', 'Report Page')
@section('main_content')
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="card p-4 shadow" style="width: 600px;">
            <h4 class="text-center fw-bold mb-3">Report</h4>

            @if (session('success'))
                <div class="alert alert-success" id="session-alert">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger" id="session-alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('report.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="violation_type" class="form-label">Report Type</label>
                    <select name="violation_type" id="violation_type" class="form-select" required>
                        <option value="">Select Report Type</option>
                        <option value="spam">Spam</option>
                        <option value="abuse">Abuse</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100"
                        style="width: 650px; height: 37px; --bs-btn-color: #ffff; --bs-btn-bg:#FF6801; --bs-btn-border-color: #FF6801; --bs-btn-hover-bg: #e75c00; --bs-btn-hover-border-color: #e75c00;">
                    Submit Report
                </button>
            </form>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const alert = document.getElementById('session-alert');
            if (alert) alert.style.display = 'none';
        }, 5000);
    </script>
@endsection
