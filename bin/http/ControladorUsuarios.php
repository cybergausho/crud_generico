<?php
class ControladorUsuarios{
    public function __construct(){}
    
    public function insertarUsuario($usuario){
        $usuarioModel = new Usuarios();
        $id = $usuarioModel->insert($usuario);
        return [
            "codigo" => (($id > 0) ? 1 : -1),
            "mensaje" => ($id>0) ? "Se ha insertado el usuario correctamente": "No se pudo insertar el objeto",
            "datos" => $id
        ];
    }

    public function listarUsuarios(){
        $usuarioModel = new Usuarios();
        $lista = $usuarioModel->getAll();
        return [
            "codigo" => ((count($lista)> 0) ? 1 : -1),
            "mensaje" =>((count($lista)> 0) ? "Se ha consultado los registros correctamente" : "No hay regsitro"),
            "datos" => $lista
        ];
    }

    public function actualizarUsuario($usuario){
        $usuarioModel = new Usuarios();
        $actualizados = $usuarioModel->where("id", "=", $usuario["idUsuario"]) //no se puede recibir el id tal como esta en la bd para actualizar
            ->update($usuario);
        return [
            "codigo" => (($actualizados> 0) ? 1 : -1),
            "mensaje" =>($actualizados> 0) ? "Se ha actualizado el registro correctamente" : "No se pudo actualizar el registro",
            "datos" => $actualizados

        ];
    }

    public function eliminarUsuario($usuario){
        $usuarioModel = new Usuarios();
        $eliminados = $usuarioModel->where("id", "=", $usuario)->delete();
        return [
            "codigo" => (($eliminados> 0) ? 1 : -1),
            "mensaje" =>($eliminados> 0) ? "Se ha eliminado el registro correctamente" : "No se pudo eliminar el registro",
            "datos" => $eliminados
        ];
    }

public function buscarUserPorId($idUsuario){
    $usuarioModel = new Usuarios();
    $usuario = $usuarioModel->where("id", "=", $idUsuario)->first(); 
    return [
        "codigo" => (($usuario != null) ? 1 : -1),
        "mensaje" =>($usuario != null) ? "Se ha buscado el registro correctamente" : "No se pudo encontrar el registro",
        "datos" => $usuario
    ];
}

}

?>