<!-- resources/views/persons/index.blade.php -->
@extends('layout')

@section('content')
    <h1>Gestión de Personas</h1>

    <!-- Botón para alta de nueva persona -->
    <a href="{{ route('persons.create') }}" class="btn btn-primary mb-3">Alta de Persona</a>

    <!-- Botón para cambiar entre personas activas y eliminadas -->
    @if($showDischarges)
        <a href="{{ route('persons.index', ['discharges' => 'false']) }}" class="btn btn-secondary mb-3">Mostrar Activos</a>
    @else
        <a href="{{ route('persons.index', ['discharges' => 'true']) }}" class="btn btn-secondary mb-3">Mostrar Dadas de Baja</a>
    @endif

    <!-- Tabla de personas -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>DNI</th>
                <th>Fecha de Nacimiento</th>
                <th>Fecha de Ingreso</th>
                <th>Fecha de Egreso</th>
                <th>Última modificación</th>
                <th>Teléfonos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($persons as $person)
                <tr>
                    <td>{{ $person->id }}</td>
                    <td>{{ $person->full_name }}</td>
                    <td>{{ $person->dni }}</td>
                    <td>{{ $person->birth_date }}</td>
                    <td>{{ $person->created_at }}</td>
                    <td>{{ $person->deleted_at ? $person->deleted_at : 'N/A' }}</td>
                    <td>{{ $person->updated_at ? $person->updated_at : 'N/A'  }}</td>
                    <td>
                        <!-- Enlace a la vista de teléfonos de la persona -->
                        <a href="{{ url('phones/' . $person->id) }}">Ver Teléfonos</a>
                    </td>
                    <td>
                        <a href="{{ route('persons.edit', $person->id) }}" class="btn btn-warning">Editar</a>
                        @if($showDischarges)
                            <!-- Botón para restaurar una persona eliminada -->
                            <form action="{{ route('persons.restore', $person->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">Restaurar</button>
                            </form>
                        @else
                            <!-- Botón para eliminar (soft delete) una persona -->
                            <form action="{{ route('persons.destroy', $person->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Dar de Baja</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection