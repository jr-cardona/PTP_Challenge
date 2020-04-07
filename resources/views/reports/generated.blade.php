@extends('layouts.index')
@section('Title', 'Reportes generados')
@section('Left-buttons')
    <a href="{{ url()->previous() }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
    </a>
@endsection
@section('Name')
    {{ __("Reportes generados") }}
@endsection
@section('Paginator')
    @include('partials.__pagination', [
        'from'  => $reports->firstItem() ?? 0,
        'to'    => $reports->lastItem() ?? 0,
        'total' => $reports->total(),
    ])
@endsection
@section('Links')
    {{ $reports->links() }}
@endsection
@section('Header')
<tr>
    <th class="text-center">{{ __("Nombre de archivo") }}</th>
    <th class="text-center">{{ __("Tipo de archivo") }}</th>
    <th>{{ __("Fecha de generación") }}</th>
    <th>{{ __("Generado por") }}</th>
    <th class="text-center">{{ __("Opciones") }}</th>
</tr>
@endsection
@section('Body')
    @forelse($reports as $report)
        <tr>
            <td class="text-center">{{ strtoupper($report->file_prefix) }}</td>
            <td class="text-center">{{ strtoupper($report->extension) }}</td>
            <td>{{ $report->created_at }}</td>
            <td>{{ $report->user->fullname }}</td>
            <td class="text-center">
                @can('download', $report)
                    <a class="btn btn-sm btn-primary"
                       href="{{ route('reports.download', $report) }}" title="Descargar">
                        <i class="fa fa-download"></i>
                    </a>
                @endcan
                @can('delete', $report)
                    <button type="submit" class="btn btn-sm btn-danger" form="deleteReport"
                            title="Eliminar">
                        <i class="fa fa-trash"></i>
                    </button>
                    <form id="deleteReport"
                          action="{{ route('reports.destroy', $report) }}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                @endcan
            </td>
        </tr>
    @empty
        <td colspan="5" class="p-3">
            <p class="alert alert-secondary text-center">
                {{ __('No se encontraron reportes') }}
            </p>
        </td>
    @endforelse
@endsection
