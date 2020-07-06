<?php
//este modelo pretende ser el padre de todos los modelos futuros, asi se reutiliza la mayor cantidad de codigo y es lo mas generico posible

class ModeloGenerico extends Crud
{
    private $className;
    private $excluir = ["className", "tabla", "conexion", "wheres", "sql", "excluir"]; //para excluir los atributos que no necesitamos


    public function __construct($tabla, $className, $propiedades = null)
    {
        parent::__construct($tabla);
        $this->className = $className;

        if (empty($propiedades)) {
            return;
        }

        foreach ($propiedades as $llave => $valor) {
            $this->{$llave} = $valor;
        }
    }

    protected function obtenerAtributos(){
        $variables = get_class_vars($this->className); //obtener las variables del obj dentro de un array
        $atributos=[];
        $max= count($variables);
        foreach ($variables as $llave => $valor) {
            if(!in_array($llave, $this->excluir)){ //si no se encuentra la llave en excluir, agregar
                $atributos[]= $llave;
            }
        }
    return $atributos;
    }


protected function parsear ($obj = null){
    try {
        $atributos = $this->obtenerAtributos(); //obtener los atributos de las clases
        $objetoFinal= []; //objeto final con la estructra segun nuestros valores

        //obtener el objeto del modelo
        if ($obj == null){ //comprobar que el objeto se haya recibido
            foreach ($atributos as $indice => $llave) { //armar el objeto segun la info setteada en los atributos
                if (isset($this->{$llave})){ 
                    $objetoFinal[$llave] = $this->{$llave}; 
                }
            }return $objetoFinal;
                    
        }
        //corregir el objeto que recibimos con los atributos del modelo - 
        //omite valores que no esten declarados en el modelo del objeto que puedan pasar 
        foreach ($atributos as $indice => $llave) {
            if (isset($obj[$llave])){ //si es null
                $objetoFinal[$llave] = $obj[$llave];
            }
        }        
        return $objetoFinal;

    } catch (Exception $e) {
        throw new Exception("Error en ". $this->className . ".parsear() => ". $e->getMessage());
    }
}


 public function fill($obj){
     try {
         $atributos = $this->obtenerAtributos(); //recibe atributos
         foreach ($atributos as $inde => $llave){ //los recorre
             if(isset($obj)){
                 $this->{$llave} = $obj[$llave]; //asigna a los atributos del modelo, los valores del objeto
             }
         }
     } catch (Exception $e) {
        throw new Exception("Error en ". $this->className . ".fill() => ". $e->getTraceAsString());

     }
 }

//insertar
 public function insert($obj = null){
  //   var_dump($obj);
     $obj= $this->parsear($obj);
     return parent::insert($obj);
 }

 //actualizar
 public function update($obj = null){
    $obj= $this->parsear($obj);
    return parent::update($obj);
}

//getter
public function __get($nombreAtributo){
    return $this->{$nombreAtributo};
}


//setter
public function __set($nombreAtributo, $valor){
    $this->{$nombreAtributo} = $valor;
}

}
