<!-- resources/views/persons/modify.blade.php -->
@extends('layout')

@section('content')
    <h1>Editar Persona</h1>
    <form action="{{ route('persons.update', $person->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="full_name">Nombre Completo:</label>
        <input type="text" name="full_name" value="{{ $person->full_name }}" required>
        <br>

        <label for="dni">DNI:</label>
        <input type="text" name="dni" value="{{ $person->dni }}" required>
        <br>

        <label for="birth_date">Fecha de Nacimiento:</label>
        <input type="date" name="birth_date" value="{{ $person->birth_date }}" required>
        <br>

        <button type="submit">Actualizar</button>
    </form>
    
@endsection
