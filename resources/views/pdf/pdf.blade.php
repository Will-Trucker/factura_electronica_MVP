<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla Factura</title>
    <style>
        table {
            width: 500px;
            font-family: Arial, sans-serif;
            font-size: 6px;
            text-align: center;
        }

        th {
            border: 1px solid black;
        }

        .part1 td {
            border: 1px solid black;

        }

        .descripcion {
            width: 90px;
        }

        .right-align {
            text-align: right;
        }

        .summary-row {
            font-weight: bold;
        }

        .totals-row td {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Cantidad</th>
                <th>Unidad</th>
                <th class="descripcion">Descripción</th>
                <th>Precio Unitario</th>
                <th>Descuento por ítem</th>
                <th>Otros montos no afectos</th>
                <th>Ventas No Sujetas</th>
                <th>Ventas Exentas</th>
                <th>Ventas Gravadas</th>
            </tr>
        </thead>
        <tbody>
            <tr class="part1">
                <td>1</td>
                <td>2.00</td>
                <td>Unidad</td>
                <td class="descripcion">ISLA PARA COCINA 93X117X50.8CM MELAMINA<br>WENGUE/DUNA CALA</td>
                <td>199.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>398.00</td>
            </tr>
            <tr class="part1">
                <td>2</td>
                <td>1.00</td>
                <td>Unidad</td>
                <td class="descripcion">ALACENA COCINA 180X125X40CM MELAMINA<br>ROBLE NEGRO OSHAWA</td>
                <td>299.00</td>
                <td>80.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>299.00</td>
            </tr>
            <tr class="part1">
                <td>3</td>
                <td>2.00</td>
                <td>Unidad</td>
                <td class="descripcion">MESA TV 61X155 X30CM AGLOMERADO<br>WENGUE/MIEL KAIA</td>
                <td>149.95</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>299.90</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="10"></td>
            </tr>

            <!-- Suma de Ventas -->
            <tr>
                <td class="part2" colspan="6"></td>
                <td class="right-align summary-row">Suma de Ventas:</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>916.90</td>
            </tr>
            <!-- Suma Total de Operaciones -->
            <tr>
                <td colspan="9" class="right-align summary-row">Suma Total de Operaciones:</td>
                <td>916.90</td>
            </tr>
            <!-- Montos Globales -->
            <tr>
                <td colspan="9" class="right-align">Monto global Desc., Rebajas y otros a ventas no sujetas:</td>
                <td>0.00</td>
            </tr>
            <tr>
                <td colspan="9" class="right-align">Monto global Desc., Rebajas y otros a ventas exentas:</td>
                <td>0.00</td>
            </tr>
            <tr>
                <td colspan="9" class="right-align">Monto global Desc., Rebajas y otros a ventas gravadas:</td>
                <td>0.00</td>
            </tr>
            <!-- Impuesto y Totales -->
            <tr>
                <td colspan="9" class="right-align summary-row">Impuesto al Valor Agregado 13%:</td>
                <td >119.20</td>
            </tr>
            <tr>
                <td colspan="9" class="right-align summary-row">Sub-Total:</td>
                <td >916.90</td>
            </tr>
            <tr>
                <td colspan="9" class="right-align">IVA Percibido:</td>
                <td >0.00</td>
            </tr>
            <tr>
                <td colspan="9" class="right-align">IVA Retenido:</td>
                <td >0.00</td>
            </tr>
            <tr>
                <td colspan="9" class="right-align">Retención Renta:</td>
                <td>0.00</td>
            </tr>
            <tr class="totals-row">
                <td colspan="9" class="right-align">Monto Total de la Operación:</td>
                <td >1,036.10</td>
            </tr>
            <tr class="totals-row">
                <td colspan="9" class="right-align">Total Otros montos no afectos:</td>
                <td >0.00</td>
            </tr>
            <tr class="totals-row">
                <td colspan="9" class="right-align">Total a Pagar:</td>
                <td >1,036.10</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>