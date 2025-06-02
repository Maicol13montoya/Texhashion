<?php


use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../models/ProductoTerminado.php';
require_once __DIR__ . '/../providers/Database.php';

class ProductoTerminadoTest extends TestCase
{
    private $productos;

    protected function setUp(): void
    {
        $this->productos = new ProductosTerminados();
    }

    public function testCrearProductoTerminado()
    {
        // Cambia estos valores según tus datos existentes
        $data = [
            'Nombre_Producto' => 'ProductoTest_' . uniqid(),
            'Cantidad_Disponible' => 10,
            'DescripcionPT' => 'Producto de prueba',
            'Fecha_Entrada' => date('Y-m-d'),
            'Fecha_Salida' => date('Y-m-d'),
            'idmateria_prima' => 1, // id existente en materia_prima
            'idEstado' => 1,        // id existente en estados
            'status' => 'IN'
        ];
        $this->assertTrue($this->productos->newProductoTerminado($data));

        // Buscar el producto insertado por nombre único
        $productos = $this->productos->getAll();
        $producto = null;
        foreach ($productos as $p) {
            if (
                (is_array($p) && $p['Nombre_Producto'] === $data['Nombre_Producto']) ||
                (is_object($p) && $p->Nombre_Producto === $data['Nombre_Producto'])
            ) {
                $producto = $p;
                break;
            }
        }
        $this->assertNotEmpty($producto);

        echo "\n✔️  Éxitoso test de crear producto terminado";
    }

    public function testEditarProductoTerminadoPorId()
    {
        // Cambia este valor por el ID del producto que quieres actualizar
        $idProductos = 1; // <-- Pon aquí el ID que quieras

        // Busca el producto por ID
        $producto = $this->productos->getProductoTerminadoId($idProductos);
        $producto = is_array($producto) ? $producto[0] : $producto;
        $this->assertNotEmpty($producto, "No se encontró el producto con ID $idProductos.");

        // Actualiza la cantidad disponible
        $editData = [
            'idProductos' => $idProductos,
            'Cantidad_Disponible' => 99
        ];
        $this->productos->editProductoTerminado($editData);

        // Verifica que la cantidad fue actualizada
        $productoActualizado = $this->productos->getProductoTerminadoId($idProductos);
        $productoActualizado = is_array($productoActualizado) ? $productoActualizado[0] : $productoActualizado;
        $this->assertEquals(99, $productoActualizado->Cantidad_Disponible ?? $productoActualizado['Cantidad_Disponible']);

        echo "\n✔️  Éxitoso test de modificar producto terminado";
    }

    public function testEliminarProductoTerminadoPorId()
    {
        // Cambia este valor por el ID del producto que quieres eliminar
        $idProductos = 1; // <-- Pon aquí el ID que quieras

        // Verifica que el producto existe antes de eliminar
        $producto = $this->productos->getProductoTerminadoId($idProductos);
        $producto = is_array($producto) ? $producto[0] : $producto;
        $this->assertNotEmpty($producto, "No se encontró el producto con ID $idProductos.");

        // Elimina el producto (cambia el status a OUT)
        $resultado = $this->productos->deleteProductoTerminado($idProductos);
        $this->assertTrue($resultado === true, "No se pudo eliminar el producto con ID $idProductos.");

        // Verifica que el status es OUT
        $productoEliminado = $this->productos->getProductoTerminadoId($idProductos);
        $productoEliminado = is_array($productoEliminado) ? $productoEliminado[0] : $productoEliminado;
        $this->assertEquals('OUT', $productoEliminado->status ?? $productoEliminado['status']);

        echo "\n✔️  Éxitoso test de eliminar producto terminado";
    }
}