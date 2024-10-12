<?php
session_start();
require_once("logica/Cliente.php");
$error = false;

if(isset($_POST["autenticar"])){
    $cliente = new Cliente(null, null, null, $_POST["correo"],$_POST["clave"]);
	$paginaAnterior = basename(isset($_GET['paginaAnterior']) ? $_GET['paginaAnterior'] : 'index.php');
    if($cliente -> autenticar()){
        $_SESSION["id"] = $cliente -> getIdCliente();
        header("Location: $paginaAnterior"); 
    }else{
        $error = true;
    }    
}
?>
<html>
<head>
<link
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
	rel="stylesheet">
<script
	src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
		<div class="row mt-5">
			<div class="col-4"></div>
			<div class="col-4">
				<div class="card border-primary">
					<div class="card-header text-bg-info">
						<h4>Iniciar Sesion</h4>
					</div>
					<div class="card-body">
					<?php $paginaAnterior = basename(isset($_GET['paginaAnterior']) ? $_GET['paginaAnterior'] : 'index.php');?>
						<form method="post" action="iniciarSesion.php?paginaAnterior=<?php echo urlencode($paginaAnterior); ?>" >
							<div class="mb-3">
								<input type="email" name="correo" class="form-control" placeholder="Correo" >
							</div>
							<div class="mb-3">
								<input type="password" name="clave" class="form-control" placeholder="Clave">
							</div>
							<button type="submit" name="autenticar" class="btn btn-primary">Iniciar Sesion</button>
							<?php if($error){ ?>
                            <div class="alert alert-danger mt-3" role="alert">
                            	Error de correo o clave
							</div>    
							<?php } ?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>