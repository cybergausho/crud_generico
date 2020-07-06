<?php

class Crud
{
    protected $tabla;
    protected $conexion;
    protected $wheres = "";
    protected $sql = null;

    public function __construct($tabla = null)
    {
        $this->conexion = (new Conexion())->conectar();
        $this->tabla = $tabla;
    }


    //ver todas las filas
    public function getAll()
    {
        try {
            //query reutilizable
            $this->sql = "SELECT * FROM {$this->tabla} {$this->wheres}";
            //preprando la transaccion / referencia
            $sth = $this->conexion->prepare($this->sql);
            //ejecuta
            $sth->execute();
            //devuelve la info en objetos
            return $sth->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            echo "no no no";
            echo $e->getTraceAsString();
        }
    }
//utilizado para registros unicos
    public function first(){
        $lista = $this->getAll();
        if(count($lista) > 0){
            return $lista[0];
        }else{
            return null;
        }
    }


    //insertar datos
    public function insert($obj)
    {
        //recibimos un objeto
        try {
            //comilla sql-> alt + 96
            //implode une arreglos con las llave concatenadas...
            $campos = implode("`, `", array_keys($obj));             //genera estructura tipo `nombre`, `apellido`, etc...
            $valores = ":" . implode(", :", array_keys($obj));         //genera estructura tipo `:nombre`, `:apellido`, etc...
            $this->sql = "INSERT INTO {$this->tabla} (`{$campos}`) VALUES ({$valores})";
            $this->ejecutar($obj);             //funcion para ejecuta
            $id = $this->conexion->lastInsertId(); //metodo devuelve ultima id insertada
            return $id; //devuelve el ultimo id
        } catch (Exception $e) {
            echo $e->getTraceAsString();
        }
    }
    //actualizar
    public function update($obj)
    {
        try {
            $campos = ""; //campos string
            foreach ($obj as $llave => $valor) { //recorrer atributos (llaves) del objeto
                $campos .= "`$llave`=:$llave,";  //settea tipo `nombres`=:nombres...,
            }
            $campos = rtrim($campos, ",");  //elimina la ultima coma
            $this->sql = "UPDATE {$this->tabla} SET {$campos} {$this->wheres}"; //crea query
            $filasAfectadas = $this->ejecutar($obj); //funcion ejecutar
            return $filasAfectadas;
        } catch (Exception $e) {
            echo $e->getTraceAsString();
        }
    }

    //eliminar registro
    public function delete()
    {
        try {
            $this->sql = "DELETE FROM {$this->tabla} {$this->wheres}";
            //echo $this->sql;
            $filasAfectadas = $this->ejecutar();
            return $filasAfectadas;
        } catch (Exception $e) {
            echo $e->getTraceAsString();
        }
    }

    //crea un where con un and
    public function where($llave, $condicion, $valor)
    {
        $this->wheres .= (strpos($this->wheres, "WHERE")) ? " AND " : " WHERE "; //valida si el where,  concatena con un and, sino declara el where
        $this->wheres .= "`$llave` $condicion" .((is_string($valor)) ? "\"$valor\"" : $valor) . ""; //le pasa al where la condicion y si es string, concatena comilla doble o como numero
        return $this;
    }

    //crea un where con un or
    public function orWhere($llave, $condicion, $valor)
    {
        $this->wheres .= (strpos($this->wheres, "WHERE")) ?  "OR " : " WHERE "; //valida si el where,  concatena con un or, sino declara el where
        $this->wheres .= "`$llave` $condicion" . ((is_string($valor)) ? "\"$valor\"" : $valor) . ""; //le pasa al where la condicion y si es string, concatena comilla doble o como numero
        return $this;
    }



    //ejecuta query
    private function ejecutar($obj = null)
    {
        $sth = $this->conexion->prepare($this->sql); //recibe la consulta
//        var_dump($sth);
        if ($obj !== null) {  //comprueba que el el objeto no sea null
            foreach ($obj as $llave => $valor) { //recorre las llaves (valores) del objeto
                if (empty($valor)) { //si el valor esta indefinido, sera null
                    $valor = NULL;
                }
                $sth->bindValue(":$llave", $valor); //settear valores del objeto a lo que hemos concatenado en la consulta
            }
        }
            // echo "<br>";
            // var_dump($sth);
            // echo "<br>";
            $sth->execute(); //ejecuta
            $this->reiniciarValores(); //llama funcion reiniciar valores
            return $sth->rowCount(); //retorna numero de filas afectadas
        }

    private function reiniciarValores()
    {
        $this->wheres = ""; //limpia el where
        $this->sql = null; //limpia el query
    }
}
