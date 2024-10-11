<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include 'navbar.php' ?>

    <div class="container mt-5">
        <div class="invoice-header">
            <h1>Factura</h1>
            <p>Fecha: <strong id="invoice-date">2024-10-11</strong></p>
            <p>Nombre del Comprador: <strong id="buyer-name">Juan Pérez</strong></p>
        </div>

        <div class="invoice-details">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Producto A</td>
                        <td>2</td>
                        <td>$50.00</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td>Producto B</td>
                        <td>1</td>
                        <td>$30.00</td>
                        <td>$30.00</td>
                    </tr>
                    <tr>
                        <td>Producto C</td>
                        <td>3</td>
                        <td>$20.00</td>
                        <td>$60.00</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right">Subtotal:</td>
                        <td>$190.00</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">IVA (19%):</td>
                        <td>$36.10</td>
                    </tr>
                    <tr class="total">
                        <td colspan="3" class="text-right">Total:</td>
                        <td>$226.10</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <?php include 'footer.php' ?>

</body>

</html>