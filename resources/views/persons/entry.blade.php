<!-- resources/views/persons/entry.blade.php -->
@extends('layout')

@section('content')
    <h1>Crear Persona</h1>
    <form action="{{ route('persons.store') }}" method="POST">
        @csrf
        <label for="full_name">Nombre Completo:</label>
        <input type="text" name="full_name" required>
        <br>
        <label for="dni">DNI:</label>
        <input type="text" name="dni" required>
        <br>
        <label for="birth_date">Fecha de Nacimiento:</label>
        <input type="date" name="birth_date" required>
        <br>
        <br>
        <label for="entry_date">Fecha de Ingreso:</label>
        <input type="date" name="entry_date" required>
        <br>
        <button type="submit">Guardar</button>
    </form>
@endsection
