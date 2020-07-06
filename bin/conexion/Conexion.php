<?php
// verificar en el php.ini, activada la extension PDO -> (mysql en este caso)
class Conexion{

    private $conexion;
    private $configuracion= [
        "driver" => "mysql",
        "host" => "localhost",
        "database" => "proyecto1",
        "port" => "3306",
        "username" => "root",
        "password" => "",
        "charset" => "utf8mb4"
    ];

    public function __constructor() {

        }

    public function conectar() {
        try {
            $controlador = $this->configuracion['driver'];
            $servidor = $this->configuracion['host'];
            $base_datos = $this->configuracion['database'];
            $puerto = $this->configuracion['port'];
            $usuario = $this->configuracion['username'];
            $clave = $this->configuracion['password'];
            $codificacion = $this->configuracion['charset'];

            $url = "{$controlador}:host={$servidor}:{$puerto}; dbname={$base_datos};charset={$codificacion}";
            
            //se crea conexion
            $this->conexion = new PDO($url, $usuario, $clave);
            return $this->conexion;
            
        } catch (Exception $e) {
            echo "no se pudo conectar";
            echo $e->getTraceAsString();

        }
    }

}

?>