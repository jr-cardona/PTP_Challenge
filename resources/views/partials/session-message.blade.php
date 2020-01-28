@if(session()->has('success'))
    <h4 class="alert alert-success">
        {{ session('success') }}
    </h4>
@endif
@if(session()->has('error'))
    <h4 class="alert alert-danger">
        {{ session('error') }}
    </h4>
@endif
@if(session()->has('info'))
    <h4 class="alert alert-info">
        {{ session('info') }}
    </h4>
@endif
