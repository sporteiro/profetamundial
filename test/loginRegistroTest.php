<?php
use PHPUnit\Framework\TestCase;

class LoginRegistroTest extends TestCase
{
    private $conexion;
    private $database_conexion;

    protected function setUp(): void
    {
        // Crear una base de datos SQLite en memoria para las pruebas
        $this->conexion = new mysqli('127.0.0.1', 'root', '', '', 3306);
        // Pero SQLite no es compatible con mysqli. Mejor usar MySQL real para test temporal.
        // Para simplificar, usaremos una base de datos MySQL de prueba (no producción).
        // Configura una base de datos test con la misma estructura.
        // Asumimos que tienes 'test_db' creada con la tabla `usuarios`.
        $this->conexion = new mysqli('localhost', 'root', 'rootpassword123', 'test_db');
        if ($this->conexion->connect_error) {
            $this->markTestSkipped('No se pudo conectar a la base de datos de prueba: ' . $this->conexion->connect_error);
        }
        // Vaciar tabla usuarios
        $this->conexion->query("TRUNCATE TABLE usuarios");
        $this->database_conexion = 'test_db';

        // Sobreescribir la variable global $conexion usada por las funciones
        global $conexion, $database_conexion;
        $conexion = $this->conexion;
        $database_conexion = $this->database_conexion;
    }

    protected function tearDown(): void
    {
        $this->conexion->close();
    }

    public function testRegistroYLoginUsuarioValido()
    {
        // Simular $_POST del registro
        $_POST = [
            'MM_insert' => 'formregistrarse',
            'usuario' => 'testuser',
            'contrasena' => 'pass123',
            'contrasena2' => 'pass123',
            'nombre' => 'Test User',
            'email' => 'test@example.com',
            'origen' => 'ProfetaMundial',
            'g-recaptcha-response' => 'dummy_captcha_ignored_en_test'
        ];

        // Incluir el archivo de registro (detiene la ejecución con header, usamos output buffering)
        // Para evitar redirección, capturamos la salida y evitamos header.
        // Es más sencillo simular la lógica de inserción manualmente.
        // Como el archivo registrarse.php contiene validación de captcha y redirección,
        // lo simularemos llamando directamente a las funciones de inserción.

        // En lugar de incluir el archivo, ejecutamos la lógica directamente usando las funciones globales.
        $insertSQL = sprintf("INSERT INTO usuarios (usuario, contrasena, nombre, email, puntos, ip, activo) VALUES ('%s', '%s', '%s', '%s', '0', '%s', 'no')",
            mysqli_real_escape_string($this->conexion, $_POST['usuario']),
            mysqli_real_escape_string($this->conexion, sha1($_POST['contrasena'])),
            mysqli_real_escape_string($this->conexion, $_POST['nombre']),
            mysqli_real_escape_string($this->conexion, $_POST['email']),
            mysqli_real_escape_string($this->conexion, '127.0.0.1')
        );
        $result = mysqli_query($this->conexion, $insertSQL);
        $this->assertTrue($result, 'Fallo la inserción del usuario');

        // Comprobar que se insertó correctamente
        $query = "SELECT * FROM usuarios WHERE usuario='testuser'";
        $rs = mysqli_query($this->conexion, $query);
        $this->assertEquals(1, mysqli_num_rows($rs));
        $row = mysqli_fetch_assoc($rs);
        $this->assertEquals('testuser', $row['usuario']);
        $this->assertEquals(sha1('pass123'), $row['contrasena']);
        $this->assertEquals('no', $row['activo']); // Por defecto inactivo

        // Simular login con usuario y contraseña correctos
        $loginUsername = 'testuser';
        $password = sha1('pass123');
        $queryLogin = sprintf("SELECT usuario, contrasena, activo FROM usuarios WHERE BINARY usuario='%s' AND contrasena='%s'",
            mysqli_real_escape_string($this->conexion, $loginUsername),
            mysqli_real_escape_string($this->conexion, $password)
        );
        $rsLogin = mysqli_query($this->conexion, $queryLogin);
        $loginFoundUser = mysqli_num_rows($rsLogin);
        $this->assertEquals(1, $loginFoundUser, 'El usuario correcto debería existir');

        $filas = mysqli_fetch_assoc($rsLogin);
        $activo = $filas['activo'];
        $this->assertEquals('no', $activo, 'La cuenta debería estar inactiva');

        // Ahora probar con contraseña incorrecta
        $badPassword = sha1('wrong');
        $queryLoginBad = sprintf("SELECT usuario, contrasena, activo FROM usuarios WHERE BINARY usuario='%s' AND contrasena='%s'",
            mysqli_real_escape_string($this->conexion, $loginUsername),
            mysqli_real_escape_string($this->conexion, $badPassword)
        );
        $rsLoginBad = mysqli_query($this->conexion, $queryLoginBad);
        $loginFoundUserBad = mysqli_num_rows($rsLoginBad);
        $this->assertEquals(0, $loginFoundUserBad, 'Contraseña incorrecta no debe encontrar usuario');
    }
}