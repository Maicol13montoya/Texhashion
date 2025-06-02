<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../models/Materia_prima.php';
require_once __DIR__ . '/../providers/Database.php';

class MateriaPrimaTest extends TestCase
{
    private $materiaPrima;

    protected function setUp(): void
    {
        $this->materiaPrima = new MateriaPrima();
    }

    public function testCrearMateriaPrima()
    {
        // Cambia estos valores según tus datos existentes
        $data = [
            'Nombre' => 'MateriaTest_' . uniqid(),
            'Descripcion' => 'Materia de prueba',
            'Fecha_Ingreso' => date('Y-m-d'),
            'Precio_Unidad' => 100,
            'Cantidad_Stock' => 50,
            'id_Proveedor' => 1, // id existente en usuario con Rol=5
            'Categoria' => 1,    // id existente en categorias
            'Unidad_Medida' => 1, // id existente en unidadmedida
            'Fecha_Actualizacion' => date('Y-m-d'),
            'Estado' => 1,       // id existente en estados
            'status' => 'IN'
        ];
        $this->assertTrue($this->materiaPrima->newMateriaPrima($data));

        // Buscar la materia prima insertada por nombre único
        $materias = $this->materiaPrima->getAll();
        $materia = null;
        foreach ($materias as $m) {
            if (
                (is_array($m) && $m['Nombre'] === $data['Nombre']) ||
                (is_object($m) && $m->Nombre === $data['Nombre'])
            ) {
                $materia = $m;
                break;
            }
        }
        $this->assertNotEmpty($materia);

        echo "\n✔️  Éxitoso test de crear materia prima";
    }

    public function testEditarMateriaPrimaPorId()
    {
        // Cambia este valor por el ID de la materia prima que quieres actualizar
        $idProducto = 1; // <-- Pon aquí el ID que quieras

        // Busca la materia prima por ID
        $materia = $this->materiaPrima->getMateriaPrimaId($idProducto);
        $materia = is_array($materia) ? $materia[0] : $materia;
        $this->assertNotEmpty($materia, "No se encontró la materia prima con ID $idProducto.");

        // Actualiza la cantidad de stock
        $editData = [
            'idProducto' => $idProducto,
            'Cantidad_Stock' => 999
        ];
        $this->materiaPrima->editMateriaPrima($editData);

        // Verifica que la cantidad fue actualizada
        $materiaActualizada = $this->materiaPrima->getMateriaPrimaId($idProducto);
        $materiaActualizada = is_array($materiaActualizada) ? $materiaActualizada[0] : $materiaActualizada;
        $this->assertEquals(999, $materiaActualizada->Cantidad_Stock ?? $materiaActualizada['Cantidad_Stock']);

        echo "\n✔️  Éxitoso test de modificar materia prima";
    }

    public function testEliminarMateriaPrimaPorId()
    {
        // Cambia este valor por el ID de la materia prima que quieres eliminar
        $idProducto = 1; // <-- Pon aquí el ID que quieras

        // Verifica que la materia prima existe antes de eliminar
        $materia = $this->materiaPrima->getMateriaPrimaId($idProducto);
        $materia = is_array($materia) ? $materia[0] : $materia;
        $this->assertNotEmpty($materia, "No se encontró la materia prima con ID $idProducto.");

        // Elimina la materia prima (cambia el status a OUT)
        $resultado = $this->materiaPrima->deleteMateriaPrima($idProducto);
        $this->assertTrue($resultado === true, "No se pudo eliminar la materia prima con ID $idProducto.");

        // Verifica que el status es OUT
        $materiaEliminada = $this->materiaPrima->getMateriaPrimaId($idProducto);
        $materiaEliminada = is_array($materiaEliminada) ? $materiaEliminada[0] : $materiaEliminada;
        $this->assertEquals('OUT', $materiaEliminada->status ?? $materiaEliminada['status']);

        echo "\n✔️  Éxitoso test de eliminar materia prima";
    }
}