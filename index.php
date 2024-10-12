<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php 
    $paginaAnterior = basename(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php');
    include 'navbar.php';
    ?>
    <div class="container mt-4">
        <div class="justify-content-center">
            <a href="evento.php" class="d-block">
                <img src="https://images3.alphacoders.com/134/1342988.png" alt="Descripción de la imagen" class="img-fluid" style="width: 100%; height: auto; max-height: 200px;">
            </a>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <a href="evento.php">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQcsamIIWIUgcWw2ixCCJckQWeQCh8v9okslw&s" class="img-fluid" style="height: 300px">
                </a>
            </div>
            <div class="col-md-4 mb-4">
                <a href="evento.php">
                    <img src="https://wallpapers.com/images/hd/naruto-symbol-spiral-47j8agm8t758a4qo.jpg" class="img-fluid" style="height: 300px">
                </a>
            </div>
            <div class="col-md-4 mb-4">
                <a href="evento.php">
                    <img src="https://w0.peakpx.com/wallpaper/431/713/HD-wallpaper-naruto-logo-anime-8k-naruto-anime-logo-thumbnail.jpg" class="img-fluid" style="height: 300px">
                </a>
            </div>
        </div>
    </div>

    <?php include 'footer.php' ?>
</body>

</html>