

<?php



require 'includes/config/database.php';

$db = conectarDB();

$consulta = "SELECT nombre, apellido, referencia, banco, monto, fecha FROM comprobante";
$resultado = mysqli_query($db, $consulta);

$reporte = [];

while ($row = mysqli_fetch_assoc($resultado)) {
    $reporte[] = $row;
}

$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : '';

if (!empty($filtro)) {
    $reporte = array_filter($reporte, function ($comprobante) use ($filtro) {
        return strpos($comprobante['nombre'], $filtro) !== false ||
            strpos($comprobante['apellido'], $filtro) !== false ||
            strpos($comprobante['referencia'], $filtro) !== false ||
            strpos($comprobante['banco'], $filtro) !== false ||
            strpos($comprobante['monto'], $filtro) !== false ||
            strpos($comprobante['fecha'], $filtro) !== false;
    });
}

require 'includes/funciones.php';
incluirTemplate('header');
?>

<div class="fondo-lineup">
    <div class="imagen-lineup">
        <div class="texto-superpuesto">
            <h3>Reportes</h3>
        </div>
        <img src="build/img/fondo-lineup.jpg" alt="">
    </div>
</div>

<div class="contenedor-reporte comprobantes">
    <form class="buscador" method="GET">
        <input type="text" name="filtro" placeholder="Buscar" value="<?php echo isset($_GET['filtro']) ? $_GET['filtro'] : ''; ?>">
        <button type="submit">Filtrar</button>
    </form>

    <table class="comprobantes">
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Referencia</th>
            <th>Banco</th>
            <th>Monto</th>
            <th>Fecha</th>
        </tr>
        <?php foreach ($reporte as $comprobante): ?>
            <tr>
                <td><?php echo $comprobante['nombre']; ?></td>
                <td><?php echo $comprobante['apellido']; ?></td>
                <td><?php echo $comprobante['referencia']; ?></td>
                <td><?php echo $comprobante['banco']; ?></td>
                <td><?php echo $comprobante['monto']; ?></td>
                <td><?php echo $comprobante['fecha']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <button id="imprimirPDF">Imprimir en PDF</button>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
   
    console.log('Script de JavaScript ejecutado');

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('imprimirPDF').addEventListener('click', function (event) {
            event.preventDefault(); // Detiene el comportamiento predeterminado del enlace
            console.log('Enlace clicado');
            var doc = new jsPDF();
            doc.autoTable({ html: '.comprobantes' });
            doc.save('reporte.pdf');
        });
    });
</script>
<?php incluirTemplate('footer'); ?>