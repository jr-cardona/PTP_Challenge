@extends('layouts.app')
@section('title')
    @yield('Title')
@endsection
@section('content')
    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="d-flex justify-content-between">
        <h2 class="card-title">
            <i class="fa fa-search"></i> {{ __("Buscar") }} @yield('Name')
        </h2>
        <div>
            @yield('Actions')
        </div>
    </div>
    <br>
    @yield('Search')
    <br>
    <table class="table border-rounded table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                @yield('Header')
            </tr>
        </thead>
        <tbody>
            @yield('Body')
        </tbody>
    </table>
    <div class="mt-3 d-flex justify-content-center">
        @yield('Links')
    </div>
@endsection
@push('modals')
    @include('partials.__confirm_delete_modal')
    @include('partials.__import_modal')
@endpush
@push('scripts')
    <script src="{{ asset(mix('js/app.js')) }}"></script>
    <script src="{{ asset(mix('js/delete-modal.js')) }}"></script>
    <script src="{{ asset(mix('js/import-modal.js')) }}"></script>
@endpush
