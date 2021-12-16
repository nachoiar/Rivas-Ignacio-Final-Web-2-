<?php
class ClientesModel{

    private $db;
    function __construct(){
         $this->db = new PDO('mysql:host=localhost;'.'dbname=PYF;charset=utf8', 'root', '');
    }


    function getClienteByDni($dni){
        $sentencia = $this->db->prepare( "select * from cliente WHERE dni = ?");
        $sentencia->execute(array($dni));
        $cliente = $sentencia->fetch(PDO::FETCH_OBJ);
        return $cliente;
    }

    function getClienteByIdCompleto($id_cliente){
        $sentencia = $this->db->prepare( " SELECT * from cliente WHERE id_cliente=  ?");
        $sentencia->execute(array($id_cliente));

    }

    function addNuevoCliente($nombre, $dni, $telefono, $direccion, $ejecutivo){
        $sentencia = $this->db->prepare("INSERT INTO cliente(nombre, dni, telefono, direccion, ejecutivo) VALUES(?,?, ?, ?, ?)");
        $sentencia->execute(array($nombre, $dni, $telefono, $direccion, $ejecutivo));
        return $this->db->lastInsertId();
    }

    function addBonus($id_cliente){
        $sentencia = $this->db->prepare("UPDATE actividad SET kms= 200 WHERE id_cliente=?");
        $sentencia->execute(array($id_cliente));
}

//-------------------------------------------------------------------------------------------------


    function getFondosbyDni($dni){
        $sentencia = $this->db->prepare( " SELECT kms from actividad  as A INNER JOIN cliente as C ON 
                                        (A.id_cliente = C.id) WHERE C.dni = ?");
        $sentencia->execute(array($dni));

    }

    function transferencia($kmsQueTransfiere, $dniQueRecibe){
        $sentencia = $this->db->prepare("UPDATE actividad as A SET kms= ? INNER JOIN cliente AS C  ON (A.id_cliente = C.id)  WHERE C.dni = ?");
        $sentencia->execute(array($kmsQueTransfiere, $dniQueRecibe));

    }

//--------------------------------------------------------------------------------------------------------

    function getClienteById($id_cliente){
        $sentencia = $this->db->prepare( " SELECT nombre, dni  from cliente WHERE id_cliente=  ?");
        $sentencia->execute(array($id_cliente));

    }


    function getActividad($id_cliente){
        $sentencia = $this->db->prepare( " SELECT kms, tipo_operacion, fecha from actividad WHERE id_cliente=  ?");
        $sentencia->execute(array($id_cliente));
        
    }

    function getTarjetasByIdCliente($id_cliente){
        $sentencia = $this->db->prepare( " SELECT nro_tarjeta from tarjeta WHERE id_cliente=  ?");
        $sentencia->execute(array($id_cliente));

    }
}