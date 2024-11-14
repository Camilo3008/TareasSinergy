<?php

class tareasModel extends Mysql{
    
    private $intIdTarea;
    private $strTitulo;
    private $strDescripcion;
    private $intCompletado;

    public function __construct(){
        parent::__construct();
    }

    public function registrarTareas(string $titulo, string $descripcion ){

        $this->strTitulo = $titulo;
        $this->strDescripcion = $descripcion;

        $queryInsert = "INSERT INTO tareas (titulo, descripcion) VALUES (:titulo, :descripcion)  ";

        $arrayInfo = array(
            ":titulo" => $this->strTitulo,
            ":descripcion" => $this->strDescripcion
        ); 

        $insert = $this->insert($queryInsert, $arrayInfo);

        if ($insert) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarTarea(int $id, string $titulo, string $descripcion, string $completado){

        $this->strTitulo = $titulo;
        $this->strDescripcion = $descripcion;
        $this->intCompletado = $completado;
        $this->intIdTarea = $id;

        $queryInsert = "UPDATE tareas SET titulo = :titulo, descripcion = :descripcion,  completado = :completado WHERE id_tareas = :id";

        $arrayInfo = array(
            ":titulo" => $this->strTitulo,
            ":descripcion" => $this->strDescripcion, 
            ":completado"=> $this->intCompletado,
            ":id" =>$this->intIdTarea
        );

        $update = $this->update($queryInsert, $arrayInfo);

        if($update == true){
            return true;
        } else {
            return false;
        }
    }

    public function actualizarEstadoTarea(int $id, string $completado){


        $this->intCompletado = $completado;
        
        $this->intIdTarea = $id;

        $queryInsert = "UPDATE tareas SET   completado = :completado WHERE id_tareas = :id";

        $arrayInfo = array(
            ":completado"=> $this->intCompletado,
            ":id" =>$this->intIdTarea
        );

        $update = $this->update($queryInsert, $arrayInfo);

        if($update == true){
            return true;
        } else {
            return false;
        }
    }


    public function getAllTareasM(){
        $sql = "SELECT * FROM tareas";
        $respuesta = $this->select_all($sql); 

        return $respuesta;
    }

    public function getTareaM($id){
        $sql = "SELECT * FROM tareas WHERE  id_tareas = ". $id ;
        $request = $this->select_all($sql);

        return $request; 
    }

    


    public function eliminarTarea($id){

        $this->intIdTarea = $id;

        $sql = "DELETE FROM tareas WHERE id_tareas = :id";

        $arrayValues = array(
            ":id"=> $this->intIdTarea
        );
        $deleted = $this->delete($sql, $arrayValues);
    
        if($deleted){
            return true;
        }
        else{
            return false; 
        }

    }



}


?>