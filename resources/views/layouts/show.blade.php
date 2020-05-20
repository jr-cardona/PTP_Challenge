@extends('layouts.app')
@section('title')
    @yield('Title')
@endsection
@section('content')
    <div class="card shadow">
        <div class="card-header">
            <div class="row">
                <div class="col btn-group-sm">
                    @yield('Back')
                </div>
                <div class="col">
                    <h3 class="card-title mb-0 text-center text-nowrap">
                        @yield('Name')
                    </h3>
                </div>
                <div class="col text-right btn-group-sm">
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
