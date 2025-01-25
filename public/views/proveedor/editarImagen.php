<?php
require_once(__DIR__ . '/../../../src/Logic/Evento.php');

$idEvento = isset($_GET['idEvento']) ? intval($_GET['idEvento']) : 0;

$error = 0;
if(isset($_POST["editar"])){    
    $nombre = $_FILES["imagen"]["name"];
    $extension = pathinfo($nombre, PATHINFO_EXTENSION);
    $extensiones = array('jpg','png','jpeg');
    if(in_array($extension, $extensiones)){
        $tam = $_FILES["imagen"]["size"] / 1024;
        if($tam < 150){
            $rutaLocal = $_FILES["imagen"]["tmp_name"];
            $rutaServidor = "assets/images/";
            $nombreImagen = time() . "." . $extension;
            $evento = new Evento($idEvento);
            $evento -> consultar();
            if($evento -> getImagen() != "defaultImg.jpeg"){
                unlink($rutaServidor . $evento->getImagen());
            }
            copy($rutaLocal, $rutaServidor .$nombreImagen);
            $evento = new Evento($idEvento, "", 0, 0,  $nombreImagen);
            $evento -> editarImagen();
            
        }else{
            $error = 2;
        }
    }else{
        $error = 1;
    }    
    
}
$evento = new Evento($idEvento);
$evento -> consultar();
?>
<div class="container">
	<div class="row mt-5">
		<div class="col-4"></div>
		<div class="col-4">
			<div class="card border-primary">
				<div class="card-header text-bg-info">
					<h4>Editar Imagen del Producto <br><?php echo $evento -> getNombreEvento()?></h4>
				</div>
				<div class="card-body">
    				<?php 
    				if (isset($_POST["editar"])) { 
    				    if($error == 0){
    				        echo "<div class='alert alert-success mt-3' role='alert'>Imagen editada</div>";
    				    }else if($error == 1){
    				        echo "<div class='alert alert-danger mt-3' role='alert'>Tipo de imagen no permitido</div>";
    				    }else if($error == 2){
    				        echo "<div class='alert alert-danger mt-3' role='alert'>Tamaño de imagen no permitido</div>";
    				    }
    				}    				    
    				?>
					<form method="post"
						action="/editarImagen?idEvento=<?php echo $idEvento; ?>"
						enctype="multipart/form-data">
						<div class="mb-3">
							<input type="file" name="imagen" class="form-control"
								placeholder="Nombre" value="<?php echo $evento -> getNombreEvento() ?>" required>
						</div>
						<button type="submit" name="editar" class="btn btn-primary">Editar Evento</button>
						
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>