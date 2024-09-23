<!-- resources/views/phones/entry.blade.php -->
@extends('layout')

@section('content')
    <h1>Crear Celular</h1>
    <form action="{{ route('phones.store') }}" method="POST">
        @csrf
        
        <label for="phone_number">Número de teléfono:</label>
        <input type="text" name="phone_number" required>
        <br>
        
        <button type="submit">Guardar</button>
    </form>
@endsection
