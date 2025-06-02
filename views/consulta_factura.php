<?php
// Encabezado para indicar que se devuelve JSON
header("Content-Type: application/json");

// Incluir el archivo de conexión con PDO
require_once('../providers/Database.php');

// Crear la instancia de conexión PDO
try {
    $db = new Database(); // Asegúrate que esta clase retorna una instancia de PDO
} catch (PDOException $e) {
    echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
    exit;
}

// Obtener la referencia desde GET
$referencia = isset($_GET['referencia']) ? trim($_GET['referencia']) : '';

// Validar que se haya enviado la referencia
if (empty($referencia)) {
    echo json_encode(["response" => "Por favor, ingresa una referencia o número de factura válida."]);
    exit;
}

try {
    // Consulta con INNER JOINs
    $sql = "SELECT f.*, pt.Nombre_Producto, e.Estados
            FROM facturas f
            INNER JOIN productos_terminados pt ON pt.idProductos = f.Informacion_del_Producto
            INNER JOIN estados e ON e.idEstados = f.Estado_Factura
            WHERE f.Numero_Factura = :referencia OR f.Referencia_Pago = :referencia";

    // Preparar y ejecutar consulta
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':referencia', $referencia, PDO::PARAM_STR);
    $stmt->execute();

    // Verificar si hay resultados
    if ($stmt->rowCount() > 0) {
        $factura = $stmt->fetch(PDO::FETCH_ASSOC);

        // Devolver resultado como JSON estructurado
        echo json_encode([
            "Numero_Factura" => $factura['Numero_Factura'],
            "Cantidad" => $factura['Cantidad'],
            "Producto" => $factura['Nombre_Producto'],
            "Fecha_Emision" => $factura['Fecha_de_Emision'],
            "Precio_Total" => number_format($factura['Precio_Total'], 2),
            "Direccion" => $factura['Direccion_Facturacion'],
            "Estado" => $factura['Estados'],
            "Fecha_Pago" => $factura['Fecha_Pago'] ?? "Pendiente",
            "Referencia_Pago" => $factura['Referencia_Pago']
        ]);
    } else {
        echo json_encode(["response" => "No se encontró ninguna factura con esa referencia o número de factura."]);
    }

} catch (PDOException $e) {
    echo json_encode(["error" => "Error al consultar la factura: " . $e->getMessage()]);
}
