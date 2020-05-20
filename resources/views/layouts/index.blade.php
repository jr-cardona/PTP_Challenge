@extends('layouts.app')
@section('title')
    @yield('Title')
@endsection
<div></div>
@section('content')
    <div class="card card-default">
        <div class="shadow">
            <div class="card-header">
                <div class="row">
                    <div class="col text-left btn-group-sm">
                        @yield('Left-buttons')
                    </div>
                    <div class="col">
                        <h2 class="card-title mb-0 text-center text-nowrap">
                            @yield('Name')
                        </h2>
                    </div>
                    <div class="col text-right btn-group-sm">
                        @yield('Right-buttons')
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    @yield('Paginator')
                </div>
                <div class="d-flex justify-content-center">
                    @yield('Links')
                </div>
                <div class="table-responsive">
                    <table class="table border-rounded table-striped table-hover">
                        <thead class="custom-header">
                            <tr>
                                @yield('Header')
                            </tr>
                        </thead>
                        <tbody>
                            @yield('Body')
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        @yield('Links')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('modals')
    @include('partials.__export_modal')
    @include('partials.__confirm_delete_modal')
@endpush
@push('scripts')
    <script src="{{ asset(mix('js/export-modal.js')) }}"></script>
    <script src="{{ asset(mix('js/delete-modal.js')) }}"></script>
@endpush
