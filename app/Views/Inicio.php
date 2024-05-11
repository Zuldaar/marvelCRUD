<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    <h1>Busqueda API Marvel</h1>
    <form action="Inicio/busqueda" method=post onsubmit="return validateForm(this)">
        <input type="text" name="searchTerm" placeholder="Introduce nombre del personaje...">
        <button type="submit" name="db" value="marvel">BusquedaMarvel</button>
        <button type="submit" name="db" value="local">BusquedaLocal</button>
    </form>
    <?php if(session()->get('mensaje')): ?>
    <div class="alert alert-success" role="alert">
        <?= session()->get('mensaje') ?>
    </div>
<?php endif; ?>
    <script>
        function validateForm(form) {
            var searchTerm = form.searchTerm.value;
            if (!searchTerm) {
                alert('Introduce un nombre de personaje');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
</html>
    