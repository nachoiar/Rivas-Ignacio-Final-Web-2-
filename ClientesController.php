<?php 
require_once "ClientesModel.php";

class ClientesController {
    private $model;

    function __construct(){
        $this->model = new ClientesModel;
        
    }

    function addCliente(){
        $logueado = $this->helper->checkAdminLogin();
        $TarjetaEjecutiva = $this->CardHelper->getBussinesCard();
        if($logueado = 1){
            if(isset($_POST['nombre']) && ($_POST['dni']) && ($_POST['telefono']) && ($_POST['direccion']) && ($_POST['ejecutivo'])){
            $nombre = $_POST['nombre'];
            $dni = $_POST['dni'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];
            $ejecutivo = $_POST['ejecutivo'];
            }
        $cliente = $this->model->getClienteByDni($dni);
        if($cliente){
            $this->view->showError("El dni ingresado ya tiene un usuario vinculado");
        }
            else{
                $id_cliente =$this->model->addNuevoCliente($nombre, $dni, $telefono, $direccion, $ejecutivo);
            }
            if($id_cliente){
                $this->model->addBonus($id_cliente);
                
            }
            else {
                $this->view->showError("El cliente no pudo ser Cargado con exito");
            }
        $clienteRecienCreado = $this->model->getClienteByIdCompleto($id_cliente);
            if($clienteRecienCreado->ejecutivo = 1){
                $this->model->addTarjetaEejecutiva($TarjetaEjecutiva);
            }
        }
        else {
            $this->view->showError("Debe estar logueado un administrador para agregar Clientes");
        }
    }


//------------------------------------------------------------------------------------------------------------------
    
    
    
    function transferencia(){
        $dniLogueado = $this->helper->checklogin();
        if(isset($_POST['dni']) && ($_POST['kms'])){
            $dniQueRecibe = $_POST['dni'];
            $kmsQueTransfiere = $_POST['kms'];
        $fondosLogueado= $this->model->getFondosbyDni($dniLogueado);
        if(($kmsQueTransfiere < $fondosLogueado) && ($this->model->getClienteByDni($dniQueRecibe))){
            $this->model->transferencia($kmsQueTransfiere, $dniQueRecibe);
        }
       }
    }

 //--------------------------------------------------------------------------------------------------------------
 
 


    function resumenDeCuenta($id_cliente){
        $cliente = $this->model->getClienteById($id_cliente);
        $actividad = $this->model->getActividad($id_cliente);
        $totalKM = 0;
           foreach ($actividad as $act){
               if($act->tipo_operacion = 1){
                   $totalKM = ($totalKM + $act->kms);
               }
               if($act->tipo_operacion= 0){
                   $totalKM = ($totalKM - $act->kms);
               }
               
           }
           $tarjetas = $this->model->getTarjetasByIdCliente($id_cliente);
           if(($tarjetas) && ($cliente) &&($actividad)){
               $this->view->showResumen($cliente, $actividad, $tarjetas);
           }
           else{
               $this->view->showError("No se pudo generar el resumen por que faltan datos");
           }



            }
        


}