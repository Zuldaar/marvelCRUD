<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    <h1>Página de Inicio</h1>
    <?php echo site_url('search'); ?>
    <form action="<?= site_url('search') ?>" method="GET">
        <input type="text" name="searchTerm" placeholder="Introduce nombre del personaje...">
        <button type="submit">Buscar</button>
    </form>
</body>
</html>