{{ ("Mostrando registros (") }}
@empty($request->get('page'))
    @if($count > 0)
        {{ 1 }}
    @else
        {{ 0 }}
    @endif
@else
    {{ $paginate * ($request->get('page') - 1) + 1 }}
@endempty
-
@empty($request->get('page'))
	@if(($paginate) > $count)
		{{ $count }}
	@else
		{{ $paginate }}
	@endif
@else
    @if(($request->get('page') * $paginate) > $count)
        {{ $count }}
    @else
        {{ ($request->get('page') * $paginate) }}
    @endif
@endempty
{{ (") de") }} {{ $count }}
