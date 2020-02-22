@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <h3>{{ session('success') }}</h3>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h3>{{ session('error') }}</h3>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(session()->has('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <h3>{{ session('info') }}</h3>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
