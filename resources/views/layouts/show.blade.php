@extends('layouts.app')
@section('title')
    @yield('Title')
@endsection
@section('content')
    <div class="d-flex justify-content-between">
        @yield('Back')
    </div>
    <p></p>
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title mb-0">@yield('Name')</h3>
            <div>
                <div class="btn-group btn-group-sm">
                    @yield('Buttons')
                </div>
            </div>
        </div>
        <div class="card-body">
            @yield('Body')
        </div>
    </div>
@endsection
@push('modals')
    @include('partials.__confirm_delete_modal')
@endpush
@push('scripts')
    <script src="{{ asset('js/delete-modal.js') }}"></script>
@endpush
