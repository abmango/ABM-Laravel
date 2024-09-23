<!-- resources/views/layouts/layout.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Aquí van tus estilos -->
</head>
<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header>
    <!-- Contenido del encabezado -->
</header>

<main>
    @yield('content') <!-- Aquí se insertará el contenido de las vistas que extienden este layout -->
</main>

<footer>
    <!-- Contenido del pie de página -->
</footer>
</body>
</html>
