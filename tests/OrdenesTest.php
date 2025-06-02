<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../models/Ordenes.php';
require_once __DIR__ . '/../providers/Database.php';

class OrdenesTest extends TestCase
{
    private $ordenes;

    protected function setUp(): void
    {
        $this->ordenes = new Orden();
    }

    public function testCrearOrden()
    {
        // Cambia estos valores según tus datos existentes
        $data = [
            'idCliente' => 1, // id existente en usuario
            'Fecha_Orden' => date('Y-m-d'),
            'Total_Total' => 5000,
            'Cantidad_Producto' => 2,
            'Fecha_Entrega' => date('Y-m-d', strtotime('+7 days')),
            'idProductosTerminados' => 1, // id existente en productos_terminados
            'idMateriaPrima' => 1, // id existente en materia_prima
            'Estado' => 1, // id existente en estados
            'status' => 'IN'
        ];
        $this->assertTrue($this->ordenes->newOrdenes($data));

        // Buscar la orden insertada por cliente y fecha
        $ordenes = $this->ordenes->getAll();
        $orden = null;
        foreach ($ordenes as $o) {
            if (
                (is_array($o) && $o['idCliente'] == $data['idCliente'] && $o['Fecha_Orden'] == $data['Fecha_Orden']) ||
                (is_object($o) && $o->idCliente == $data['idCliente'] && $o->Fecha_Orden == $data['Fecha_Orden'])
            ) {
                $orden = $o;
                break;
            }
        }
        $this->assertNotEmpty($orden);

        echo "\n✔️  Éxitoso test de crear orden";
    }

    public function testEditarOrdenPorId()
    {
        // Cambia este valor por el ID de la orden que quieres actualizar
        $idOrden = 1; // <-- Pon aquí el ID que quieras

        // Busca la orden por ID
        $orden = $this->ordenes->getOrdenById($idOrden);
        $orden = is_array($orden) ? $orden[0] : $orden;
        $this->assertNotEmpty($orden, "No se encontró la orden con ID $idOrden.");

        // Actualiza la cantidad de producto
        $editData = [
            'idOrden' => $idOrden,
            'Cantidad_Producto' => 99
        ];
        $this->ordenes->editOrdenes($editData);

        // Verifica que la cantidad fue actualizada
        $ordenActualizada = $this->ordenes->getOrdenById($idOrden);
        $ordenActualizada = is_array($ordenActualizada) ? $ordenActualizada[0] : $ordenActualizada;
        $this->assertEquals(99, $ordenActualizada->Cantidad_Producto ?? $ordenActualizada['Cantidad_Producto']);

        echo "\n✔️  Éxitoso test de modificar orden";
    }

    public function testEliminarOrdenPorId()
    {
        // Cambia este valor por el ID de la orden que quieres eliminar
        $idOrden = 1; // <-- Pon aquí el ID que quieras

        // Verifica que la orden existe antes de eliminar
        $orden = $this->ordenes->getOrdenById($idOrden);
        $orden = is_array($orden) ? $orden[0] : $orden;
        $this->assertNotEmpty($orden, "No se encontró la orden con ID $idOrden.");

        // Elimina la orden (cambia el status a OUT)
        $resultado = $this->ordenes->deleteOrdenes($idOrden);
        $this->assertTrue($resultado === true, "No se pudo eliminar la orden con ID $idOrden.");

        // Verifica que el status es OUT
        $ordenEliminada = $this->ordenes->getOrdenById($idOrden);
        $ordenEliminada = is_array($ordenEliminada) ? $ordenEliminada[0] : $ordenEliminada;
        $this->assertEquals('OUT', $ordenEliminada->status ?? $ordenEliminada['status']);

        echo "\n✔️  Éxitoso test de eliminar orden";
    }
}