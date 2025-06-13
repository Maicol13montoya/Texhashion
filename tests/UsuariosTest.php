<?php
use PHPUnit\Framework\TestCase;
use App\Models\Usuario;
use App\Providers\Database;

class UsuariosTest extends TestCase
{
    private $usuarios;

    protected function setUp(): void
    {
        $this->usuarios = new Usuario();
    }

    public function testInsertAndGetUsuario()
    {
        $data = [
            'nombre' => 'Test',
            'apellido' => 'User',
            'correo_electronico' => 'testuser_' . uniqid() . '@example.com',
            'tipo_documento' => 1,
            'documento' => '1234567891',
            'direccion' => 'KR 6F ESTE #89C 48 SUR',
            'fecha_nacimiento' => '2002-01-20',
            'telefono' => '1234567890',
            'rol' => 1,
            'status' => 'IN'
        ];

        $this->assertTrue($this->usuarios->newUsuarios($data));

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
        echo "\n✔️  Éxitoso test de crear";
    }

    public function testEditUsuarioPorId()
    {
        $idUsuario = 8;
        $usuario = $this->usuarios->getUsuariosId($idUsuario);
        $usuario = is_array($usuario) ? $usuario[0] : $usuario;
        $this->assertNotEmpty($usuario, "No se encontró el usuario con ID $idUsuario.");

        $editData = [
            'id' => $idUsuario,
            'nombre' => 'ActualizadoPorTest'
        ];

        $this->usuarios->editUsuarios($editData);

        $usuarioActualizado = $this->usuarios->getUsuariosId($idUsuario);
        $usuarioActualizado = is_array($usuarioActualizado) ? $usuarioActualizado[0] : $usuarioActualizado;

        $this->assertEquals('ActualizadoPorTest', $usuarioActualizado->nombre ?? $usuarioActualizado['nombre']);
        echo "\n✔️  Éxitoso test de modificar";
    }

    public function testDeleteUsuarioPorId()
    {
        $idUsuario = 28;
        $db = new Database();
        $db->delete('orden', 'idCliente = ' . intval($idUsuario));

        $usuario = $this->usuarios->getUsuariosId($idUsuario);
        $usuario = is_array($usuario) ? $usuario[0] : $usuario;
        $this->assertNotEmpty($usuario, "No se encontró el usuario con ID $idUsuario.");

        $resultado = $this->usuarios->deleteUsuarios($idUsuario);
        $this->assertTrue($resultado > 0 || $resultado === true, "No se pudo eliminar el usuario con ID $idUsuario.");

        $usuarioEliminado = $this->usuarios->getUsuariosId($idUsuario);
        $this->assertEmpty($usuarioEliminado, "El usuario con ID $idUsuario aún existe después de eliminarlo.");
        echo "\n✔️  Éxitoso test de eliminar";
    }
}
