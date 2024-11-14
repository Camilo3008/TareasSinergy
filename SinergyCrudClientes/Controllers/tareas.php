<?php

require_once("./Models/tareasModel.php");

class Tareas extends Controllers{

    public function __construct(){
        parent::__construct();
    }

    public function tareas(){
        echo "tareassss camilo";
    }

    public function registrarTarea(){
        
        try{
            
            $method = $_SERVER['REQUEST_METHOD'];
            $response = [];
            $code = 0;
            
            if($method === "POST"){

                $_POST = json_decode(file_get_contents(filename:"php://input" ), associative: true);

                
                if (!testString($_POST['titulo'])) {
                    $response = array(
                        "status" => true,
                        "mensaje" => "Ingresar titulo"
                    );
                    $code = 200;
                    jsonResponse($response, 200);
                    die();
                }

                if (empty($_POST['descripcion'])) {
                    $response = array(
                        "status" => true,
                        "mensaje" => "La descripcion es obligatoria"
                    );
                    $code = 200;
                    jsonResponse($response, 200);
                    die();
                }

                $tareasModel = new tareasModel();
                $infoTareasM = $tareasModel->registrarTareas(
                    strtolower($_POST['titulo']),
                    strtolower($_POST['descripcion'])
                );
                if($infoTareasM == true){
                    $response = array(
                        "status" => true,
                        "mensaje" => "Tarea agregada con exito"
                    );
                    $code = 200;
                }else{
                    $response = array(
                        "status" => false,
                        "mensaje" => "Error al agregar tarea"
                    );
                    $code = 400;
                }

            }else{
                $response = array(
                    "status" => false,
                    "mensaje" => "El metodo " . $method . " no es correcto, el metodo correcto es POST"
                );
                $code = 400;
            }

            jsonResponse($response, $code); 

        }catch( Exception $error){
            die("Error en el servidor ". $error->getMessage());
        }
    }

    public function actualizarEstTarea(){
        try{
            $method = $_SERVER['REQUEST_METHOD'];
            $response = [];
            $code = 0 ;

            if($method === "PUT"){
                $_PUT = json_decode(file_get_contents(filename: "php://input"), associative: true);

                $ids = $_PUT['ids'];
                $completado = $_PUT['completado'];

                foreach($ids as $id){
                    $this->model->actualizarEstadoTarea($id, $completado);
                }
                $response = array(
                    "status" => true,
                    "mensaje" => "Tareas actualizadas correctamente"
                ); 
                $code = 200;

            }else{
                $response = array(
                    "status" => false,
                    "mensaje" => "El metodo  " . $method . " es incorrecto, es necesario el metodo PUT"
                );
                $code = 400;
            }
            jsonResponse($response, $code);

        }catch(Exception $error){
            die("Error en el servidor " . $error->getMessage());
        }
    }


    public function actualizarTareas(){
        try{
            $method = $_SERVER['REQUEST_METHOD'];
            $response  = [];
            $code = 0; 

            if($method === "PUT"){
                $_POST = json_decode(file_get_contents(filename: "php://input"), associative: true);
                
                if (!testString($_POST['titulo'])) {
                    $response = array(
                        "status" => true,
                        "mensaje" => "Ingresar titulo"
                    );
                    $code = 200;
                    jsonResponse($response, 200);
                    die();
                }

                if (empty($_POST['descripcion'])) {
                    $response = array(
                        "status" => true,
                        "mensaje" => "La descripcion es obligatoria"
                    );
                    $code = 200;
                    jsonResponse($response, 200);
                    die();
                }

                if(!testNumber($_POST['completado'])){
                    $response = array(
                        "status" => true,
                        "mensaje" => "Ingresar estado de la tarea"
                    );
                    $code = 200;
                    jsonResponse($response, 200);
                    die();
                }

                if(!empty($_GET["id"]) && !testString($_GET["id"])){
                    

                    $tareaModel = new tareasModel();
                    
                    $actualizarModel = $tareaModel->actualizarTarea(
                        $_GET['id'],
                        strtolower($_POST["titulo"]),
                        strtolower($_POST["descripcion"]),
                        $_POST['completado']
                    );


                    if ($actualizarModel == true){
                        $response = array(
                            "status" => true,
                            "mensaje" => "Tarea actualizada "
                        );
                        $code = 200;
                    }else{
                        $response = array(
                            "status" => false,
                            "mensaje" => "Errorno se actualizo la tarea correctamente"
                        );
                        $code = 400;
                    }

                }else{
                    $response = array(
                        "status" => false,
                        "mensaje" => "No se encontró ningún artículo para buscar"
                    );
                    $code = 400; 
                }

            }else{
                $response = array(
                    "status" => false,
                    "mensaje" => "El metodo  " . $method . " es incorrecto, es necesario el metodo PUT"
                );
                $code = 400;
            }

            jsonResponse($response, $code); 

        }catch(Exception $error){
            die("Error en el servidor " . $error->getMessage());
        }

    }


    public function getTarea(){
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            $response = [];
            $code = 0;
  
            if ($method === "GET") {

                if (!empty($_GET["id"]) && !testString($_GET["id"])) {
                    $tareaModels = new tareasModel();
                    $getTarea = $tareaModels->getTareaM($_GET["id"]);
                    
                    if(empty($getTarea)){
                        $response = array(
                            "status" => false,
                            "mensaje" => "No se encontro tarea a "
                        );
                        $code = 400;
                    } else{
                        $response = array(
                            "status" => true,
                            "data" => $getTarea
                        );
                        $code = 200;
                    }
                }
                else{
                    $response = array(
                        "status" => false,
                        "mensaje" => "No se encontro tarea"
                    );
                    $code = 400;
                }
            }
            else{
                $response = array(
                    "status" => false,
                    "mensaje" => "El metodo " . $method . " no es correcto, el metodo correcto es GET"
                );
                $code = 400;
            }

            jsonResponse($response, $code); 

        }
        catch(Exception $err){
            die("Internal Server Error " . $err->getMessage());
        }
    }

    public function getTareasALL(){
        try{
            $method = $_SERVER['REQUEST_METHOD'];
            $response = [];
            $code = 0;

            if($method === 'GET'){
                $tareaModels = new tareasModel();
                $getTareas = $tareaModels->getAllTareasM();

                if(empty($getTareas)){
                    $response = array(
                        "status" => false,
                        "mensaje" => "No se encontraron tareas disponibles"
                    );
                    $code = 400;
                
                }
                else{
                    $response = array(
                        "status" => true,
                        "mensaje" => $getTareas
                    );
                    $code = 200; 
                }
            }
            else{
                $response = array(
                    "status" => false,
                    "mensaje" => "El metodo " . $method . " no es correcto, el metodo correcto es GET"
                );
                $code = 400;  
            }
            jsonResponse($getTareas, $code);
        
        }catch( Exception $err){
            die("Error en el servidor" . $err->getMenssage());
        }
    }

    public function eliminarTareas(){
        try{
            $method = $_SERVER['REQUEST_METHOD'];
            $response = [];
            $code = 0;
            $tareasModel = new tareasModel();

            if($method ==='DELETE'){
                if(!empty($_GET["id"]) && !testString($_GET["id"])){

                    $getTareas = $tareasModel->getTareaM($_GET["id"]);

                    if(empty($getTareas)){
                        $response = array(
                            "status" => false,
                            "mensaje" => "No se encontro la tarea"
                        );
                        $code = 400;
                    }
                    else{
                        $eliminarTarea = $tareasModel->eliminarTarea($_GET["id"]);
                        
                        if($eliminarTarea == true){
                            $response = array(
                                "status" => true,
                                "mensaje" => "La tarea se elimino con exito"
                            );
                            $code = 200;        
                        } 
                        else{
                            $response = array(
                                "status" => false,
                                "mensaje" => "Error al eliminar tarea"
                            );
                            $code = 400; 
                        }
                    }
                }
                else{
                    $response = array(
                        "status" => false,
                        "mensaje" => "No se encontro la tarea"
                    );
                    $code = 400;
                }
            }
            else{
                $response = array(
                    "status" => false,
                    "mensaje" => "El metodo " . $method . " no es correcto, el metodo correcto es GET"
                );
                $code = 400;
            }

            jsonResponse($response, $code);

        }catch(Exception $err){
            die("Error del servidor ". $err->getMessage());
        }
    }
}


