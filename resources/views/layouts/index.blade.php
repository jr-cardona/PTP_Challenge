@extends('layouts.app')
@section('title')
    @yield('Title')
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <h1>@yield('Name')</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            @yield('Create')
        </div>
    </div>
    <br>
    @yield('Links')
    <table class="table border-rounded table-striped table-hover">
        <thead class="thead-dark">
            <tr class="text-center">
                @yield('Header')
            </tr>
        </thead>
        <tbody>
            @yield('Body')
        </tbody>
    </table>
@endsection
@push('modals')
    @include('partials.__confirm_delete_modal', ['side_effect' => $side_effect])
@endpush
@push('scripts')
    <script src="{{ asset(mix('js/delete-modal.js')) }}"></script>
@endpush
