<?php
class Usuarios extends ModeloGenerico{
    protected $id;
    protected $nombres;
    protected $apellidos;
    protected $edad;
    protected $correo;
    protected $telefono;
    protected $fecha_registro;

    public function __construct($propiedades = null){
        parent::__construct("usuario", Usuarios::class, $propiedades);
    }

    public function getId(){
        return $this->id;
    }
    public function getNombres(){
        return $this->nombres;
    }
    public function getApellidos(){
        return $this->apellidos;
    }
    public function getEdad(){
        return $this->edad;
    }
    public function getCorreo(){
        return $this->correo;
    }
    public function getFechaRegistro(){
        return $this->fecha_registro;
    }
    public function getTelefono(){
        return $this->telefono;
    }

    public function setTelefono($valor){
        $this->telefono = $valor;
    }
    public function setFechaRegistro($valor){
        $this->fecha_registro = $valor;
    }
    public function setNombres($valor){
        $this->nombres = $valor;
    }

    public function setId($valor){
        $this->id = $valor;
    }

    public function setApellidos($valor){
        $this->apellidos = $valor;
    }

    public function setCorreo($valor){
        $this->correo = $valor;
    }

    public function setEdad($valor){
        $this->edad= $valor;
    }






}

?>