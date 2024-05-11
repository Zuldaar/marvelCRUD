<?php helper('url'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busqueda Marvel</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
<body>
    <?php foreach ($characters as $character): ?>
        <div class="character">
            <h3><?php echo $character['name']; ?></h3>
            <p><?php echo $character['description']; ?></p>
            <?php if (empty(model('MarvelModels')->ejecutarModelo($character['id'],4))) : ?>
                <form action="insertar" method="post">
                    <input type="hidden" name="id" value="<?php echo $character['id']; ?>">
                    <input type="hidden" name="name" value="<?php echo $character['name']; ?>">
                    <input type="hidden" name="description" value="<?php echo $character['description']; ?>">
                    <button type="submit">Insertar</button>
                </form>
            <?php else: ?>
                <form action="eliminar" method="post">
                    <input type="hidden" name="id" value="<?php echo $character['id']; ?>">
                    <button type="submit">Eliminar</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</body>
</html>

