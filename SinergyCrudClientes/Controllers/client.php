<?php
require_once("./Models/clientsModel.php");
class Client extends Controllers
{

    public function __construct()
    {
        parent::__construct();
    }

    public function client()
    {
        echo "holaaaaa";
    }
    public function setClient()
    {
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            $response = [];
            $code = 0;
            if ($method === "POST") {
                $_POST  = json_decode(file_get_contents(filename: "php://input"), associative: true);
                $arrayElementsString = [
                    "nombres",
                    "apellidos"
                ];
                $arrayElementsNumber = [
                    "identificacion",
                    "telefono",
                    "edad"

                ];
                $elementsEmail = [
                    "email"
                ];
                $elementsNormal = [
                    "direccion"
                ];
                $responseValidateElements = validateElements($arrayElementsString, $arrayElementsNumber, $elementsEmail, $elementsNormal);

                if (count($responseValidateElements) > 0) {
                    $response = array(
                        "mensaje" => $responseValidateElements,
                        "status" => false
                    );
                } else {

                    $clientModels = new clientModel();
                    $validateUser = $clientModels->validateUser($_POST["identificacion"], $_POST["email"]);


                    if ($validateUser == true) {
                        $response = array(
                            "status" => false,
                            "mensaje" => "El cliente ya se encuentra registrado!!!"
                        );
                        $code = 400;
                    } else {
                        $informationModel = $clientModels->setClient(
                            strtolower($_POST["nombres"]),
                            strtolower($_POST["apellidos"]),
                            strtolower($_POST["edad"]),
                            str_replace(" ", "", $_POST["identificacion"]),
                            str_replace(" ", "", $_POST["telefono"]),
                            str_replace(" ", "", $_POST["email"]),
                            strtolower($_POST["direccion"])
                        );
                        
                        #echo $informationModel;

                        if ($informationModel == true) {
                            $response = array(
                                "status" => true,
                                "mensaje" => "Client Add Correctly"
                            );
                            $code = 200;
                        } else {
                            $response = array(
                                "status" => false,
                                "mensaje" => "Error Client Not Add!!!"
                            );
                            $code = 400;
                        }
                    }
                }
            } else {
                $response = array(
                    "status" => false,
                    "mensaje" => "Method " . $method . " Is Not Correctly, This Request Need Method POST"
                );
                $code = 400;
            }
            jsonResponse($response, $code);
            die();
        } catch (Exception $error) {
            die("Internal Server Error " . $error->getMessage());
        }
    }

    public function getOneClient()
    {
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            $response = [];
            $code = 0;

            if ($method === "GET") {
                if (!empty($_GET["id"]) && !testString($_GET["id"])) {
                    $clientModels = new clientModel();
                    $getClient = $clientModels->getOneClientModel($_GET["id"]);

                    if (empty($getClient)) {
                        $response = array(
                            "status" => false,
                            "mensaje" => "Client Not Found"
                        );
                        $code = 400;
                    } else {
                        $response = array(
                            "status" => true,
                            "mensaje" => $getClient
                        );
                        $code = 200;
                    }
                } else {
                    $response = array(
                        "status" => false,
                        "mensaje" => "No item found to search"
                    );
                    $code = 400;
                }
            } else {
                $response = array(
                    "status" => false,
                    "mensaje" => "This Method " . $method . " is not Correct, This Request Need Method GET"
                );
                $code = 400;
            }
            jsonResponse($response, $code);
        } catch (Exception $err) {
            die("Internal Server Error " . $err->getMessage());
        }
    }
    
    public function getAllClients()
    {

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            $response = [];
            $code = 0;

            if ($method === "GET") {
                $clientModels = new clientModel();
                $getClient = $clientModels->getAllClientsModel();
                if (empty($getClient)) {
                    $response = array(
                        "status" => false,
                        "mensaje" => "Clients Not Found"
                    );
                    $code = 400;
                } else {
                    $response = array(
                        "status" => true,
                        "mensaje" => $getClient
                    );
                    
                    $code = 200;
                }
            } else {
                $response = array(
                    "status" => false,
                    "mensaje" => "This Method " . $method . " is not Correct, This Request Need Method GET"
                );
                $code = 400;
            }
            jsonResponse($response, $code);
        } catch (Exception $err) {
            die("Internal Server Error " . $err->getMessage());
        }
    }

    public function updateClient($id)
    {
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            $response = [];
            $code = 0;
            if ($method === "PUT") {
                $_POST  = json_decode(file_get_contents(filename: "php://input"), associative: true);
                $arrayElementsString = [
                    "nombres",
                    "apellidos"
                ];
                $arrayElementsNumber = [
                    "identificacion",
                    "telefono",
                    "edad"
                ];
                $elementsEmail = [
                    "email"
                ];
                $elementsNormal = [
                    "direccion"
                ];
                $responseValidateElements = validateElements($arrayElementsString, $arrayElementsNumber, $elementsEmail, $elementsNormal);

                if (count($responseValidateElements) > 0) {
                    $response = array(
                        "mensaje" => $responseValidateElements,
                        "status" => false
                    );
                } else {
                    if (!empty($_GET["id"]) && !testString($_GET["id"])) {
                        $clientModels = new clientModel();
                        $getClient = $clientModels->getOneClientModel($_GET["id"]);
                        if (empty($getClient)) {
                            $response = array(
                                "status" => false,
                                "mensaje" => "Client Not Found"
                            );
                            $code = 400;
                        } else {
                            $validateUser = $clientModels->validateUpdate($_GET["id"], $_POST["identificacion"], $_POST["email"]);

                            if ($validateUser == true) {
                                $response = array(
                                    "status" => false,
                                    "mensaje" => "Client Exits!!!"
                                );
                                $code = 400;
                            } else {
                                $informationModel = $clientModels->updateClient(
                                    $_GET["id"],
                                    strtolower($_POST["nombres"]),
                                    strtolower($_POST["apellidos"]),
                                    strtolower($_POST["edad"]),
                                    str_replace(" ", "", $_POST["identificacion"]),
                                    str_replace(" ", "", $_POST["telefono"]),
                                    str_replace(" ", "", $_POST["email"]),
                                    strtolower($_POST["direccion"])
                                );

                                if ($informationModel == true) {
                                    $response = array(
                                        "status" => true,
                                        "mensaje" => "Client Update Correctly"
                                    );
                                    $code = 200;
                                } else {
                                    $response = array(
                                        "status" => false,
                                        "mensaje" => "Error Client Not Update!!!"
                                    );
                                    $code = 400;
                                }
                            }
                        }
                    } else {
                        $response = array(
                            "status" => false,
                            "mensaje" => "No item found to search"
                        );
                        $code = 400;
                    }
                }
            } else {
                $response = array(
                    "status" => false,
                    "mensaje" => "Method " . $method . " Is Not Correctly, This Request Need Method PUT"
                );
                $code = 400;
            }
            jsonResponse($response, $code);
            die();
        } catch (Exception $error) {
            die("Internal Server Error " . $error->getMessage());
        }
    }

    public function deleteClient($id)
    {
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            $response = [];
            $code = 0;
            $clientModels = new clientModel();
            if ($method === "DELETE") {
                if (!empty($_GET["id"]) && !testString($_GET["id"])) {
                    

                    $getClient = $clientModels->getOneClientModel($_GET["id"]);
                    if (empty($getClient)) {
                        $response = array(
                            "status" => false,
                            "mensaje" => "Client Not Found"
                        );
                        $code = 400;
                    } else {
                        $deleteClient = $clientModels->deleteClient($_GET["id"]);
                        if($deleteClient == true){
                            $response = array(
                                "status" => true,
                                "mensaje" => "Client DELETE Correctly"
                            );
                            $code = 200;
                        }else{
                            $response = array(
                                "status" => false,
                                "mensaje" => "Error: Client Not DELETE!!"
                            );
                            $code = 400;
                        }
                    }
                } else {
                    $response = array(
                        "status" => false,
                        "mensaje" => "No item found to search"
                    );
                    $code = 400;
                }
            } else {
                $response = array(
                    "status" => false,
                    "mensaje" => "This Method " . $method . " is not Correct, This Request Need Method DELETE"
                );
                $code = 400;
            }
            jsonResponse($response, $code);
        } catch (Exception $err) {
            die("Internal Server Error " . $err->getMessage());
        }
    }
}
