<?php

class clientModel extends Mysql
{
    private $intIdentificacion;
    private $strNombres;
    private $strApellidos;
    private $intTelefono;
    private $strEmail;
    private $strDireccion;
    private $intEdad;
    private $intId;
    public function __construct()
    {
        parent::__construct();
    }
    public function validateUser($identificacion, $email)
    {
        $this->intIdentificacion = $identificacion;
        $this->strEmail = $email;
        $validateUser = "SELECT identificacion,email from clientes WHERE email = :email  OR identificacion = :identificacion AND status = :status";
        $arraySQL = array(
            ":email" => $this->strEmail,
            ":identificacion" => $this->intIdentificacion,
            ":status" => 1
        );
        $request = $this->select($validateUser, $arraySQL);
        if (empty($request)) {
            return false;
        } else {
            return true;
        }
    }
    public function validateUpdate($id,$identificacion, $email)
    {
        $this->intIdentificacion = $identificacion;
        $this->strEmail = $email;
        $this->intId = $id;
        $validateUser = "SELECT identificacion,email from clientes WHERE id != :id AND (email = :email OR identificacion = :identificacion) AND status = :status";
        $arraySQL = array(
            ":id" => $this->intId,
            ":email" => $this->strEmail,
            ":identificacion" => $this->intIdentificacion,
            ":status" => 1
        );
        $request = $this->select($validateUser, $arraySQL);
        if (empty($request)) {
            return false;
        } else {
            return true;
        }
    }
    public function setClient($nombres, $apellidos, $edad, $identificacion, $telefono, $email, $direccion)
    {

        $this->intIdentificacion = $identificacion;
        $this->strNombres = $nombres;
        $this->strApellidos = $apellidos;
        $this->intTelefono = $telefono;
        $this->strEmail = $email;
        $this->strDireccion = $direccion;
        $this->intEdad = $edad;


        $queryInsertUser = "INSERT INTO clientes (nombres,apellidos,edad,identificacion,telefono,email,direccion) VALUES (:nombres,:apellidos,:edad,:identificacion,:telefono,:email,:direccion)";
        $arrayInfo = array(
            ":nombres" => $this->strNombres,
            ":apellidos" => $this->strApellidos,
            ":edad" => $this->intEdad,
            ":identificacion" => $this->intIdentificacion,
            ":telefono" => $this->intTelefono,
            ":email" => $this->strEmail,
            ":direccion" => $this->strDireccion
        );
        $insert = $this->insert($queryInsertUser, $arrayInfo);

        echo $insert;
        if ($insert) {
            return true;
        } else {
            return false;
        }
    }

    public function getOneClientModel($id)
    {
        $sql = "SELECT * FROM clientes WHERE id = " . $id;
        $request = $this->select_all($sql);
        echo $id;
        return $request;
    }

    public function getAllClientsModel()
    {
        $sql = "SELECT * FROM clientes";
        $request = $this->select_all($sql);

        return $request;
    }
    
    public function updateClient($id, $nombres, $apellidos, $edad, $identificacion, $telefono, $email, $direccion)
    {

        $this->intIdentificacion = $identificacion;
        $this->strNombres = $nombres;
        $this->strApellidos = $apellidos;
        $this->intTelefono = $telefono;
        $this->strEmail = $email;
        $this->strDireccion = $direccion;
        $this->intEdad = $edad;
        $this->intId = $id;


        $queryInsertUser = "UPDATE clientes SET nombres = :nombres, apellidos = :apellidos,edad = :edad,identificacion = :identificacion,telefono = :telefono,email = :email ,direccion = :direccion WHERE id = :id";
        $arrayInfo = array(
            ":id" => $this->intId,
            ":nombres" => $this->strNombres,
            ":apellidos" => $this->strApellidos,
            ":edad" => $this->intEdad,
            ":identificacion" => $this->intIdentificacion,
            ":telefono" => $this->intTelefono,
            ":email" => $this->strEmail,
            ":direccion" => $this->strDireccion
        );
        $update = $this->update($queryInsertUser, $arrayInfo);
        if ($update == true) {
            return true;
        } else {
            return false;
        }
    }
    public function deleteClient($id) {
        $this->intId = $id;
        $sql = "DELETE FROM clientes WHERE id = :id";
        $arrayValues = array(
            ":id" => $this->intId
        );
        $delete = $this->delete($sql,$arrayValues);
        if($delete){
            return true;
        }else{
            return false;
        }
    }
}
