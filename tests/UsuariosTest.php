<?php


use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../providers/Database.php';

class UsuariosTest extends TestCase
{
    private $usuarios;

    protected function setUp(): void
    {
        $this->usuarios = new Usuarios();
    }

    public function testInsertAndGetUsuario()
    {
        $data = [
            'nombre' => 'Test',
            'apellido' => 'User',
            'correo_electronico' => 'testuser_' . uniqid() . '@example.com', // correo único
            'tipo_documento' => 1,
            'documento' => '1234567891',
            'direccion' => 'KR 6F ESTE #89C 48 SUR',
            'fecha_nacimiento' => '2002-01-20',
            'telefono' => '1234567890',
            'rol' => 1,
            'status' => 'IN'
        ];
        $this->assertTrue($this->usuarios->newUsuarios($data));

        // Buscar el usuario insertado por correo
        $usuarios = $this->usuarios->getAll();
        $usuario = null;
        foreach ($usuarios as $u) {
            if (
                (is_array($u) && $u['correo_electronico'] === $data['correo_electronico']) ||
                (is_object($u) && $u->correo_electronico === $data['correo_electronico'])
            ) {
                $usuario = $u;
                break;
            }
        }
        $this->assertNotEmpty($usuario);

        // Mensaje de éxito para crear
        echo "\n✔️  Éxitoso test de crear";
    }

    public function testEditUsuarioPorId()
    {
        // Cambia este valor por el ID del usuario que quieres actualizar
        $idUsuario = 8; // <-- Pon aquí el ID que quieras

        // Busca el usuario por ID
        $usuario = $this->usuarios->getUsuariosId($idUsuario);
        $usuario = is_array($usuario) ? $usuario[0] : $usuario;
        $this->assertNotEmpty($usuario, "No se encontró el usuario con ID $idUsuario.");

        // Actualiza el nombre
        $editData = [
            'id' => $idUsuario,
            'nombre' => 'ActualizadoPorTest'
        ];
        $this->usuarios->editUsuarios($editData);

        // Verifica que el nombre fue actualizado
        $usuarioActualizado = $this->usuarios->getUsuariosId($idUsuario);
        $usuarioActualizado = is_array($usuarioActualizado) ? $usuarioActualizado[0] : $usuarioActualizado;
        $this->assertEquals('ActualizadoPorTest', $usuarioActualizado->nombre ?? $usuarioActualizado['nombre']);

        // Mensaje de éxito para modificar
        echo "\n✔️  Éxitoso test de modificar";
    }

    public function testDeleteUsuarioPorId()
    {
        // Cambia este valor por el ID del usuario que quieres eliminar
        $idUsuario = 28; // <-- Pon aquí el ID que quieras

        // Elimina las órdenes relacionadas antes de eliminar el usuario (si aplica)
        $db = new Database();
        $db->delete('orden', 'idCliente = ' . intval($idUsuario));

        // Verifica que el usuario existe antes de eliminar
        $usuario = $this->usuarios->getUsuariosId($idUsuario);
        $usuario = is_array($usuario) ? $usuario[0] : $usuario;
        $this->assertNotEmpty($usuario, "No se encontró el usuario con ID $idUsuario.");

        // Elimina el usuario
        $resultado = $this->usuarios->deleteUsuarios($idUsuario);
        $this->assertTrue($resultado > 0 || $resultado === true, "No se pudo eliminar el usuario con ID $idUsuario.");

        // Verifica que el usuario ya no existe
        $usuarioEliminado = $this->usuarios->getUsuariosId($idUsuario);
        $this->assertEmpty($usuarioEliminado, "El usuario con ID $idUsuario aún existe después de eliminarlo.");

        // Mensaje de éxito para eliminar
        echo "\n✔️  Éxitoso test de eliminar";
    }
}