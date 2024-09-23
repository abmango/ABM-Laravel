@extends('layout')

@section('content')
    <h1>
        @if($personId)
            Teléfonos de {{ $personName }} (ID de persona: {{ $personId }})
        @else
            Gestión de teléfonos
        @endif
    </h1>

    <!-- Botón para alta de nueva persona -->
    <a href="{{ route('phones.create') }}" class="btn btn-primary mb-3">Alta de Celular</a>

    <!-- Botón para cambiar entre personas activas y eliminadas -->
    @if($showDischarges)
        <a href="{{ route('phones.index', ['discharges' => 'false']) }}" class="btn btn-secondary mb-3">Mostrar Activos</a>
    @else
        <a href="{{ route('phones.index', ['discharges' => 'true']) }}" class="btn btn-secondary mb-3">Mostrar Dadas de Baja</a>
    @endif

    <a href="{{ route('persons.index') }}" class="btn btn-primary mb-3">Volver a Personas</a>

    <!-- Tabla de teléfonos -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Número de teléfono</th>
                <th>Fecha de Alta</th>
                <th>Fecha de Baja</th>
                <th>Última modificación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($phones as $phone)
                <tr>
                    <td>{{ $phone->id }}</td>
                    <td>{{ $phone->phone_number }}</td>
                    <td>{{ $phone->created_at }}</td>
                    <td>{{ $phone->deleted_at ? $phone->deleted_at : 'N/A' }}</td>
                    <td>{{ $phone->updated_at ? $phone->updated_at : 'N/A' }}</td>
                    <td>
                        <a href="{{ route('phones.edit', $phone->id) }}" class="btn btn-warning">Editar</a>
                        @if($showDischarges)
                            <!-- Botón para restaurar un celular eliminado -->
                            <form action="{{ route('phones.restore', $phone->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">Restaurar</button>
                            </form>
                        @else
                            <!-- Botón para eliminar (soft delete) un celular -->
                            <form action="{{ route('phones.destroy', $phone->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Dar de Baja</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay teléfonos disponibles</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
