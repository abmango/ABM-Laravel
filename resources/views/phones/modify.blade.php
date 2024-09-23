<!-- resources/views/phones/modify.blade.php -->
@extends('layout')

@section('content')
    <h1>Editar Celular</h1>
    <form action="{{ route('phones.update', $phone->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="phone_number">Número de celular:</label>
        <input type="text" name="phone_number" value="{{ $phone->phone_number }}" required>
        <br>

        <!-- Dropdown para seleccionar la persona -->
        <label for="person_id">Asociar a Persona:</label>
        <select name="person_id" required>
            @foreach ($persons as $person)
                <option value="{{ $person->id }}" {{ $person->id == $phone->person_id ? 'selected' : '' }}>
                    {{ $person->full_name }} (ID: {{ $person->id }})
                </option>
            @endforeach
        </select>
        <br>

        <button type="submit">Actualizar</button>
    </form>
    
@endsection
