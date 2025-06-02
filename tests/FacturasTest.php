<?php


use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../models/Facturas.php';
require_once __DIR__ . '/../providers/Database.php';

class FacturasTest extends TestCase
{
    private $facturas;

    protected function setUp(): void
    {
        $this->facturas = new Factura();
    }

    public function testCrearFactura()
    {
        // Cambia estos valores según tus datos existentes
        $data = [
            'Cantidad' => 1,
            'Informacion_del_Producto' => 1, // idProductos existente
            'Fecha_de_Emision' => date('Y-m-d'),
            'Precio_Total' => 1000,
            'Numero_Factura' => 'F-' . uniqid(),
            'idCliente' => 1, // id de usuario existente
            'Direccion_Facturacion' => 'Calle Falsa 123',
            'Estado_Factura' => 1, // idEstados existente
            'Fecha_Pago' => date('Y-m-d'),
            'Referencia_Pago' => 'REF-' . uniqid(),
            'status' => 'IN'
        ];
        $this->assertTrue($this->facturas->newFactura($data));

        // Buscar la factura insertada por número único
        $facturas = $this->facturas->getAll();
        $factura = null;
        foreach ($facturas as $f) {
            if (
                (is_array($f) && $f['Numero_Factura'] === $data['Numero_Factura']) ||
                (is_object($f) && $f->Numero_Factura === $data['Numero_Factura'])
            ) {
                $factura = $f;
                break;
            }
        }
        $this->assertNotEmpty($factura);

        echo "\n✔️  Éxitoso test de crear factura";
    }

    public function testEditarFacturaPorId()
    {
        // Cambia este valor por el ID de la factura que quieres actualizar
        $idFactura = 100; // <-- Pon aquí el ID que quieras

        // Busca la factura por ID
        $factura = $this->facturas->getFacturasId($idFactura);
        $factura = is_array($factura) ? $factura[0] : $factura;
        $this->assertNotEmpty($factura, "No se encontró la factura con ID $idFactura.");

        // Actualiza el precio total
        $editData = [
            'idFacturas' => $idFactura,
            'Precio_Total' => 9999
        ];
        $this->facturas->editFactura($editData);

        // Verifica que el precio fue actualizado
        $facturaActualizada = $this->facturas->getFacturasId($idFactura);
        $facturaActualizada = is_array($facturaActualizada) ? $facturaActualizada[0] : $facturaActualizada;
        $this->assertEquals(9999, $facturaActualizada->Precio_Total ?? $facturaActualizada['Precio_Total']);

        echo "\n✔️  Éxitoso test de modificar factura";
    }

    public function testEliminarFacturaPorId()
    {
        // Cambia este valor por el ID de la factura que quieres eliminar
        $idFactura = 105; // <-- Pon aquí el ID que quieras

        // Verifica que la factura existe antes de eliminar
        $factura = $this->facturas->getFacturasId($idFactura);
        $factura = is_array($factura) ? $factura[0] : $factura;
        $this->assertNotEmpty($factura, "No se encontró la factura con ID $idFactura.");

        // Elimina la factura (cambia el status a OUT)
        $resultado = $this->facturas->deleteFacturas($idFactura);
        $this->assertTrue($resultado === true, "No se pudo eliminar la factura con ID $idFactura.");

        // Verifica que el status es OUT
        $facturaEliminada = $this->facturas->getFacturasId($idFactura);
        $facturaEliminada = is_array($facturaEliminada) ? $facturaEliminada[0] : $facturaEliminada;
        $this->assertEquals('OUT', $facturaEliminada->status ?? $facturaEliminada['status']);

        echo "\n✔️  Éxitoso test de eliminar factura";
    }
}