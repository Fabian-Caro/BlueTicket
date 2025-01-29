<?php
require_once(__DIR__ . '/../../../src/Logic/Cliente_boleta.php');
require_once(__DIR__ . '/../../../src/Logic/Cliente.php');

$cliente = new Cliente();
$nombreCliente = $cliente->getNombre();
?>
<style>
    body {
        background-color: #F8F9FA;
        font-family: 'Poppins', sans-serif;
    }

    .container {
        max-width: 900px;
        margin: 40px auto;
        padding: 30px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #007BFF;
        font-weight: bold;
        font-size: 32px;
        margin-bottom: 30px;
    }

    .table-responsive {
        margin-bottom: 30px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: center;
        font-size: 16px;
    }

    .table th {
        background-color: #007BFF;
        color: white;
        font-weight: bold;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .btn-primary {
        background-color: #007BFF;
        color: white;
        padding: 10px 20px;
        font-size: 14px;
        border: none;
        border-radius: 6px;
        transition: background 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056B3;
    }

    .text-center {
        text-align: center;
    }
</style>
<div class="container mt-5">
    <h2 class="text-center">Boletas Compradas</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre del Comprador</th>
                    <th>Nombre del Usuario</th>
                    <th>Nombre del Evento</th>
                    <th>Fecha del Evento</th>
                    <th>Descargar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $c_boleta = new Cliente_boleta();
                $boletas = $c_boleta->consultarBoletas($idCliente);
                foreach ($boletas as $temp) {
                    echo "<tr>";
                    echo "<td>" . $temp->getNombreCliente() . "</td>";
                    echo "<td>" . $temp->getNombreUsuario() . "</td>";
                    echo "<td>" . $temp->getNombreEvento() . "</td>";
                    echo "<td>" . $temp->getFecha() . "</td>";
                    echo "<td>";
                ?>
                    <form action='/generarQR.php' method='POST' target="_blank">
                        <input type='hidden' name='nombreCliente' value='<?php echo $temp->getNombreCliente(); ?>'>
                        <input type='hidden' name='nombreUsuario' value='<?php echo $temp->getNombreUsuario(); ?>'>
                        <input type='hidden' name='nombreEvento' value='<?php echo $temp->getNombreEvento(); ?>'>
                        <input type='hidden' name='fecha' value='<?php echo $temp->getFecha(); ?>'>
                        <button type='submit' class='btn btn-primary'>Generar QR</button>
                    </form>
                <?php
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>