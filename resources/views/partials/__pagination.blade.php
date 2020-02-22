Mostrando registros (
@empty($request->get('page'))
    {{ 1 }}
@else
    {{ $paginate * ($request->get('page') - 1) + 1 }}
@endempty
-
@empty($request->get('page'))
    {{ $paginate }}
@else
    @if(($request->get('page') * $paginate) > $count)
        {{ $count }}
    @else
        {{ ($request->get('page') * $paginate) }}
    @endif
@endempty
) de {{ $count }}
